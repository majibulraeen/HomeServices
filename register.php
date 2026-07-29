<?php include_once "./include/header.php"; ?>
<?php include_once "./include/cities.php"; ?>
<?php include_once "msg/register.php"; ?>

<div class="container py-5" style="margin-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center font-weight-bold mb-1">Register as Service Provider</h3>
                    <p class="text-center text-muted mb-4">Join our network — get verified and start earning</p>
                    <hr>

                    <form action="scripts/register.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Full name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Contact No.</label>
                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    name="contact" type="text" class="form-control" placeholder="Mobile number"
                                    minlength="10" maxlength="10" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input name="adder" type="text" class="form-control" placeholder="Street address" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Email address" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" id="city" list="cityList"
                                    placeholder="Search your city..." autocomplete="off" required>
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
                            <label>Pin your location on the map <small class="text-muted">(drag marker or click)</small></label>
                            <div id="map" class="map-container-sm"></div>
                        </div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Profile Photo <small class="text-muted">(square preferred)</small></label>
                                <input name="photo" type="file" class="form-control-file" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>License / Certificate <small class="text-muted">(PDF or image)</small></label>
                                <input name="license" type="file" class="form-control-file" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control"
                                    placeholder="Min 4 characters" minlength="4" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Commission Rate <small class="text-muted">(%)</small></label>
                                <input name="commission_rate" type="number" class="form-control" value="5" min="1" max="50" required>
                                <small class="text-muted">Platform commission deducted per booking</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="descr" class="form-control" rows="4"
                                placeholder="Tell customers about your experience and services..." required></textarea>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Your account will be reviewed by admin after registration.
                            You'll only appear in searches once verified.
                        </div>

                        <button class="btn btn-primary btn-block mt-4" type="submit" name="register">
                            <i class="fa fa-user-plus"></i> Register & Submit for Verification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/leaflet_picker.js"></script>
<script>
    initPicker(27.7172, 85.3240, 'latitude', 'longitude', 'map');
</script>
<?php include_once "./include/footer.php"; ?>
