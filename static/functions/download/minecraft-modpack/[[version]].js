export async function onRequest(context) {
    // Figure out what version was requested
    const url = new URL(context.request.url);
    const version = url.pathname.split("/").pop();

    // Request the file from R2
    let object = await context.env.MC_MODPACK_BUCKET.get(`Evan's Pack-${version}.mrpack`);
    if (object === null) {
        return new Response("Not Found", { status: 404 });
    }

    // Return the file
    return new Response(object, {
        headers: {
            "Content-Type": "application/octet-stream",
            "Content-Disposition": `attachment; filename="Evan's Pack-${version}.mrpack"`,
        },
    });
}