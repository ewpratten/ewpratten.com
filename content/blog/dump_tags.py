import argparse
import sys
import logging
import frontmatter
from pathlib import Path

SCRIPT_DIR = Path(__file__).parent.resolve()

logger = logging.getLogger(__name__)

def main() -> int:
    # Handle program arguments
    ap = argparse.ArgumentParser()
    ap.add_argument('-v', '--verbose', help='Enable verbose logging', action='store_true')
    args = ap.parse_args()

    # Configure logging
    logging.basicConfig(
        level=logging.DEBUG if args.verbose else logging.INFO,
        format='%(levelname)s:	%(message)s',
    )
    
    # Loop through each md file in the directory
    md_files = SCRIPT_DIR.glob('*.md')
    all_tags = []
    for file in md_files:
        with open(file, 'r') as f:
            front = frontmatter.load(f)
            if "tags" in front.keys():
                if isinstance(front["tags"], list):
                    all_tags.extend(front["tags"])
                else:
                    all_tags.append(front["tags"])
                    
    # Remove duplicates
    all_tags = [tag.split(" ") for tag in all_tags]
    all_tags = [item for sublist in all_tags for item in sublist]
    all_tags = list(dict.fromkeys(all_tags))
    
    # Print all tags
    for tag in all_tags:
        print(tag)

    return 0

if __name__ == "__main__":
    sys.exit(main())