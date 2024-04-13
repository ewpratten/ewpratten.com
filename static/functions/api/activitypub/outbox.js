const RSS_ITEM_PATTERN = /<item>\s+<title>([^<]+)<\/title>\s+<pubDate>([^<]+)<\/pubDate>\s+<author>([^<]+)<\/author>\s+<link>([^<]+)<\/link>\s+<guid>([^<]+)<\/guid>\s+<description[^>]+>([^<]+)<\/description>\s+<\/item>/gm;

export async function onRequest(context) {

    // Request our own RSS feed
    let rss_feed = await fetch("https://ewpratten.com/feed.xml");

    // Parse the RSS feed
    let rss_data = await rss_feed.text();
    let items = rss_data.match(RSS_ITEM_PATTERN);

    // Generate the outbox content
    return new Response(
        JSON.stringify({
            "@context": "https://www.w3.org/ns/activitystreams",
            "id": "https://ewpratten.com/api/activitypub/outbox",
            "summary": "Evan Pratten",
            "type": "OrderedCollection",
            "totalItems": items.length,
            "orderedItems": Array.from(items).map((item) => {
                return {
                    "@context": "https://www.w3.org/ns/activitystreams",
                    "id": item[5] + "-create",
                    "type": "Create",
                    "actor": "https://ewpratten.com/api/activitypub/users/evan",
                    "object": {
                        "id": item[5],
                        "type": "Note",
                        "content": item[1],
                        "url": item[4],
                        "attributedTo": "https://ewpratten.com/api/activitypub/users/evan",
                        "to": [
                            "https://www.w3.org/ns/activitystreams#Public"
                        ],
                        "published": item[2],
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