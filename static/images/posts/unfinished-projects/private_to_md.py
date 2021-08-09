import json

file = json.load(open("./privates.json", "r"))
file.reverse()

for entry in file:
    print(f"- `{entry['node']['name']}`\n  - {entry['node']['description']}")