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
export const onRequest = [redirect_secondary_domains];