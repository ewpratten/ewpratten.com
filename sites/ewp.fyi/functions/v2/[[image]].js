// This function acts as a proxy for the OCI Distribution API
// It will redirect requests to the ghcr.io domain and inject a default user

// Configs for what to do with requests
const DEFAULT_USER = "ewpratten";
const ALLOWED_EXTRA_USERS = [
    
];
// const TARGET_URL = new URL("https://registry.hub.docker.com/v2/");
const TARGET_URL = new URL("https://index.docker.io/v2/");

export function onRequest(context) {

    // Parse the path out of the url
    const url = new URL(context.request.url);

    // Replace the domain and port with the ghcr.io domain
    url.hostname = TARGET_URL.hostname;
    url.port = "";

    // If the path is just /v2 then redirect upstream
    // if (url.pathname == "/v2" || url.pathname == "/v2/") {
    //     return Response.redirect(TARGET_URL.toString(), 302);
    // }

    // // If the path starts with an allowed user, redirect to the new url
    // for (var user of ALLOWED_EXTRA_USERS) {
    //     if (url.pathname.startsWith(`/v2/${user}/`)) {
    //         return Response.redirect(url.toString(), 302);
    //     }
    // }

    // // Inject the default user into the path after /v2/
    // url.pathname = url.pathname.replace("/v2/", `/v2/${DEFAULT_USER}/`);

    // Redirect to the new url
    return Response.redirect(url.toString(), 302);
}
