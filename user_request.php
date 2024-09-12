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
        nav{
            background-color:#000155;
        }
        nav a.nav-link {
            color:white;
            font-weight:bold;
        }
        </style>

    <title>Home Services</title>
</head>

<body onload="getLocation()">
    
    <nav class="nav">
         <a class="nav">
        <img style="height: 50px;margin-left: 1px;" src="./images/logo.png" alt="Logo">
        </a>
        <a class="nav-link" href="user_request.php">View Request</a>
        <a class="nav-link" href="#">Update Profile</a>
        <a class="nav-link" href="logout.php">Log Out</a>

    </nav>



    <?php
 include_once "scripts/checklogin.php";
    include_once "scripts/DB.php";

    if (!check()) {
        header('Location: logout.php');
        exit();
    }

     $_SESSION['user'];
     $id= $_SESSION['user']->id;
     echo $id;
?>