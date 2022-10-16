---
title: IP Addressing Plan
extra:
    uses_graphviz: true
---

This is a planning document that keeps track of my IP address space. This is by no means complete, just a reference for a specific part of my network.

- `172.23.44.128/25`
  - 
- **`44.31.62.0/24`**: Aggregated at edge
  - `44.31.62.0/25`
    - `44.31.62.0/26`
      - **`44.31.62.0/28`**: Routing infrastructure
      - **`44.31.62.16/28`**: Point-to-Point linking prefix
      - **`44.31.62.32/27`**: Homelab
    - **`44.31.62.64/26`**: Pubnet
      - **`44.31.62.65/32`**: Gateway (`border.lab`)
      - **`44.31.62.66/31`**: Dragon
  - `44.31.62.129/25`
- `2a12:dd47:9000::/36`
  - **`2a12:dd47:9001::/48`**: Pubnet
    - **`2a12:dd47:9001::1/128`**: Gateway (`border.lab`)
    - **`2a12:dd47:9001::2/127`**: Dragon
  - `2a12:dd47:9002::/48`: Point-to-Point linking prefix
    - **`2a12:dd47:9002::/126`**: Links `border.lab` and `bgp-vm.lab`
  - **`2a12:dd47:9003::/48`**: Website infrastructure
  - **`2a12:dd47:9004::/48`**: Homelab