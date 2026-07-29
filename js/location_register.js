document.addEventListener('DOMContentLoaded', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;

            // Show the form if location is obtained
            document.getElementById('locationForm').style.display = 'block';
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
});