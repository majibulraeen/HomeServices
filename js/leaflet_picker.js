var pickerMap, pickerMarker;

function initPicker(lat, lng, latFieldId, lngFieldId, mapId) {
    if (pickerMap) {
        pickerMap.setView([lat, lng], 15);
        pickerMarker.setLatLng([lat, lng]);
        document.getElementById(latFieldId).value = lat.toFixed(6);
        document.getElementById(lngFieldId).value = lng.toFixed(6);
        return;
    }

    pickerMap = L.map(mapId).setView([lat, lng], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://carto.com/">CARTO</a>',
        maxZoom: 18
    }).addTo(pickerMap);

    pickerMarker = L.marker([lat, lng], { draggable: true }).addTo(pickerMap);

    document.getElementById(latFieldId).value = lat.toFixed(6);
    document.getElementById(lngFieldId).value = lng.toFixed(6);

    pickerMarker.on('dragend', function(e) {
        var pos = e.target.getLatLng();
        document.getElementById(latFieldId).value = pos.lat.toFixed(6);
        document.getElementById(lngFieldId).value = pos.lng.toFixed(6);
    });

    pickerMap.on('click', function(e) {
        pickerMarker.setLatLng(e.latlng);
        document.getElementById(latFieldId).value = e.latlng.lat.toFixed(6);
        document.getElementById(lngFieldId).value = e.latlng.lng.toFixed(6);
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            var ll = [pos.coords.latitude, pos.coords.longitude];
            pickerMap.setView(ll, 15);
            pickerMarker.setLatLng(ll);
            document.getElementById(latFieldId).value = pos.coords.latitude.toFixed(6);
            document.getElementById(lngFieldId).value = pos.coords.longitude.toFixed(6);
        }, function() {}, { enableHighAccuracy: true, timeout: 5000 });
    }
}
