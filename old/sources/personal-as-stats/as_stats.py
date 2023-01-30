import json
from pathlib import Path
import time
from typing import Dict
import requests
import re
import base64


def make_cached_request(url: str, headers: Dict[str, str]) -> str:

    # Encode the url and headers into a filename to use as a cache
    cache_filename = Path("/tmp/as_stats") / base64.b64encode(
        url.encode('utf-8') + str(headers).encode('utf-8')).decode('utf-8')
    print(f"Using cache file: {cache_filename}")

    # Check if the file timestamp of the cache file is older than 30 minutes or the file doesn't exist
    if not cache_filename.exists() or (cache_filename.stat().st_mtime + 1800) < time.time():
        print(f"Making request to {url}")
        
        # Make the request and write it to the cache file
        response = requests.get(url, headers=headers).text
        cache_filename.parent.mkdir(parents=True, exist_ok=True)
        cache_filename.write_text(response)

    # Return the contents of the cache file
    return cache_filename.read_text()


data = make_cached_request("https://bgp.tools/tags/perso.csv",
                           headers={"User-Agent": "ewpratten.com ASN statistics script"})
as_search = re.compile(r"AS(\d+)")
asns = [int(x) for x in as_search.findall(data)]
print(f"Found {len(asns)} personal ASNs in the DFZ")

# Download the full BGP table in JSONL format
bgp_table = make_cached_request("https://bgp.tools/table.jsonl", headers={"User-Agent": "ewpratten.com ASN statistics script"})
routes = {}
for line in bgp_table.splitlines():
    bgp_data = json.loads(line)
    routes.setdefault(bgp_data["ASN"], []).append(bgp_data["CIDR"])

# For each ASN, get some additional data
dataset = []
for asn in asns:
    