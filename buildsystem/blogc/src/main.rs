use clap::Parser;
use common::model::BlogPost;
use comrak::ComrakOptions;

#[derive(Debug, Parser)]
struct Args {
    /// Blog post `.md` file to compile
    pub input: std::path::PathBuf,

    /// File to write to
    pub output: std::path::PathBuf,
}

#[derive(Debug, serde::Deserialize)]
struct BlogFileHeader {
    pub title: String,
    pub description: String,
    #[serde(default)]
    pub draft: bool,
}

pub fn main() {
    let args = Args::parse();

    // Read the input file
    let input = std::fs::read_to_string(&args.input).unwrap();

    // Parse into a header and body
    let (header, body) = serde_frontmatter::deserialize::<BlogFileHeader>(&input).unwrap();

    // Compile the body into HTML
    let options = ComrakOptions {
        ..ComrakOptions::default()
    };
    let html = comrak::markdown_to_html(&body, &options);

    // Build the intermediary file
    let intermediary = BlogPost{
        title: header.title,
        description: header.description,
        is_draft: header.draft,
        body: html,
    };

    // Write to the output file
    println!("Writing to {:?}", args.output);
    std::fs::create_dir_all(&args.output.parent().unwrap()).unwrap();
    intermediary.write_to_file(&args.output).unwrap();
}
