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
        echo '<div class="container" style="margin-top: 30px; margin-bottom: 60px;">
    <h2 class="text-center"> Provider Detail </h2>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Email</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>City</th>
                <th>Profession</th>
                <th>Description</th>
                <th>Photo</th>
            </tr>';
        foreach ($providers as $provider) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($provider->id) . '</td>';
            echo '<td>' . htmlspecialchars($provider->name) . '</td>';
            echo '<td>' . htmlspecialchars($provider->contact) . '</td>';
            echo '<td>' . htmlspecialchars($provider->adder) . '</td>';
            echo '<td>' . htmlspecialchars($provider->email) . '</td>';
            echo '<td>' . htmlspecialchars($provider->latitude) . '</td>';
            echo '<td>' . htmlspecialchars($provider->longitude) . '</td>';
            echo '<td>' . htmlspecialchars($provider->city) . '</td>';
            echo '<td>' . htmlspecialchars($provider->profession) . '</td>';
            echo '<td>' . htmlspecialchars($provider->descr) . '</td>';
            echo '<td><img src="images/' . htmlspecialchars($provider->photo) . '" alt="Provider Photo" height="50"></td>';
            echo '</tr>';
        }

        echo '</table><cente>';
    } else {
        echo 'No provider found with the specified ID.';
    }
}
?>
<?php include_once "include/footer.php";
