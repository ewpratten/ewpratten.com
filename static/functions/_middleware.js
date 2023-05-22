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
    // await fetch()

    // Execute the rest of the request chain
    let response = await context.next();

    // For debugging, allow the requester to expose the body through a response header
    if (url.searchParams.get('goat-counter-debug') == 'true') {
        response.headers.set('X-GoatCounter-Payload', JSON.stringify(payload));
        response.headers.set('X-GoatCounter-Api-Token', context.env.GOAT_COUNTER_API_KEY);
    }

    // Return the response
    return response;
}

// Chaining
export const onRequest = [goat_counter_analytics];