export async function onRequest(context) {

    // Request our own RSS feed
    let rss_feed = await fetch("https://ewpratten.com/feed.xml");

    // Parse the RSS feed
    let rss_data = await rss_feed.text();
    let rss_parser = new DOMParser();
    let rss_xml = rss_parser.parseFromString(rss_data, "text/xml");

    // Generate the outbox content
    return new Response(
        JSON.stringify({
            "@context": "https://www.w3.org/ns/activitystreams",
            "id": "https://ewpratten.com/api/activitypub/outbox",
            "summary": "Evan Pratten",
            "type": "OrderedCollection",
            "totalItems": rss_xml.getElementsByTagName("item").length,
            "orderedItems": Array.from(rss_xml.getElementsByTagName("item")).map((item) => {
                return {
                    "@context": "https://www.w3.org/ns/activitystreams",
                    "id": item.querySelector("guid").textContent + "-create",
                    "type": "Create",
                    "actor": "https://ewpratten.com/api/activitypub/users/evan",
                    "object": {
                        "id": item.querySelector("guid").textContent,
                        "type": "Note",
                        "content": item.querySelector("title").textContent,
                        "url": item.querySelector("link").textContent,
                        "attributedTo": "https://ewpratten.com/api/activitypub/users/evan",
                        "to": [
                            "https://www.w3.org/ns/activitystreams#Public"
                        ],
                        "published": new Date(item.querySelector("pubDate").textContent).toISOString(),
                    }
                }
            })
        }),
        {
            headers: {
                "Content-Type": "application/activity+json",
            },
        }
    )
}