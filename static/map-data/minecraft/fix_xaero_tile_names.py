import argparse
import sys
import logging
import re
import json
from pathlib import Path

logger = logging.getLogger(__name__)

def main() -> int:
    # Handle program arguments
    ap = argparse.ArgumentParser(description='Fixes the names of Xaero\'s Minimap tiles to be used in leaflet')
    ap.add_argument('input', help='The input directory containing the tiles', type=Path)
    ap.add_argument('-v', '--verbose', help='Enable verbose logging', action='store_true')
    args = ap.parse_args()

    # Configure logging
    logging.basicConfig(
        level=logging.DEBUG if args.verbose else logging.INFO,
        format='%(levelname)s:	%(message)s',
    )
    
    # Find all PNGs
    pngs = list(args.input.glob('*.png'))
    
    # Look for PNGs with the bad format (0_0_x-1_z-1.png)
    name_re = re.compile(r"(\d+)_(\d+)_x(-?\d+)_z(-?\d+).png")
    tiles = []
    for file in pngs:
        file_name = file.name
        match = name_re.match(file_name)
        if match:
            # Extract the coordinates
            chunk_x, chunk_z, world_x, world_z = match.groups()
            
            # Rename the file
            new_name = f"xaero_tile_{world_x}_{world_z}.png"
            new_path = file.with_name(new_name)
            logger.info(f"Renaming {file_name} to {new_name}")
            file.rename(new_path)
            
            tiles.append({
                "x": int(world_x),
                "z": int(world_z),
                "chunk_x": int(chunk_x),
                "chunk_z": int(chunk_z),
                "image": new_name
            })
            
    # Write a JSON file with the tile data
    with open(args.input / "tiles.json", "w") as f:
        json.dump(tiles, f, indent=4)
        

    return 0

if __name__ == "__main__":
    sys.exit(main())