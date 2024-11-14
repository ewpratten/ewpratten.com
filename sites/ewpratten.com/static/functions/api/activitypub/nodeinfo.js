const RSS_ITEM_PATTERN = /<item>\s+<title>([^<]+)<\/title>\s+<pubDate>([^<]+)<\/pubDate>\s+<author>([^<]+)<\/author>\s+<link>([^<]+)<\/link>\s+<guid>([^<]+)<\/guid>\s+<description[^>]+>([^<]+)<\/description>\s+<\/item>/gm;

export async function onRequest(context) {

    // Request our own RSS feed
    let rss_feed = await fetch("https://ewpratten.com/feed.xml");

    // Parse the RSS feed
    let rss_data = await rss_feed.text();
    let items = rss_data.matchAll(RSS_ITEM_PATTERN);

    // Generate the outbox content
    return new Response(
        JSON.stringify({
            "metadata": {},
            "openRegistrations": false,
            "protocols": [
                "activitypub"
            ],
            "services": {
                "inbound": [],
                "outbound": []
            },
            "software": {
                "name": "Cloudflare Workers",
                "version": "0.0.0"
            },
            "usage": {
                "localPosts": items.length,
                "users": {
                    "activeHalfyear": 1,
                    "activeMonth": 1,
                    "total": 1
                }
            },
            "version": "2.0"
        }
        ),
        {
            headers: {
                "Content-Type": "application/json",
            },
        }
    )
}