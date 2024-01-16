async function handle_keys_request(context) {
    // Parse the request URL
    let url = new URL(context.request.url);

    // If the domain is `keys.ewpratten.com`, redirect to `ewpratten.com/keys/...`
    if (url.hostname == 'keys.ewpratten.com') {
        url.hostname = 'ewpratten.com';

        // If there was no path set, return the SSH keys
        if (url.pathname == '/') {
            url.pathname = '/keys/ssh';
        } else {
            url.pathname = '/keys' + url.pathname;
        }

        // Redirect
        return Response.redirect(url, 302);
    }

    // Otherwise, continue the request chain
    return context.next();
}

async function redirect_secondary_domains(context) {
    // Parse the request URL
    let url = new URL(context.request.url);

    // If the request is for any of the secondary domains, redirect to the primary domain
    var secondary_domains = ['va3zza.com', 'evan.pratten.ca', 'evan.warren.pratten.ca'];
    if (secondary_domains.includes(url.hostname)) {
        url.searchParams.set("utm_source", url.hostname);
        url.searchParams.set("utm_campaign", "secondary_domains");
        url.hostname = 'ewpratten.com';
        return Response.redirect(url, 302);
    }

    // Otherwise, continue the request chain
    return context.next();
}


// Chaining
export const onRequest = [handle_keys_request, redirect_secondary_domains];