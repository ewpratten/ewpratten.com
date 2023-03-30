
export function onRequest(context) {
    return Response.redirect("https://registry.hub.docker.com/v2", 302);
}
