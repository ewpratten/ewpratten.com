#! /bin/bash
set -e

curl --user-agent "AS-SET Builder" \
https://bgp.tools/tags/perso | \
grep  -o "/as/[0-9]*" | \
sort | uniq | sed -e 's#/as/#AS#g' \
> sources/personal-as-stats/personal_ases.txt