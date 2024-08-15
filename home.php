<?php

include_once "./include/header.php";
$cities = ["Kathmandu", "Lalitpur", "Bhaktapur"];

?>

<h2 class="text-center" style="margin-top: 20px;">Home Services</h2>
<hr>
<div class="container" style="margin-top: 20px; margin-bottom: 60px;">

    <div class="row">
        <div class="form-group col-6">
            <label for="city">City</label>
            <select class="form-control" name="city" id="city">
                <option value="none">-- Select City --</option>
                <?php foreach ($cities as $city) : ?>
                <option value="<?= htmlspecialchars($city) ?>"><?= htmlspecialchars($city) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-6">
            <label for="profession">Who's Required</label>
            <select class="form-control" name="profession" id="profession">
                <option value="none">Select Profession</option>
                <option value="electrician">Electrician</option>
                <option value="plumber">Plumber</option>
                <option value="mobile">Mobile Repairer</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="lat">Latitude:</label>
            <input type="text" class="form-control" id="lat" name="lat" required>
        </div>
        <div class="col-6">
            <label for="lon">Longitude:</label>
            <input type="text" class="form-control" id="lon" name="lon" required>
        </div>
    </div>

    <div class="form-group">
        <button id="search" class="form-control btn btn-success" type="button">Search</button>
    </div>

    <div class="table-responsive">
        <table id="providers" class="table">
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
                    <td colspan="5">Select city and profession...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/location_findpro.js"></script>
<script>
   $(function() {
    $("#search").click(function() {
        var city = $("#city").val();
        var profession = $("#profession").val();
        var lat = $("#lat").val();
        var lon = $("#lon").val();

        if (city == "none" || profession == "none") {
            alert("Please select both city and profession.");
            $("#providers tbody").html("<tr><td colspan='5'>Please select city and profession.</td></tr>");
        } else {
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
                        tbody = "<tr><td colspan='5'>No Service Providers found...</td></tr>";
                    } else {
                        providers.forEach(function(provider) {
                            tbody += "<tr>" +
                                "<td><img style='height:150px' src='images/" + provider.photo + "'/></td>" +
                                "<td>" + provider.name + "</td>" +
                                "<td>" + provider.adder + ",<br>" + provider.city + "</td>" +
                                "<td>" + provider.profession + "</td>" +
                                "<td>" + provider.contact + "</td>" +
                                "<td>" + provider.distance + "km</td>" +
                                "<td><a href='booking.php?provider=" + provider.id + "' class='btn btn-primary btn-block'>Book</a></td>" +
                                "</tr>";
                        });
                    }
                } catch (e) {
                    tbody = "<tr><td colspan='5'>An error occurred while processing your request.</td></tr>";
                    console.error("Error parsing JSON:", e, res);
                }
                $("#providers tbody").html(tbody);
            });
        }
    });
});

</script>
<?php include_once "./include/footer.php"; ?>
