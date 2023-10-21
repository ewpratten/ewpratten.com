import argparse
import sys
import re
import frontmatter
from pathlib import Path

BLOG_POST_RE = re.compile(r"^\d{4}-\d+-\d+-(.*)\.md$")

def main() -> int:
    # Handle program arguments
    ap = argparse.ArgumentParser(
        description="Fixes the `aliases` field in the front matter of markdown files"
    )
    ap.add_argument(
        "--root",
        type=Path,
        default=Path(__file__).parent.parent / "content" / "blog",
        help="The root directory to search for markdown files",
    )
    args = ap.parse_args()
    
    # Find all markdown files
    md_files = list(args.root.glob("**/*.md"))
    print(f"Found {len(md_files)} markdown files")
    
    # Handle each file
    for file in md_files:
        print(f"Processing: {file}")
        
        # Determine what the alias path should be
        title_matches = BLOG_POST_RE.match(file.name)
        if not title_matches:
            print("Skipping file, not a blog post")
            continue
        
        title = title_matches.group(1)
        correct_alias = f"/blog/{title.lower()}"
        print("Correct alias:", correct_alias)
        
        # Load and parse the frontmatter
        post = frontmatter.load(file)
        
        # Get the list of aliases
        aliases = post.metadata.get("aliases", [])
        
        # If the alias is already correct, skip it
        if correct_alias in aliases:
            print("Found correct alias")
            continue
    
        # Otherwise, add the correct alias
        aliases.append(correct_alias)
        
        # Write out the new frontmatter
        post.metadata["aliases"] = aliases
        frontmatter.dump(post, file)
        

    return 0


if __name__ == "__main__":
    sys.exit(main())
