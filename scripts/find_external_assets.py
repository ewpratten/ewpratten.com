import re
from pathlib import Path

REPO_ROOT = Path(__file__).parent.parent

# Find all MD and HTML files
md_files = list(REPO_ROOT.rglob("*.md"))
html_files = list(REPO_ROOT.rglob("*.html"))

# Ignore any files in the `public` directory
md_files = [f for f in md_files if "public" not in f.parts]
html_files = [f for f in html_files if "public" not in f.parts]

# Result storage
external_assets = set()

# Find Markdown images
for file in md_files:
    body = file.read_text()
    for match in re.finditer(r"!\[.*?\]\((.*?)\)", body):
        link = match.group(1)
        if link.startswith("http"):
            external_assets.add((file, link))

# Search HTML
for file in html_files:
    body = file.read_text()
    for match in re.finditer(r'src="(.*?)"', body):
        link = match.group(1)
        if link.startswith("http"):
            external_assets.add((file, link))
                
# Print all external assets
for file_path, link in external_assets:
    # Strip the prefix off the file path
    file_path = file_path.relative_to(REPO_ROOT)
    print(f"{file_path}:\t{link}")