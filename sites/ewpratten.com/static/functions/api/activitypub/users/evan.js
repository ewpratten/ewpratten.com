export function onRequest(context) {
    return new Response(
        JSON.stringify({
            "@context": [
                "https://www.w3.org/ns/activitystreams",
                "https://w3id.org/security/v1",
                {
                    "@language": "en"
                }
            ],
            "type": "Person",
            "manuallyApprovesFollowers": true,
            "discoverable": true,
            "id": "https://ewpratten.com/api/activitypub/users/evan",
            "outbox": "https://ewpratten.com/api/activitypub/inbox",
            "outbox": "https://ewpratten.com/api/activitypub/outbox",
            "preferredUsername": "evan",
            "name": "Evan Pratten",
            "summary": "I make things",
            "icon": [
                "https://ewpratten.com/images/pfp/2022/460x460.webp"
            ],
            "attachment": [
                {
                    "name": "Website",
                    "type": "PropertyValue",
                    "value": "<a href=\"https://ewpratten.com\" rel=\"me nofollow noopener noreferrer\" target=\"_blank\">ewpratten.com</a>"
                }
            ],
            "publicKey": {
                "@type": "Key",
                "id": "https://ewpratten.com/api/activitypub/users/evan#main-key",
                "owner": "https://ewpratten.com/api/activitypub/users/evan",
                "publicKeyPem": "-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDJwe4jxrpiDx0vzqnoc+3Mja7X\nz73/NxfDqG9Mu+k6Vs87N/+kV4BbsbJ/vtdYAg58+iMDmyRw48CzaXkPDgiCh3RZ\nFc/8GniBSEucjt/QEiAitV48aykqWyXtln0hAmQrjoEeE9DRxS3eyF7FVE2GhkTz\n1YqBabOMpHA1uGOp7QIDAQAB\n-----END PUBLIC KEY-----"
            },
            "url": "https://ewpratten.com",
        }),
        {
            headers: {
                "Content-Type": "application/activity+json",
            },
        }
    )
}