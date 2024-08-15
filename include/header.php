<?php require_once "scripts/session.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        nav a.nav-link {
            color:black;
            font-weight:bold;
        }
        </style>

    <title>Home Services</title>
</head>

<body onload="getLocation()">
    
    <nav class="nav bg-warning">
        <?php if (!isset($_SESSION['user'])): ?>
        <a class="nav">
        <img style="height: 50px;margin-left: 1px;" src="./images/logo.png" alt="Logo">
        </a>
        <a class="nav-link active" href="index.php">Home</a>
        <a class="nav-link " href="home.php">Find Service Provider</a>
        <a class="nav-link" href="login.php">Login</a>
        <a class="nav-link" href="register.php">Register Service Provider</a>
        <a class="nav-link" href="about.php">About</a>

        <?php elseif ($_SESSION['user']->name == 'admin'): ?>
        <a class="nav">
        <img style="height: 50px;margin-left: 1px;" src="./images/logo.png" alt="Logo">
        </a>
        <a class="nav-link" href="managehall.php">Manage Providers</a>
        <a class="nav-link" href="admin.php">Manage Booking</a>
        <a class="nav-link" href="contact.php">View Contact</a>
        <a class="nav-link" href="logout.php">Log Out</a>

        <?php else: ?>
            <a class="nav">
        <img style="height: 50px;margin-left: 1px;" src="./images/logo.png" alt="Logo">
        </a>
        <a class="nav-link" href="viewrequest.php">View Request</a>
        <a class="nav-link" href="Provider.php">Update Profile</a>
        <a class="nav-link" href="logout.php">Log Out</a>
        <?php endif; ?>

    </nav>