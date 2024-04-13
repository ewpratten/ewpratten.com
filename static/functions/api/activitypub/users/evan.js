export function onRequest(context) {
    return new Response(
        JSON.stringify({
            "@context": ["https://www.w3.org/ns/activitystreams", { "@language": "en-CA" }],
            "type": "Person",
            "id": "https://ewpratten.com/api/activitypub/users/evan",
            "outbox": "https://ewpratten.com/api/activitypub/outbox",
            "preferredUsername": "evan",
            "name": "Evan Pratten",
            "summary": "",
            "icon": [
                "https://ewpratten.com/images/pfp/2022/460x460.webp"
            ]
        }),
        {
            headers: {
                "Content-Type": "application/activity+json",
            },
        }
    )
}