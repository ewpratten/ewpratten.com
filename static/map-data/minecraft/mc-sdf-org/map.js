const TILE_SIZE = 1024;

const WAYPOINTS = {
    subway_stations: [
        { x: -252, z: -433, name: "Northern & Bee Station" },
        { x: -220, z: -186, name: "Monument Place Station" },
        { x: -236, z: -181, name: "[ZOG] Zombie Grinder Station" },
        { x: -204, z: 578, name: "[PMI] Prismarine Inn Station" },
        { x: -322, z: 364, name: "[DSW] Dismal Swamp Station" },
        { x: -322, z: 41, name: "[APY] Apiary Station" },
        { x: -316, z: 43, name: "[APY] Apiary Station" },
        { x: -270, z: 5, name: "Southwest Blvd" },
        { x: -263, z: -45, name: "Southlands" },
        { x: -263, z: -85, name: "Three Sisters" },
        { x: -268, z: -127, name: "Small Hall Station" },
        { x: -256, z: -151, name: "Monument Place Station" },
        { x: -256, z: -180, name: "Zombie Grinder Station" },
        { x: -242, z: -227, name: "DOJO St Station" },
        { x: -202, z: -229, name: "New Cornick House Station" },
        { x: -184, z: -243, name: "Wintergarden Station" },
        { x: 225, z: -293, name: "[PRU] Pine Ruins Station" },
        { x: 143, z: -291, name: "[CSD] Canalside Station" },
        { x: -213, z: -264, name: "Spawn Central Station" },
        { x: -510, z: 137, name: "[SWL] Southwest Landing Station" },
        { x: -326, z: 41, name: "[APY] Apiary Station" },
        { x: -229, z: -181, name: "[ZOG] Zombie Grinder Station" },
        { x: -27, z: 63, name: "[WCP] Whitecaps Station" },
        { x: -27, z: 7, name: "[MTV] Mountain Village Station" },
        { x: -31, z: -237, name: "[ESJ] Eastside Transfer" },
        { x: -245, z: -49, name: "[SOU] Southlands Terminal" },
        { x: -218, z: -137, name: "Monument Place Station" },
        { x: -213, z: -252, name: "Spawn Central Station" },
        { x: -899, z: -607, name: "Mountain Station" },
        { x: -900, z: -4187, name: "Mensa Club Station" },
        { x: -900, z: -2320, name: "Un-Named Interchange" },
        { x: -1630, z: -2316, name: "Farmington Station" },
        { x: -2143, z: -2315, name: "Village Layover Station" },
        { x: -2135, z: -1015, name: "Twin Peaks Station" },
        { x: -2143, z: -1523, name: "Witchy Swamp Station" },
        { x: -2726, z: -186, name: "Ocean Overlook Station" },
        { x: -2111, z: -186, name: "Un-Named Interchange" },
        { x: 927, z: 1223, name: "End Portal Station" },
        { x: -1048, z: -94, name: "Craniumslows Station" },
        { x: -1048, z: -186, name: "Un-Named Interchange" },
        { x: -1375, z: -188, name: "Un-Named Interchange" },
        { x: -1372, z: 507, name: "Sheep Station" },
        { x: -1372, z: 659, name: "Cow Station" },
        { x: -1033, z: 1087, name: "Un-Named Interchange" },
        { x: -1372, z: 1088, name: "South Station" },
        { x: -1568, z: 909, name: "1567 Station" },
        { x: -1372, z: 908, name: "Magenta Station" },
        { x: -980, z: 907, name: "Un-Named Interchange" },
        { x: -891, z: -187, name: "Un-Named Interchange" },
        { x: -700, z: -185, name: "Dark Oak Station" },
        { x: -536, z: -187, name: "Cat Ave Station" },
        { x: -220, z: 1176, name: "End of Line" },
        { x: -220, z: 6, name: "Unknown Station" },
        { x: -219, z: -254, name: "Spawn Glider Port Station" },
        { x: -219, z: -375, name: "Bell Bridge / Changa Station" },
        { x: -219, z: -481, name: "Eccentric Genius Station" },
        { x: -219, z: -552, name: "Xiled Station" },
        { x: -219, z: -650, name: "Nopantsistan Station" },
        { x: -220, z: -1797, name: "[HLV] Highland Village Station" },
        { x: -187, z: -1254, name: "[MSW] Mid-Swamp Station" },
        { x: -187, z: -782, name: "[JOT] Jotaku Station" },
        { x: -197, z: -719, name: "[NSX] Northside Transfer Station" },
        { x: -217, z: -275, name: "Spawn Central Station" },
        { x: -245, z: -366, name: "[NRV] North River Station" },
        { x: -245, z: -258, name: "[CMK] Central Market Station" },
        { x: -219, z: -137, name: "Monument Place Station" },
        { x: -220, z: -137, name: "Monument Place Station" },
        { x: -120, z: -481, name: "Survey Hall Station" },
        { x: -143, z: -304, name: "Inventory Station" },
        { x: -115, z: -256, name: "Spawn Square Station" },
        { x: 63, z: -215, name: "Tek Square Station" },
        { x: -36, z: -225, name: "Manor Ave Station" },
        { x: -141, z: -225, name: "Spawn Square Station" },
        { x: -221, z: -226, name: "DOJO St Station" },
        { x: -389, z: -222, name: "Mob St Station" },
        { x: -491, z: -222, name: "[CAT] Cat Ave Station" },
        { x: -624, z: 310, name: "Garfield Station" },
        { x: -616, z: -222, name: "Castle Square Station" },
        { x: -187, z: -373, name: "[CHA] Changa Station" },
        { x: -187, z: -477, name: "[ECG] Eccentric Genius" },
        { x: -187, z: -575, name: "[XIL] Xiled Station" },
        { x: -187, z: -662, name: "[NOP] Nopantsistan Station" },
        { x: -187, z: -720, name: "[NSX] Northside Transfer" },
        { x: -245, z: -665, name: "[NPN] Nopantsistan Station" },
        { x: -245, z: -543, name: "[LAY] Laydros Station" },
        { x: -900, z: -1992, name: "Red Station" },
        { x: -72, z: -1946, name: "[NSC] North Shore City Terminal" },
        { x: -183, z: -1949, name: "[NSJ] North Shore Junction" },
        { x: -187, z: -1736, name: "[HLV] Highland Village Station" },
        { x: -187, z: -1519, name: "[NDK] North Docks Station" },
        { x: -187, z: -839, name: "[BOH] Boathouse Station" },
        { x: -189, z: -321, name: "[RST] Riverside Station" },
        { x: -213, z: -258, name: "Spawn Central Station" },
    ]
}


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

// Add the layers to the map
L.control.layers(layers).addTo(map);

// Make the viewport look at the center of the map
map.fitBounds([
    [-TILE_SIZE, -TILE_SIZE],
    [TILE_SIZE, TILE_SIZE]
]);

// Add a CSS rule to pixelate the image only when zoomed in 
map.on('zoomend', function (e) {
    if (map.getZoom() >= 2) {
        if (document.querySelector('#leaflet-pixelator')) return;
        document.head.insertAdjacentHTML('beforeend', '<style id="leaflet-pixelator">.leaflet-image-layer { image-rendering: pixelated; }</style>');
    } else {
        document.querySelector('#leaflet-pixelator').remove();
    }
});



// // Add waypoints
// var subway_stations = L.layerGroup();
// WAYPOINTS.subway_stations.forEach(waypoint => {
//     var marker = L.marker([waypoint.z * -1, waypoint.x]).addTo(subway_stations);
//     marker.bindPopup(waypoint.name);
// });
