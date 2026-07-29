<?php
include_once "scripts/checklogin.php";
include_once "include/header.php";
include_once "./include/cities.php";

if (!check()) {
    header('Location: logout.php');
    exit();
}

$provider = $_SESSION['user'];
?>
<div class="container py-5" style="margin-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h3 class="font-weight-bold mb-1"><?= $provider->name; ?></h3>
                    <p class="text-muted mb-3"><?= $provider->profession; ?> &middot; <?= $provider->city; ?></p>

                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="onlineToggle"
                                <?= ($provider->is_online ?? 0) == 1 ? 'checked' : '' ?>>
                            <label class="custom-control-label font-weight-bold" for="onlineToggle" id="toggleLabel">
                                <span class="badge <?= ($provider->is_online ?? 0) == 1 ? 'badge-success' : 'badge-secondary' ?>" id="toggleBadge">
                                    <i class="fa fa-circle"></i> <?= ($provider->is_online ?? 0) == 1 ? 'Online' : 'Offline' ?>
                                </span>
                            </label>
                        </div>
                    </div>
                    <small class="text-muted">Go online to appear in customer searches and share your live location</small>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-3">Update Your Profile</h5>
                    <hr>

                    <form action="scripts/updateprovider.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input value="<?= $provider->name; ?>" name="name" type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Contact No.</label>
                                <input value="<?= $provider->contact; ?>" name="contact" type="text" class="form-control"
                                    minlength="10" maxlength="10" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input value="<?= $provider->adder; ?>" name="adder" type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input value="<?= $provider->email; ?>" name="email" type="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" id="city" list="cityList"
                                    value="<?= $provider->city; ?>" placeholder="Search your city..." autocomplete="off" required>
                                <datalist id="cityList">
                                    <?php foreach ($cities as $city) : ?>
                                    <option value="<?= htmlspecialchars($city) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Profession</label>
                                <select class="form-control" name="profession">
                                    <option value="electrician">Electrician</option>
                                    <option value="plumber">Plumber</option>
                                    <option value="home_cleaner">Home Cleaning</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Pin your location <small class="text-muted">(drag marker or click)</small></label>
                            <div id="map" class="map-container-sm"></div>
                        </div>
                        <input type="hidden" id="latitude" name="latitude" value="<?= $provider->latitude; ?>">
                        <input type="hidden" id="longitude" name="longitude" value="<?= $provider->longitude; ?>">

                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img style="height: 80px; width: 80px; border-radius: 8px; object-fit: cover;"
                                        src="images/<?= $provider->photo; ?>">
                                    <small class="d-block text-muted">Current</small>
                                </div>
                                <div class="col">
                                    <label>New Photo</label>
                                    <input name="photo" type="file" class="form-control-file">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <textarea name="descr" class="form-control" rows="4" required><?= $provider->descr; ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Commission Rate <small class="text-muted">(%)</small></label>
                                <input name="commission_rate" type="number" class="form-control"
                                    value="<?= $provider->commission_rate ?? 5 ?>" min="1" max="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <input name="password" type="password" class="form-control" placeholder="Enter new password" minlength="4">
                        </div>

                        <button class="btn btn-success btn-block mt-4" type="submit" name="register">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/leaflet_picker.js"></script>
<script>
    var heartbeatInterval = null;

    function startHeartbeat() {
        if (heartbeatInterval) clearInterval(heartbeatInterval);
        if (!navigator.geolocation) return;

        heartbeatInterval = setInterval(function() {
            navigator.geolocation.getCurrentPosition(function(pos) {
                $.post('scripts/location_update.php', {
                    lat: pos.coords.latitude.toFixed(6),
                    lng: pos.coords.longitude.toFixed(6),
                    online: 1
                });
            }, function() {}, { enableHighAccuracy: true, timeout: 10000 });
        }, 30000);
    }

    function stopHeartbeat() {
        if (heartbeatInterval) {
            clearInterval(heartbeatInterval);
            heartbeatInterval = null;
        }
    }

    $('#onlineToggle').change(function() {
        var isOnline = $(this).prop('checked') ? 1 : 0;
        $.post('scripts/provider_toggle.php', { online: isOnline }, function(res) {
            var data = JSON.parse(res);
            if (data.success) {
                var badge = $('#toggleBadge');
                if (data.online == 1) {
                    badge.removeClass('badge-secondary').addClass('badge-success').html('<i class="fa fa-circle"></i> Online');
                    startHeartbeat();
                } else {
                    badge.removeClass('badge-success').addClass('badge-secondary').html('<i class="fa fa-circle"></i> Offline');
                    stopHeartbeat();
                }
            }
        });
    });

    <?php if (($provider->is_online ?? 0) == 1): ?>
    startHeartbeat();
    <?php endif; ?>

    initPicker(
        parseFloat(<?= $provider->latitude ?: 27.7172 ?>),
        parseFloat(<?= $provider->longitude ?: 85.3240 ?>),
        'latitude', 'longitude', 'map'
    );

    $(window).on('beforeunload', function() {
        if ($('#onlineToggle').prop('checked')) {
            navigator.sendBeacon('scripts/provider_toggle.php', new URLSearchParams({ online: '0' }));
        }
    });
</script>
<?php include_once "./include/footer.php"; ?>
