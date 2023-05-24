async function redirect_secondary_domains(context) {
    // Parse the request URL
    let url = new URL(context.request.url);

    // If the request is for any of the secondary domains, redirect to the primary domain
    var secondary_domains = ['test.ewp.fyi', 'evan.pratten.ca', 'evan.warren.pratten.ca'];
    if (secondary_domains.includes(url.hostname)) {
        url.hostname = 'ewpratten.com';
        url.searchParams.set("utm_source", url.hostname);
        url.searchParams.set("utm_medium", "redirect");
        url.searchParams.set("utm_campaign", "secondary_domains");
        return Response.redirect(url, 302);
    }

    // Otherwise, continue the request chain
    return context.next();
}

async function goat_counter_analytics(context) {
    // We require some env vars to be set. If they are not, fail the request
    if (!context.env.GOAT_COUNTER_API_KEY) {
        return new Response('$GOAT_COUNTER_API_KEY is not set', { status: 500, headers: { 'Content-Type': 'text/plain' } });
    }
    if (!context.env.GOAT_COUNTER_SITE_CODE) {
        return new Response('$GOAT_COUNTER_SITE_CODE is not set', { status: 500, headers: { 'Content-Type': 'text/plain' } });
    }

    // Parse the request URL
    let url = new URL(context.request.url);

    // Build the payload to send to GoatCounter
    var payload = {
        hits: [
            {
                path: url.pathname,
                query: url.search,
                ref: context.request.headers.get('Referer'),
                location: context.request.cf.country,
                user_agent: context.request.headers.get('User-Agent'),
                session: context.request.cf.botManagement.ja3Hash
            }
        ]
    };

    // Count the goat
    fetch(`https://${context.env.GOAT_COUNTER_SITE_CODE}.goatcounter.com/api/v0/count`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + context.env.GOAT_COUNTER_API_KEY,
        },
        body: JSON.stringify(payload),
    });

    // Execute the rest of the request chain
    let response = await context.next();

    // For debugging, allow the requester to expose the body through a response header
    if (url.searchParams.get('goat-counter-debug') == 'true') {
        response.headers.set('X-GoatCounter-Payload', JSON.stringify(payload));
    }

    // Return the response
    return response;
}

// Chaining
export const onRequest = [redirect_secondary_domains, goat_counter_analytics];