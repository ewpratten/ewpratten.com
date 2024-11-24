use worker::*;

#[event(fetch)]
async fn fetch(request: Request, env: Env, _context: Context) -> Result<Response> {
    console_error_panic_hook::set_once();

    // Split the path into segments
    let url = request.url().unwrap();
    let path_segments = url.path_segments();

    // Handle the sub-paths
    match path_segments {
        Some(path_segments) => match path_segments.collect::<Vec<&str>>().as_slice() {
            // Index
            [""] => Response::from_html(include_str!("../templates/index.html")),

            // Randomizer
            ["random"] => {
                // List the images in the bucket
                let images = env.bucket("IMAGES")?.list().execute().await?.objects();

                // If there's a referer header, make note of the previous image
                let previous_image = request.headers().get("Referer")?.map(|referer| {
                    let referer = referer.split("/").last().unwrap();
                    referer.to_string()
                });

                // Pick a random file name. Don't pick the same one as the previous image
                let images = images.iter().filter(|image| {
                    let image_id = image.key().split(".").next().unwrap().to_string();
                    previous_image != Some(image_id)
                }).collect::<Vec<_>>();
                let random_index = rand::random::<usize>() % images.len();
                let random_image = images.get(random_index).unwrap().key();
                let random_image = random_image.split(".").next().unwrap();

                Response::builder()
                    .with_status(302)
                    .with_header("Location", &format!("/{}", random_image))?
                    .ok("")
            }

            // Image subpage (addressed by numeric ID)
            [id] => {
                // List the images in the bucket
                let images = env.bucket("IMAGES")?.list().execute().await?.objects();

                // Find the first one with a matching name
                let image = images.iter().find(|image| {
                    image.key().split(".").next().unwrap() == *id
                });

                // If no result is found, this image doesn't exist
                if image.is_none() {
                    return Response::error("Not Found", 404);
                }

                // Serve the image
                Response::from_html(format!(
                    include_str!("../templates/image.html"),
                    image_id = id,
                    image_filename = image.unwrap().key()
                ))
            }

            _ => Response::error("Not Found", 404),
        },
        _ => Response::error("Not Found", 404),
    }
}
