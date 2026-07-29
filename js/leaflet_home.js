var map, userMarker, providerMarkers = [];
var userLat, userLng;

function initMap(lat, lng) {
    if (map) {
        map.setView([lat, lng], map.getZoom());
        userMarker.setLatLng([lat, lng]);
    } else {
        map = L.map('map').setView([lat, lng], 12);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://carto.com/">CARTO</a>',
            maxZoom: 18
        }).addTo(map);

        var icon = L.divIcon({
            html: '<div style="background:#1a73e8;color:#fff;width:32px;height:32px;border-radius:50%;border:3px solid #fff;display:flex;align-items:center;justify-content:center;font-size:16px;box-shadow:0 2px 8px rgba(0,0,0,0.3)"><i class="fa fa-user"></i></div>',
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        userMarker = L.marker([lat, lng], { draggable: true, icon: icon }).addTo(map);
        userMarker.bindPopup('<strong>Your Location</strong><br><small>Drag to adjust search area</small>');

        userMarker.on('dragend', function(e) {
            var pos = e.target.getLatLng();
            userLat = pos.lat;
            userLng = pos.lng;
            document.getElementById('lat').value = pos.lat.toFixed(6);
            document.getElementById('lon').value = pos.lng.toFixed(6);
            if (window.onMarkerMoved) window.onMarkerMoved();
        });

        map.on('click', function(e) {
            userMarker.setLatLng(e.latlng);
            userLat = e.latlng.lat;
            userLng = e.latlng.lng;
            document.getElementById('lat').value = e.latlng.lat.toFixed(6);
            document.getElementById('lon').value = e.latlng.lng.toFixed(6);
            if (window.onMarkerMoved) window.onMarkerMoved();
        });
    }
    userLat = lat;
    userLng = lng;
}

function updateMap(providers) {
    providerMarkers.forEach(function(m) { map.removeLayer(m); });
    providerMarkers = [];
    if (!providers || providers.length === 0) return;
    var points = [];
    providers.forEach(function(p) {
        var lat = parseFloat(p.latitude), lng = parseFloat(p.longitude);
        if (isNaN(lat) || isNaN(lng)) return;
        var marker = L.marker([lat, lng]).addTo(map);
        var badgeStyle = p.profession === 'electrician' ? '#DF691A' :
                         p.profession === 'plumber' ? '#34a853' : '#4285f4';
        marker.bindPopup(
            '<div style="min-width:200px;color:#333">' +
            '<strong>' + p.name + '</strong><br>' +
            '<span style="background:' + badgeStyle + ';color:#fff;padding:2px 8px;border-radius:4px;font-size:0.8rem">' +
            p.profession + '</span><br>' +
            '<small>' + p.adder + ', ' + p.city + '</small><br>' +
            '<hr style="margin:8px 0">' +
            '<strong>Distance: ' + parseFloat(p.distance).toFixed(1) + ' km</strong><br>' +
            '<a href="booking.php?provider=' + p.id + '" class="btn btn-primary btn-sm mt-2" style="width:100%">Book Now</a>' +
            '</div>'
        );
        providerMarkers.push(marker);
        points.push([lat, lng]);
    });
    points.push([userLat, userLng]);
    if (points.length > 1) {
        map.fitBounds(L.latLngBounds(points), { padding: [50, 50] });
    }
}
