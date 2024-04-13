export function onRequest(context) {
    return new Response(
        JSON.stringify({
            "subject": "acct:evan@ewpratten.com",
            "aliases": [],
            "links": [
                {
                    "rel": "self",
                    "type": "application/activity+json",
                    "href": "https://ewpratten.com/api/activitypub/users/evan"
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