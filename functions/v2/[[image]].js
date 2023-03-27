
// Configs for what to do with requests
const DEFAULT_USER = "ewpratten";
const ALLOWED_EXTRA_USERS = [
    "bgptools",
    "github"
];

// Info needed in order to partially parse OCIDS API endpoints.
// const POSSIBLE_ACTION_TOKENS = ["blobs", "manifests", "tags", "referrers"];

export function onRequest(context) {

    // Parse the path out of the url
    const url = new URL(context.request.url);

    // Replace the domain and port with the ghcr.io domain
    url.hostname = "ghcr.io";
    url.port = "";

    // If the path is just /v2 then redirect upstream
    if (url.pathname == "/v2" || url.pathname == "/v2/") {
        return Response.redirect("https://ghcr.io/v2/", 302);
    }

    // If the path starts with an allowed user, redirect to the new url
    for (var user of ALLOWED_EXTRA_USERS) {
        if (url.pathname.startsWith(`/v2/${user}/`)) {
            return Response.redirect(url.toString(), 302);
        }
    }

    // Inject the default user into the path after /v2/
    url.pathname = url.pathname.replace("/v2/", `/v2/${DEFAULT_USER}/`);

    // Redirect to the new url
    return Response.redirect(url.toString(), 302);

    // // The first segment of the path is probably the user
    // var path_split = url.pathname.split("/");

    // // The image name is the part between `/vx/` and the first action token
    // var image_name = "";
    // for (var token of path_split) {
    //     if (token == "v2" || token == "") {
    //         continue;
    //     }
    //     if (POSSIBLE_ACTION_TOKENS.includes(token)) {
    //         break;
    //     }
    //     image_name += token + "/";
    // }

    // // The action_url is everything after the image name
    // var action_url = url.pathname.replace(`/v2/${image_name}`, "");

    // // If there is a slash and the first part is not an allowed user, fail
    // var image_name_parts = image_name.split("/");
    // if (image_name_parts.length > 1 && !ALLOWED_USERS.includes(image_name_parts[0])) {
    //     return new Response(`User does not exist ${image_name_parts[0]}`, { status: 404 });
    // }

    // // If there is no slash, add the default user to the image name
    // if (image_name_parts.length == 1) {
    //     image_name = `${DEFAULT_USER}/${image_name}`;
    // }

    // var has_allowed_user = false;
    // for (var user of ALLOWED_USERS) {
    //     if (url.pathname.startsWith(`/v2/${user}/`)) {
    //         has_allowed_user = true;
    //         break;
    //     }
    // }
    // if (!has_allowed_user) {
    //     return new Response(`User does not exist`, { status: 404 });
    // }

    // return Response.redirect(`https://ghcr.io/${url.pathname}`, 302);
}
