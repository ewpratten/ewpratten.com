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
            ],
            "publicKey": {
                "@context": "https://w3id.org/security/v1",
                "@type": "Key",
                "id": "https://ewpratten.com/api/activitypub/users/evan#main-key",
                "owner": "https://ewpratten.com/api/activitypub/users/evan",
                "publicKeyPem": "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDJwe4jxrpiDx0vzqnoc+3Mja7Xz73/NxfDqG9Mu+k6Vs87N/+kV4BbsbJ/vtdYAg58+iMDmyRw48CzaXkPDgiCh3RZFc/8GniBSEucjt/QEiAitV48aykqWyXtln0hAmQrjoEeE9DRxS3eyF7FVE2GhkTz1YqBabOMpHA1uGOp7QIDAQAB"
            }
        }),
        {
            headers: {
                "Content-Type": "application/activity+json",
            },
        }
    )
}