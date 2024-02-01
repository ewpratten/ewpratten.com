
const TILE_SIZE = 1024;
const TILES = [
    { "chunk_x": 0, "chunk_z": 4, "x": -4096, "z": -512, "image": "0_4_x-4096_z-512.png" },
    { "chunk_x": 1, "chunk_z": 1, "x": -3072, "z": -3584, "image": "1_1_x-3072_z-3584.png" },
    { "chunk_x": 1, "chunk_z": 2, "x": -3072, "z": -2560, "image": "1_2_x-3072_z-2560.png" },
    { "chunk_x": 1, "chunk_z": 3, "x": -3072, "z": -1536, "image": "1_3_x-3072_z-1536.png" },
    { "chunk_x": 1, "chunk_z": 4, "x": -3072, "z": -512, "image": "1_4_x-3072_z-512.png" },
    { "chunk_x": 2, "chunk_z": 0, "x": -2048, "z": -4608, "image": "2_0_x-2048_z-4608.png" },
    { "chunk_x": 2, "chunk_z": 1, "x": -2048, "z": -3584, "image": "2_1_x-2048_z-3584.png" },
    { "chunk_x": 2, "chunk_z": 2, "x": -2048, "z": -2560, "image": "2_2_x-2048_z-2560.png" },
    { "chunk_x": 2, "chunk_z": 3, "x": -2048, "z": -1536, "image": "2_3_x-2048_z-1536.png" },
    { "chunk_x": 2, "chunk_z": 4, "x": -2048, "z": -512, "image": "2_4_x-2048_z-512.png" },
    { "chunk_x": 2, "chunk_z": 5, "x": -2048, "z": 512, "image": "2_5_x-2048_z512.png" },
    { "chunk_x": 3, "chunk_z": 0, "x": -1024, "z": -4608, "image": "3_0_x-1024_z-4608.png" },
    { "chunk_x": 3, "chunk_z": 1, "x": -1024, "z": -3584, "image": "3_1_x-1024_z-3584.png" },
    { "chunk_x": 3, "chunk_z": 2, "x": -1024, "z": -2560, "image": "3_2_x-1024_z-2560.png" },
    { "chunk_x": 3, "chunk_z": 3, "x": -1024, "z": -1536, "image": "3_3_x-1024_z-1536.png" },
    { "chunk_x": 3, "chunk_z": 4, "x": -1024, "z": -512, "image": "3_4_x-1024_z-512.png" },
    { "chunk_x": 3, "chunk_z": 5, "x": -1024, "z": 512, "image": "3_5_x-1024_z512.png" },
    { "chunk_x": 4, "chunk_z": 2, "x": 0, "z": -2560, "image": "4_2_x0_z-2560.png" },
    { "chunk_x": 4, "chunk_z": 3, "x": 0, "z": -1536, "image": "4_3_x0_z-1536.png" },
    { "chunk_x": 4, "chunk_z": 4, "x": 0, "z": -512, "image": "4_4_x0_z-512.png" },
    { "chunk_x": 4, "chunk_z": 5, "x": 0, "z": 512, "image": "4_5_x0_z512.png" },
    { "chunk_x": 5, "chunk_z": 4, "x": 1024, "z": -512, "image": "5_4_x1024_z-512.png" },
    { "chunk_x": 5, "chunk_z": 5, "x": 1024, "z": 512, "image": "5_5_x1024_z512.png" }
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
    var image = L.imageOverlay(`/map-data/minecraft/mc-sdf-org/tiles/${tile.image}`, bounds).addTo(map);
});

// Find the top left and bottom right of the map
var min_x = Math.min.apply(null, TILES.map(tile => tile.x));
var max_x = Math.max.apply(null, TILES.map(tile => tile.x));
var min_z = Math.min.apply(null, TILES.map(tile => tile.z));
var max_z = Math.max.apply(null, TILES.map(tile => tile.z));

map.fitBounds([
    [min_z, min_x],
    [max_z + TILE_SIZE, max_x + TILE_SIZE]
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