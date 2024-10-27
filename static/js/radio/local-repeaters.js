// Configure the maps (center on Toronto)
var analog_rpt_map = L.map('analog-repeater-map').setView([43.6532, -79.3832], 8);

// Add OSM base map
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18
}).addTo(analog_rpt_map);

// Process repeater tables
var analog_repeaters = Array.from(document.querySelectorAll("#analog-repeaters tbody tr")).map(function (row) {
    console.log(row);
    return {
        callsign: row.cells[0].innerText,
        downlink: row.cells[1].innerText,
        uplink: row.cells[2].innerText,
        pl_tone: row.cells[3].innerText,
        grid: row.cells[4].innerText,
        latitude: row.cells[4].querySelector("span").attributes["lat"].value,
        longitude: row.cells[4].querySelector("span").attributes["lon"].value,
        reach: row.cells[5].innerText.split(" ")[0],
        linked_repeaters: row.cells[6].innerText.split(", ")
    };
});

// Add repeater markers
analog_repeaters.forEach(function (repeater) {
    console.log(repeater);
    var marker = L.marker([repeater.latitude, repeater.longitude]).addTo(analog_rpt_map);
    marker.bindPopup(`<b>${repeater.callsign}</b>`);
    // marker.setIcon(L.divIcon({
    //     className: 'repeater-marker',
    //     iconSize: [16, 16]
    // }));
});

// Draw the coverage areas
analog_repeaters.forEach(function (repeater) {
    if (repeater.reach != "") {
        var coverage = L.circle([repeater.latitude, repeater.longitude], {
            color: 'gray',
            opacity: 0.25,
            fillColor: 'gray',
            fillOpacity: 0.05,
            radius: repeater.reach * 1000
        }).addTo(analog_rpt_map);
        coverage.bindPopup(`${repeater.callsign} coverage`);
    }
});

// Draw the repeater links
analog_repeaters.forEach(function (repeater) {
    repeater.linked_repeaters.forEach(function (linked_repeater) {
        // Find that repeater
        var linked_repeater_obj = analog_repeaters.find(function (obj) {
            return obj.callsign === linked_repeater;
        });

        if (linked_repeater_obj) {
            var link = L.polyline([
                [repeater.latitude, repeater.longitude],
                [linked_repeater_obj.latitude, linked_repeater_obj.longitude]
            ], {
                color: 'gray',
                weight: 2,
                opacity: 0.75
            }).addTo(analog_rpt_map);
            link.bindPopup(`${repeater.callsign} to ${linked_repeater_obj.callsign}`);
        }
    });
});

// Add a custom CSS style for the markers
// document.head.insertAdjacentHTML('beforeend', `
// <style>
//     .repeater-marker { 
//         background-image: url("/dist/icons8/antenna.png");  
//         background-size: cover;
//         background-position: center;
//         border: 1px solid grey; 
//         border-radius: 50%; 
//     }
// </style>`
// );