async function goat_counter_analytics(context) {

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

    // Execute the rest of the request chain
    let response = await context.next();

    // For debugging, allow the requester to expose the body through a response header
    if (url.searchParams.get('goat-counter-debug') == 'true') {
        response.headers.set('X-GoatCounter-Payload', JSON.stringify(payload));
        response.headers.set('X-GoatCounter-Api-Token', context.env.GOAT_COUNTER_API_TOKEN);
    }

    // Return the response
    return response;
}

// Chaining
export const onRequest = [goat_counter_analytics];