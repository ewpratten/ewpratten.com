---
title: "INFO: Host naming conventions"
date: 2021-11-23
extra:
    is_rfc: true
    uses_graphviz: false
---

This document quickly outlines my public and private host naming conventions.

## Nov 2021 to Present

*wip*

## Pre Nov 2021

Hosts before ZZANet were named in the following manner:

- 2 character purpose code
- [ISO 3166-1](https://en.wikipedia.org/wiki/ISO_3166-1) Alpha-2 country code
- 3 character city code
- 2 digit discriminator 
- (optional) domain
  
Example hosts are:

| Short          | Long                                | Info                         |
|----------------|-------------------------------------|------------------------------|
| `gw-ca-tor-01` | `gw-ca-tor-01.servers.retrylife.ca` | Toronto gateway server 1     |
| `nl-ca-lon-01` | `nl-ca-lon-01.servers.retrylife.ca` | London network link device 1 |