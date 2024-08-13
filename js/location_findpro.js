function getLocation()
{
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showPosition);

    }
}
function showPosition(position)
{
    document.getElementById("lat").value=+position.coords.latitude;
    document.getElementById("lon").value=+position.coords.longitude;
}