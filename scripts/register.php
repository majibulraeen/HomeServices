<?php

require_once 'session.php';
require_once 'DB.php';
require_once 'helpers.php';

if (isset($_POST['register'])) {
    $input = clean($_POST);

    $name = $input['name'];
    $contact = $input['contact'];
    $descr = $input['descr'];
    $adder = $input['adder'];
    $email = $input['email'];
    $city = $input['city'];
    $latitude = $input['latitude'];
    $longitude = $input['longitude'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $profession = $input['profession'];
    $commission_rate = isset($input['commission_rate']) ? floatval($input['commission_rate']) : 5.00;

    $photo = $_FILES['photo'];
    $license = $_FILES['license'];

    $file1 = upload($photo);
    if ($file1 === false) {
        header('Location: ../register.php?msg=file');
        exit();
    }

    $file2 = upload($license);
    if ($file2 === false) {
        unlink('../images/' . $file1);
        header('Location: ../register.php?msg=file');
        exit();
    }

    $sql = "INSERT INTO providers 
            (id, name, contact, descr, adder, email, city, latitude, longitude, password, photo, profession, verified, license_doc, is_online, commission_rate) 
            VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, 0, ?)";

    $isProviderCreated = DB::query($sql, [
        $name, $contact, $descr, $adder, $email, $city,
        $latitude, $longitude, $password, $file1, $profession,
        $file2, $commission_rate
    ]);

    if ($isProviderCreated) {
        header('Location: ../register.php?msg=success');
        exit();
    } else {
        unlink('../images/' . $file1);
        unlink('../images/' . $file2);
        header('Location: ../register.php?msg=failed');
        exit();
    }
}
?>
