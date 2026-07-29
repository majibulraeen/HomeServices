<?php require_once __DIR__ . "/../scripts/session.php";
if (isset($_SESSION['user']) && $_SESSION['user']->name == 'admin') {
    require_once __DIR__ . "/../scripts/DB.php";
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <title>Home Services</title>
</head>
<body>
    <nav class="top-nav">
        <div class="container d-flex justify-content-end align-items-center py-1">
            <?php if (!isset($_SESSION['user'])): ?>
            <a class="text-white nav-link py-1" href="login.php"><i class="fa fa-sign-in"></i> Login</a>
            <a class="text-white nav-link py-1" href="register.php"><i class="fa fa-user-plus"></i> Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img style="height: 42px;" src="./images/logo.png" alt="Home Services">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ml-auto">
                    <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="home.php">Find Provider</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>

                    <?php elseif ($_SESSION['user']->name == 'admin'): ?>
                    <?php
                        $pendingCount = 0;
                        if (class_exists('DB')) {
                            $pendingCount = DB::query("SELECT COUNT(*) FROM providers WHERE verified=0")->fetchColumn();
                        }
                    ?>
                    <li class="nav-item"><a class="nav-link" href="manageprovider.php">
                        Providers
                        <?php if ($pendingCount > 0): ?>
                        <span class="badge badge-danger"><?= $pendingCount ?></span>
                        <?php endif; ?>
                    </a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_slides.php">Slides</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Messages</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>

                    <?php elseif (isset($_SESSION['user']->role) && $_SESSION['user']->role == 'customer'): ?>
                    <li class="nav-item"><a class="nav-link" href="user_request.php">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="home.php">Find Provider</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="viewrequest.php">Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="Provider.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
