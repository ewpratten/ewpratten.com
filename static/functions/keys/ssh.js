const SSH_PUBKEYS = {
    devices: {
        desktop: [
            "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGBaSKoWYuR43fxRPy31P/X/2Ri2hYUZTjKiLBRDoa1F"
        ],
        laptop: [
            "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGEqeWe+pVp3rTsmHr9v5Qcb+niHXihJxwVKcc7p6EXz"
        ],
        tablet: [
            "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAID8oqpyU3UW9nLzhTFO6AnDvG2Gf/UQGbB0xgtT8JMmr",
            "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGLF+C47EmbkSlGyJ71yqFy29om1Gs08GZyJN5w7tDRn"
        ],
        "phone": [
            "ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBMbNW3x0Cx04MybxQo5FptZhdjiFJjKITtq67KqrDXAN+jepJwdIG6TUJzuJddztuYIsvPAoQPpiQVSPyC8y51Y=",
        ]
    },
    others: [
        "sk-ssh-ed25519@openssh.com AAAAGnNrLXNzaC1lZDI1NTE5QG9wZW5zc2guY29tAAAAIAkdmKF1cYQTW7cfK7TYC5iVBsAg5g3SRJqlqo2NixHdAAAABHNzaDo="
    ]
}

export function onRequest(context) {
    let request_url = new URL(context.request.url);

    // Check request flags
    let add_host_metadata = request_url.searchParams.has("hosts");
    let add_markers = request_url.searchParams.has("markers");

    // Construct the output
    let output = "";
    for (let key in SSH_PUBKEYS.others) {
        output += `${SSH_PUBKEYS.others[key]}\n`;
    }
    for (let device in SSH_PUBKEYS.devices) {
        for (let key in SSH_PUBKEYS.devices[device]) {
            output += SSH_PUBKEYS.devices[device][key];
            if (add_host_metadata) {
                output += ` ewpratten@ewpratten-${device}\n`;
            } else {
                output += "\n";
            }
        }
    }

    // Add markers if needed
    if (add_markers) {
        output = `\n# --- BEGIN EWPRATTEN SSH KEYS ---\n${output}# --- END EWPRATTEN SSH KEYS ---\n\n`;
    }

    return new Response(output, {
        headers: {
            "Content-Type": "text/plain",
        },
    });
}
