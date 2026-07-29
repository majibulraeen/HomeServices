<?php include_once "./include/header.php"; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Get in Touch</h2>
        <p class="section-subtitle">We'd love to hear from you</p>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-4"><i class="fa fa-map-marker text-primary"></i> Our Address</h5>
                    <p class="mb-1">Online Home Services</p>
                    <p class="text-muted">Lalitpur, Nepal</p>
                    <hr>
                    <h5 class="font-weight-bold mb-4"><i class="fa fa-envelope text-primary"></i> Email</h5>
                    <p class="mb-1">majibul444@gmail.com</p>
                    <p class="text-muted">nirupama@gmail.com</p>
                    <hr>
                    <h5 class="font-weight-bold mb-4"><i class="fa fa-phone text-primary"></i> Phone</h5>
                    <p class="mb-1">+977-9804867811</p>
                    <p class="text-muted">+977-9804756665</p>
                    <hr>
                    <h5 class="font-weight-bold mb-3">Follow Us</h5>
                    <div>
                        <a href="#" class="btn btn-outline-primary btn-sm mr-1"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm mr-1"><i class="fa fa-google-plus"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-4"><i class="fa fa-pencil text-primary"></i> Send a Message</h5>
                    <form action="scripts/aboutrev.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name</label>
                                <input name="Full_Name" placeholder="Your full name" class="form-control" type="text" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Your email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Mobile No.</label>
                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    name="Mobile_No" placeholder="Your mobile number" class="form-control" required type="text" minlength="10" maxlength="10">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Issue Type</label>
                                <select name="inputState" class="form-control">
                                    <option value="new_installation">New Installation</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="feedback">Feedback</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="comment" rows="4" placeholder="Write your message..." class="form-control" required></textarea>
                        </div>
                        <button type="submit" name="review" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
