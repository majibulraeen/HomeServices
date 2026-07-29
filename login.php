<?php
include_once "./include/header.php";
include_once "./msg/login.php";
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="card">
            <img src="./images/login.png" class="card-img-top" alt="Login">
            <div class="card-body">
                <h3 class="text-center font-weight-bold mb-1">Welcome Back</h3>
                <p class="text-center text-muted mb-4">Sign in to your account</p>

                <form action="scripts/login.php" method="post">
                    <div class="form-group">
                        <label for="contact">Contact No.</label>
                        <input id="contact"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            name="contact" type="text" class="form-control" placeholder="Enter your contact number"
                            minlength="10" maxlength="10" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Enter your password" minlength="4" required>
                    </div>

                    <button class="btn btn-primary btn-block mt-4" type="submit" name="login">Sign In</button>
                </form>

                <p class="text-center text-muted mt-4 mb-0">
                    Don't have an account? <a href="register.php" class="text-primary font-weight-bold">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
