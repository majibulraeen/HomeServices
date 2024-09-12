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
    $latitude=$input['latitude'];
    $longitude =$input['longitude'];
    $psin = $input['password'];
    $password=md5($psin);
    $profession = $input['profession'];

    $photo = $_FILES['photo'];

    $file1 = upload($photo);

    if ($file1 === false) {
        header('Location: ../register.php?msg=file'); // Corrected
        exit();
    }

    $isProviderCreated = DB::query("INSERT INTO providers VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
        $name, $contact, $descr, $adder, $email, $city,$latitude,$longitude, $password, $file1, $profession
    ]);

    if ($isProviderCreated) {
        header('Location: ../register.php?msg=success');
        exit();
    } else {
        unlink('../storage/'.$file1);
        header('Location: ../register.php?msg=failed');
        exit();
    }
}
?>
