---
title: Search
---

<div class="field" width="100%">
  <input type="search" placeholder="Type something" id="searchField" style="width:100%"/>
</div>

<ol id="searchResults" style="max-width:100%"/>

<script src="/elasticlunr.min.js"></script>
<script src="/search_index.en.js"></script>

<script>
    (function (window, document) {
    "use strict";

    const search = (e) => {
        const results = window.searchIndex.search(e.target.value, {
        bool: "OR",
        expand: true,
        });

        const resEl = document.getElementById("searchResults");

        resEl.innerHTML = "";
        if (results) {
            results.map((r) => {
                const { id, title, description } = r.doc;
                const el = document.createElement("li");
                resEl.appendChild(el);

                const h3 = document.createElement("h3");
                el.appendChild(h3);

                const a = document.createElement("a");
                a.setAttribute("href", id);
                a.textContent = title;
                h3.appendChild(a);

                const p = document.createElement("p");
                p.textContent = description;
                el.appendChild(p);
            });
        } 
    };

    // Configure elasticlunr
    window.searchIndex = elasticlunr.Index.load(window.searchIndex);

    // Attach the search bar to the function above
    document.getElementById("searchField").addEventListener("input", search);

    // If the request contains a search query (?q=), just search it
    if (window.location.search.includes("q=")) {
        search({ target: { value: encodeURIComponent(window.location.search.split("=")[1]) } });
    }
    })(window, document);
</script>
