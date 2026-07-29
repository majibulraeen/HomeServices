<?php

require_once 'session.php';
require_once 'DB.php';
require_once 'helpers.php';

if (isset($_POST['login'])) {
    $input = clean($_POST);

    $contact = $input['contact'];
    $password = $_POST['password'] ?? '';

    // Admin login (static credentials, kept for backward compat)
    if ($contact == "9804867811" && md5($password) == "0192023a7bbd73250516f069df18b500") {
        $s = new stdClass();
        $s->name = "admin";
        $s->role = "admin";
        $_SESSION['user'] = $s;

        header('Location: ../manageprovider.php');
        exit();
    }

    // Provider login
    $stmt = DB::query("SELECT * FROM providers WHERE contact=?", [$contact]);
    $provider = $stmt->fetch(PDO::FETCH_OBJ);

    if ($provider) {
        $passwordOk = false;

        if (password_verify($password, $provider->password)) {
            $passwordOk = true;
        } elseif (md5($password) === $provider->password) {
            $passwordOk = true;
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            DB::query("UPDATE providers SET password=? WHERE id=?", [$newHash, $provider->id]);
        }

        if ($passwordOk) {
            $provider->role = "provider";
            $_SESSION['user'] = $provider;
            header('Location: ../viewrequest.php');
            exit();
        }
    }

    // Customer login
    $stmt = DB::query("SELECT * FROM users WHERE contact=?", [$contact]);
    $customer = $stmt->fetch(PDO::FETCH_OBJ);

    if ($customer) {
        $passwordOk = false;

        if (password_verify($password, $customer->password)) {
            $passwordOk = true;
        } elseif (md5($password) === $customer->password) {
            $passwordOk = true;
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            DB::query("UPDATE users SET password=? WHERE id=?", [$newHash, $customer->id]);
        }

        if ($passwordOk) {
            $customer->role = "customer";
            $_SESSION['user'] = $customer;
            header('Location: ../user_request.php');
            exit();
        }
    }

    header('Location: ../login.php?msg=failed');
    exit();
}
?>
