---
title: Blocking and depreferring BGP routes from specific countries
---

Hurricane Electric keeps a somewhat up-to-date list of ASNs registered to each country in the world. This is obtainable via:

```sh
export COUNTRY=CA # This is the country code to look up
curl -A "asd" https://bgp.he.net/country/$COUNTRY | grep -o -E "AS([0-9]+)" | sort | uniq
# You should get a list of ASNs piped to stdout
```

Two types of filters are handy. Blackholing, and depreferring.

