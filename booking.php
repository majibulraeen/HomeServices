<?php

include_once "./include/header.php";
include_once "./scripts/DB.php";

if (!isset($_GET['provider'])) {
    header('Location: home.php');
    exit();
}

$provider = DB::query("SELECT * FROM providers WHERE id=?", [$_GET['provider']])->fetch(PDO::FETCH_OBJ);

if ($provider === false) {
    header('Location: home.php');
    exit();
}

include_once "msg/booking.php";

?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0"><?= $provider->name; ?></h5>
                    <small class="text-muted"><?= $provider->profession; ?></small>
                </div>
                <div class="text-center p-3">
                    <img style="height: 200px; width: 100%; max-width: 300px; object-fit: cover; border-radius: 8px;"
                        src="images/<?= $provider->photo; ?>">
                </div>
                <div class="card-body pt-0">
                    <table class="table table-borderless">
                        <tr>
                            <th class="pl-0">Profession</th>
                            <td><span class="badge badge-primary"><?= $provider->profession; ?></span></td>
                        </tr>
                        <tr>
                            <th class="pl-0">Address</th>
                            <td><?= $provider->adder; ?>, <?= $provider->city; ?></td>
                        </tr>
                        <tr>
                            <th class="pl-0">Contact</th>
                            <td><?= $provider->contact; ?></td>
                        </tr>
                        <tr>
                            <th class="pl-0">Email</th>
                            <td><?= $provider->email; ?></td>
                        </tr>
                    </table>
                    <?php if (!empty($provider->latitude) && !empty($provider->longitude)): ?>
                    <div id="providerMap" class="map-container-sm" style="height: 220px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Book an Appointment</h5>
                </div>
                <div class="card-body">
                    <form action="scripts/bookprovider.php" method="post">
                        <input type="hidden" name="provider" value="<?= $provider->id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Your full name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Contact No.</label>
                                <input name="contact" type="text" class="form-control" placeholder="Mobile number"
                                    minlength="10" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input name="adder" type="text" class="form-control" placeholder="Your address" maxlength="255" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Date</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Estimated Amount (Rs.)</label>
                                <input name="amount" type="number" class="form-control" placeholder="e.g. 1500" min="0" step="0.01" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Payment Mode</label>
                                <select class="form-control" name="payment" required>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Describe your problem</label>
                            <textarea name="queries" class="form-control" rows="4" maxlength="255" placeholder="Tell the provider what you need..."></textarea>
                        </div>
                        <button class="btn btn-primary btn-block mt-3" type="submit" name="book">
                            <i class="fa fa-calendar-check-o"></i> Book Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($provider->latitude) && !empty($provider->longitude)): ?>
<script>
    $(function() {
        var provLat = <?= $provider->latitude ?>;
        var provLng = <?= $provider->longitude ?>;
        var provName = "<?= addslashes($provider->name) ?>";
        var provAddr = "<?= addslashes($provider->adder) ?>, <?= addslashes($provider->city) ?>";

        var map = L.map('providerMap').setView([provLat, provLng], 15);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);
        L.marker([provLat, provLng]).addTo(map)
            .bindPopup('<strong>' + provName + '</strong><br>' + provAddr)
            .openPopup();
    });
</script>
<?php endif; ?>
<?php include_once "include/footer.php"; ?>
