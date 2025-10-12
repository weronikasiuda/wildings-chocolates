// Open Street Map embed
// https://leafletjs.com/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof L === 'undefined') {
        return;
    }

    document.querySelectorAll('.map-embed').forEach(function (container) {
        let title = container.dataset.title;
        let icon = container.dataset.icon;
        let zoom = parseInt(container.dataset.zoom, 10);
        let lat = parseFloat(container.dataset.lat);
        let lng = parseFloat(container.dataset.lng);
        let tileUrl = container.dataset.tileUrl;

        let map;

        if (isNaN(lat) || isNaN(lng)) {
            return;
        }

        if (isNaN(zoom)) {
            zoom = 15;
        }

        // Fall back to default tiles
        if (!tileUrl) {
            tileUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
        }

        map = L.map(container).setView([lat, lng], zoom);

        L.tileLayer(tileUrl, {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        if (icon) {
            L.marker([lat, lng], {
                icon: L.icon({
                    iconUrl: icon,
                    iconSize: [40, 40],
                    iconAnchor: [20, 35],
                }),
                title: title
            }).addTo(map);
        }
    });
});
