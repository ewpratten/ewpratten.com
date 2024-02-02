import re
import json
import argparse
from pathlib import Path

ap = argparse.ArgumentParser()
ap.add_argument("type", type=str, help="Type of the map", choices=["surface", "caves", "draconic-surface"])
args = ap.parse_args()

TILES_DIR = Path(__file__).parent / "tiles" / args.type
tiles = list(TILES_DIR.glob("*.png"))

TILE_PARTS_RE = re.compile(r"([\d\-]+)_([\d\-]+)_x([\d\-]+)_z([\d\-]+).png")

for tile in tiles:
    tile_name = tile.name
    match = TILE_PARTS_RE.match(tile_name)
    
    if match:
        chunk_x, chunk_z, x, z = match.groups()
        
        print(
            json.dumps(
                {
                    "chunk_x": int(chunk_x),
                    "chunk_z": int(chunk_z),
                    "x": int(x),
                    "z": int(z),
                    "image": tile_name
                }
            ) + ","
        )