<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";
include_once "helpers.php";

if (!check()) {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['register'])) {
    $input = clean($_POST);

    $fields = [
        'name' => $input['name'],
        'contact' => $input['contact'],
        'adder' => $input['adder'],
        'email' => $input['email'],
        'city' => $input['city'],
        'latitude' => $input['latitude'],
        'longitude' => $input['longitude'],
        'descr' => $input['descr'],
        'profession' => $input['profession'],
        'commission_rate' => floatval($input['commission_rate'] ?? 5),
    ];

    $rawPassword = $_POST['password'] ?? '';
    if (!empty($rawPassword)) {
        $fields['password'] = password_hash($rawPassword, PASSWORD_BCRYPT);
    }

    $photo = $_FILES['photo'];
    if (!empty($photo['name'])) {
        $file = upload($photo);
        if ($file === false) {
            header('Location: ../logout.php?msg=file');
            exit();
        }
        $fields['photo'] = $file;
    }

    $sets = implode(', ', array_map(function($col) { return "$col=?"; }, array_keys($fields)));
    $params = array_values($fields);
    $params[] = $_SESSION['user']->id;

    DB::query("UPDATE providers SET $sets WHERE id=?", $params);

    header('Location: ../logout.php');
    exit();
}
?>
