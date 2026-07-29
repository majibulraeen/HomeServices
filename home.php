<?php
include_once "./include/header.php";
include_once "./include/cities.php";
?>

<div class="container py-5" style="margin-bottom: 60px;">
    <div class="text-center mb-4">
        <h2 class="section-title">Find a Service Provider</h2>
        <p class="section-subtitle">Search for trusted professionals near you</p>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" list="cityList" placeholder="Search your city..." autocomplete="off">
                    <datalist id="cityList">
                        <?php foreach ($cities as $city) : ?>
                        <option value="<?= htmlspecialchars($city) ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group col-md-5">
                    <label for="profession">Who's Required</label>
                    <select class="form-control" name="profession" id="profession">
                        <option value="none">Select Profession</option>
                        <option value="electrician">Electrician</option>
                        <option value="plumber">Plumber</option>
                        <option value="mobile">Mobile Repairer</option>
                    </select>
                </div>
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button id="search" class="btn btn-success btn-block" type="button">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lon" name="lon">
        </div>
        <div class="card-footer bg-transparent text-muted small">
            <i class="fa fa-shield"></i> Only verified &amp; online providers appear in results
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div id="map" class="map-container"></div>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table id="providers" class="table table-hover">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Profession</th>
                    <th>Contact</th>
                    <th>Distance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Select city and profession to search...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="js/leaflet_home.js"></script>
<script>
$(function() {
    var defaultLat = 27.7172, defaultLng = 85.3240;
    var userInteracted = false;

    document.getElementById("lat").value = defaultLat;
    document.getElementById("lon").value = defaultLng;
    initMap(defaultLat, defaultLng);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            if (userInteracted) return;
            var lat = pos.coords.latitude;
            var lng = pos.coords.longitude;
            document.getElementById("lat").value = lat.toFixed(6);
            document.getElementById("lon").value = lng.toFixed(6);
            initMap(lat, lng);
        }, function() {}, { enableHighAccuracy: true, timeout: 10000 });
    }

    // Mark as user-interacted when they drag the marker or click the map
    $(document).on('mousedown touchstart', '#map', function() {
        userInteracted = true;
    });

    window.onMarkerMoved = function() {
        var city = $("#city").val().trim();
        var profession = $("#profession").val();
        if (city && profession != "none") {
            $("#search").click();
        }
    };

    $("#search").click(function() {
        var city = $("#city").val().trim();
        var profession = $("#profession").val();
        var lat = $("#lat").val();
        var lon = $("#lon").val();

        if (!city || profession == "none") {
            alert("Please enter a city and select a profession.");
            return;
        }

        $.post('scripts/searchproviders.php', {
            city: city,
            profession: profession,
            lat: lat,
            lon: lon
        }, function(res) {
            var tbody = "";
            try {
                var providers = JSON.parse(res);
                if (providers.failed) {
                    tbody = "<tr><td colspan='7' class='text-center text-muted py-4'>No verified online providers found within 20 km.</td></tr>";
                    updateMap([]);
                } else {
                    providers.forEach(function(provider) {
                        var badge = provider.profession == 'electrician' ? 'badge-warning' :
                                    provider.profession == 'plumber' ? 'badge-success' : 'badge-info';
                        tbody += "<tr>" +
                            "<td><img style='height:60px;width:60px;border-radius:8px;object-fit:cover' src='images/" + provider.photo + "'/></td>" +
                            "<td><strong>" + provider.name + "</strong></td>" +
                            "<td>" + provider.adder + ",<br>" + provider.city + "</td>" +
                            "<td><span class='badge " + badge + "'>" + provider.profession + "</span></td>" +
                            "<td>" + provider.contact + "</td>" +
                            "<td><strong>" + parseFloat(provider.distance).toFixed(1) + " km</strong></td>" +
                            "<td><a href='booking.php?provider=" + provider.id + "' class='btn btn-primary btn-sm'>Book</a></td>" +
                            "</tr>";
                    });
                    updateMap(providers);
                }
            } catch (e) {
                tbody = "<tr><td colspan='7' class='text-center text-danger py-4'>An error occurred.</td></tr>";
            }
            $("#providers tbody").html(tbody);
        });
    });
});
</script>

<?php include_once "./include/footer.php"; ?>
