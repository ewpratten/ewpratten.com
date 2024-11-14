export function onRequest(context) {
    return new Response(
        JSON.stringify({
            "links": [
                {
                    "href": "https://ewpratten.com/api/activitypub/nodeinfo",
                    "rel": "http://nodeinfo.diaspora.software/ns/schema/2.0"
                }
            ]
        }),
        {
            headers: {
                "Content-Type": "application/jrd+json",
            },
        }
    )
}