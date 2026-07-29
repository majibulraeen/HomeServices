<?php
include_once "include/header.php";
include_once "scripts/checklogin.php";
include_once "scripts/helpers.php";
include_once "scripts/DB.php";

if (!check("admin")) {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['editprovider'])) {
    $input = clean($_POST);
    $stmt = DB::query("SELECT * FROM providers WHERE id=?", [$input['id']]);
    $providers = $stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
    <?php
    if ($providers) {
        echo '<div class="container py-5" style="margin-bottom: 60px;">
    <h2 class="section-title text-center"> Provider Detail </h2>
    <p class="section-subtitle text-center mb-4">Viewing provider information</p>
    <div class="card"><div class="card-body p-0"><div class="table-responsive">
        <table class="table table-hover mb-0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Email</th>
                <th>City</th>
                <th>Profession</th>
                <th>Photo</th>
            </tr>';
        foreach ($providers as $provider) {
            echo '<tr>';
            echo '<td><strong>#' . htmlspecialchars($provider->id) . '</strong></td>';
            echo '<td>' . htmlspecialchars($provider->name) . '</td>';
            echo '<td>' . htmlspecialchars($provider->contact) . '</td>';
            echo '<td>' . htmlspecialchars($provider->adder) . '</td>';
            echo '<td>' . htmlspecialchars($provider->email) . '</td>';
            echo '<td>' . htmlspecialchars($provider->city) . '</td>';
            echo '<td><span class="badge badge-primary">' . htmlspecialchars($provider->profession) . '</span></td>';
            echo '<td><img src="images/' . htmlspecialchars($provider->photo) . '" alt="Photo" style="height:40px;width:40px;border-radius:8px;object-fit:cover"></td>';
            echo '</tr>';

            $mapLat = htmlspecialchars($provider->latitude);
            $mapLng = htmlspecialchars($provider->longitude);
            $mapName = htmlspecialchars($provider->name);
            $mapAddr = htmlspecialchars($provider->adder) . ', ' . htmlspecialchars($provider->city);
        }

        echo '</table></div></div></div>';

        if (!empty($mapLat) && !empty($mapLng)) {
            echo '<div class="card mt-4">
                <div class="card-header"><h5 class="mb-0"><i class="fa fa-map-marker text-danger"></i> Location Map</h5></div>
                <div class="card-body">
                    <div id="providerMap" class="map-container-sm"></div>
                </div>
            </div>
            <script>
                var pmap = L.map("providerMap").setView([' . $mapLat . ', ' . $mapLng . '], 15);
                L.tileLayer("https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png", {
                    attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://carto.com/">CARTO</a>\'
                }).addTo(pmap);
                L.marker([' . $mapLat . ', ' . $mapLng . ']).addTo(pmap)
                    .bindPopup("<strong>' . $mapName . '</strong><br>' . $mapAddr . '")
                    .openPopup();
            </script>';
        }
    } else {
        echo 'No provider found with the specified ID.';
    }
}
?>
<?php include_once "include/footer.php";
