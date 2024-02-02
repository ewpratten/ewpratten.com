const TILE_SIZE = 1024;


// Set up the map
var map = L.map('map', {
    crs: L.CRS.Simple,
    minZoom: -3,
    maxZoom: 3,
    backgroundColor: '#000000',
});
map.attributionControl.addAttribution('With help from: DraconicNEO');

// Create storage for the tile layers
var layers = {
    "Blank": L.layerGroup(),
    "Caves": L.layerGroup(),
    "Surface": L.layerGroup().addTo(map),
};

// Make a request to discover cave tiles
fetch('/map-data/minecraft/mc-sdf-org/tiles/caves/tiles.json')
    .then(response => response.json())
    .then(tiles => {
        // Add each tile
        tiles.forEach(tile => {
            var bounds = [[tile.z * -1, tile.x], [(tile.z + TILE_SIZE) * -1, tile.x + TILE_SIZE]];
            var image = L.imageOverlay(`/map-data/minecraft/mc-sdf-org/tiles/caves/${tile.image}`, bounds).addTo(layers.Caves);
        });
    });
fetch('/map-data/minecraft/mc-sdf-org/tiles/surface/tiles.json')
    .then(response => response.json())
    .then(tiles => {
        // Add each tile
        tiles.forEach(tile => {
            var bounds = [[tile.z * -1, tile.x], [(tile.z + TILE_SIZE) * -1, tile.x + TILE_SIZE]];
            var image = L.imageOverlay(`/map-data/minecraft/mc-sdf-org/tiles/surface/${tile.image}`, bounds).addTo(layers.Surface);
        });
    });

// Create overlay layers
var overlayLayers = {
    "Subway Stations": L.layerGroup().addTo(map),
    "Subway Lines": L.layerGroup().addTo(map),
}
var clickable_areas = L.layerGroup().addTo(map);

// Add markers
fetch('/map-data/minecraft/mc-sdf-org/markers.json')
    .then(response => response.json())
    .then(markers => {
        // Subway Stations
        markers.waypoints.subway_stations.forEach(waypoint => {
            var marker = L.marker([waypoint.z * -1, waypoint.x], { icon: L.icon({ iconUrl: '/map-data/icons/subway.png', iconSize: [16, 16], }) }).addTo(overlayLayers["Subway Stations"]);
            marker.bindPopup(waypoint.name);
        });

        // Areas
        markers.areas.forEach(area => {
            var bounds = [
                [area.top_left.z * -1, area.top_left.x],
                [area.bottom_right.z * -1, area.bottom_right.x],
            ];
            var area_obj = L.rectangle(bounds, { color: "#00000000", fillOpacity: 0.2 }).addTo(clickable_areas);
            area_obj.bindPopup(area.name);
        });
    });
fetch('/map-data/minecraft/mc-sdf-org/subway_lines.json')
    .then(response => response.json())
    .then(lines => {
        lines.forEach(line => {
            // // Iterate over each point pair
            // line.point_pairs.forEach(pair => {
            //     var map_line_obj = L.polyline([
            //         [pair.from.z * -1, pair.from.x],
            //         [pair.to.z * -1, pair.to.x],
            //     ], {
            //         color: line.color,
            //         opacity: 0.5,

            //     }).addTo(overlayLayers["Subway Lines"]);
            //     map_line_obj.bindPopup(line.name);
            // });

            // Each line has a list of line segments
            line.line_segments.forEach(segment => {
                // Each line segment is a list of coordinates
                var coords = segment.map(coord => [coord.z * -1, coord.x]);
                var map_line_obj = L.polyline(coords, {
                    color: line.color,
                    opacity: 0.75,
                }).addTo(overlayLayers["Subway Lines"]);
                map_line_obj.bindPopup(line.name);
            });
        });
    });

// Add the layers to the map
L.control.layers(layers, overlayLayers).addTo(map);

// Make the viewport look at the center of the map
map.fitBounds([
    [-TILE_SIZE, -TILE_SIZE],
    [TILE_SIZE, TILE_SIZE]
]);

// Add a CSS rule to pixelate the image only when zoomed in 
map.on('zoomend', function (e) {
    let element = document.querySelector('#leaflet-pixelator');
    if (map.getZoom() >= 2) {
        if (element) return;
        document.head.insertAdjacentHTML('beforeend', '<style id="leaflet-pixelator">.leaflet-image-layer { image-rendering: pixelated; }</style>');
    } else {
        if (element) {
            element.remove();
        }
    }
});

// Create a mouse position display
var mousePosition = L.control({ position: 'bottomleft' });
mousePosition.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'mouse-position');
    this._div.style.padding = '5px';
    this._div.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
    this._div.style.border = '1px solid #000000';
    this._div.style.borderRadius = '5px';
    this._div.style.display = 'none';
    return this._div;
};
mousePosition.addTo(map);

// Update the mouse position display
map.on('mousemove', function (e) {
    var x = Math.floor(e.latlng.lng);
    var z = Math.floor(e.latlng.lat * -1);
    mousePosition._div.innerHTML = `X: ${x}, Z: ${z}`;
    mousePosition._div.style.display = '';
});
