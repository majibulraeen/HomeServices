<?php

require_once 'session.php';
require_once 'DB.php';
require_once 'helpers.php';

if (isset($_POST['login'])) {
    $input = clean($_POST);

    $contact = $input['contact'];
    $psin = $input['password'];
    $password=md5($psin);

    // Check if the user is an admin
    if ($contact == "9804867811" && $password == "0192023a7bbd73250516f069df18b500") {
        $s = new stdClass();
        $s->name = "admin";
        $s->role = "admin"; // Assign role
        $_SESSION['user'] = $s;

        header('Location: ../manageprovider.php');
        exit();
    } else {
        // Check if the user is a provider
        $stmt = DB::query(
            "SELECT * FROM providers WHERE contact=? AND password=?",
            [$contact , $password]
        );
        $provider = $stmt->fetch(PDO::FETCH_OBJ);

        if (isset($provider->name)) {
            $provider->role = "provider"; // Assign role
            $_SESSION['user'] = $provider;

            header('Location: ../viewrequest.php');
            exit();
        } else {
            // Check if the user is a customer
            $stmt = DB::query(
                "SELECT * FROM users WHERE contact=? AND password=?",
                [$contact , $password]
            );
            $customer = $stmt->fetch(PDO::FETCH_OBJ);

            if (isset($customer->name)) {
                $customer->role = "customer"; // Assign role
                $_SESSION['user'] = $customer;

                header('Location: ../user_request.php');
                exit();
            } else {
                // If the login fails
                header('Location: ../login.php?msg=failed');
                exit();
            }
        }
    }
}
