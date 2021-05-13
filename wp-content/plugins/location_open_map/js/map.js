const map = L.map('map')
let el = document.querySelector('.marker')
let point =[el.dataset.lat,el.dataset.lng]


// load a tile layer
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri',
    maxZoom: 18,
}).addTo(map);

map.setView(point, 14);
letmarker = L.marker(point).addTo(map)

