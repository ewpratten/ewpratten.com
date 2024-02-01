
const TILE_SIZE = 1024;
const TILES = [
    { "chunk_x": 0, "chunk_z": 1, "x": -1024, "z": -4096, "image": "0_1_x-1024_z-4096.png" },
    { "chunk_x": 0, "chunk_z": 2, "x": -1024, "z": -3072, "image": "0_2_x-1024_z-3072.png" },
    { "chunk_x": 0, "chunk_z": 3, "x": -1024, "z": -2048, "image": "0_3_x-1024_z-2048.png" },
    { "chunk_x": 0, "chunk_z": 4, "x": -1024, "z": -1024, "image": "0_4_x-1024_z-1024.png" },
    { "chunk_x": 0, "chunk_z": 5, "x": -1024, "z": 0, "image": "0_5_x-1024_z0.png" },
    { "chunk_x": 1, "chunk_z": 0, "x": 0, "z": -5120, "image": "1_0_x0_z-5120.png" },
    { "chunk_x": 1, "chunk_z": 1, "x": 0, "z": -4096, "image": "1_1_x0_z-4096.png" },
    { "chunk_x": 1, "chunk_z": 2, "x": 0, "z": -3072, "image": "1_2_x0_z-3072.png" },
    { "chunk_x": 1, "chunk_z": 3, "x": 0, "z": -2048, "image": "1_3_x0_z-2048.png" },
    { "chunk_x": 1, "chunk_z": 4, "x": 0, "z": -1024, "image": "1_4_x0_z-1024.png" },
    { "chunk_x": 1, "chunk_z": 5, "x": 0, "z": 0, "image": "1_5_x0_z0.png" },
    { "chunk_x": 1, "chunk_z": 6, "x": 0, "z": 1024, "image": "1_6_x0_z1024.png" },
    { "chunk_x": 2, "chunk_z": 0, "x": 1024, "z": -5120, "image": "2_0_x1024_z-5120.png" },
    { "chunk_x": 2, "chunk_z": 1, "x": 1024, "z": -4096, "image": "2_1_x1024_z-4096.png" },
    { "chunk_x": 2, "chunk_z": 2, "x": 1024, "z": -3072, "image": "2_2_x1024_z-3072.png" },
    { "chunk_x": 2, "chunk_z": 3, "x": 1024, "z": -2048, "image": "2_3_x1024_z-2048.png" },
    { "chunk_x": 2, "chunk_z": 4, "x": 1024, "z": -1024, "image": "2_4_x1024_z-1024.png" },
    { "chunk_x": 2, "chunk_z": 5, "x": 1024, "z": 0, "image": "2_5_x1024_z0.png" },
    { "chunk_x": 2, "chunk_z": 6, "x": 1024, "z": 1024, "image": "2_6_x1024_z1024.png" },
    { "chunk_x": 3, "chunk_z": 2, "x": 2048, "z": -3072, "image": "3_2_x2048_z-3072.png" },
    { "chunk_x": 3, "chunk_z": 3, "x": 2048, "z": -2048, "image": "3_3_x2048_z-2048.png" },
    { "chunk_x": 3, "chunk_z": 4, "x": 2048, "z": -1024, "image": "3_4_x2048_z-1024.png" },
    { "chunk_x": 3, "chunk_z": 5, "x": 2048, "z": 0, "image": "3_5_x2048_z0.png" },
    { "chunk_x": 4, "chunk_z": 4, "x": 3072, "z": -1024, "image": "4_4_x3072_z-1024.png" }
]

// Set up the map
var map = L.map('map', {
    crs: L.CRS.Simple,
    minZoom: -3,
    maxZoom: 3,
    backgroundColor: '#000000',
});

// Add each tile to the map
TILES.forEach(tile => {
    var bounds = [[tile.z * -1, tile.x], [(tile.z + TILE_SIZE) * -1, tile.x + TILE_SIZE]];
    var image = L.imageOverlay(`/map-data/minecraft/nwnd-2024-world1/tiles/${tile.image}`, bounds).addTo(map);
});

map.fitBounds([
    [512,1024],
    [1500, 1024]
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