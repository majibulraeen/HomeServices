<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";
include_once "helpers.php";

if (!check("admin")) {
    header('Location: ../logout.php');
    exit();
}

if (isset($_POST['add_service'])) {
    $input = clean($_POST);
    $image = $_FILES['image'];

    $file = upload($image, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    if ($file === false) {
        header('Location: ../admin_services.php?msg=failed');
        exit();
    }

    DB::query(
        "INSERT INTO services (name, description, image, profession, sort_order) VALUES (?, ?, ?, ?, ?)",
        [$input['name'], $input['description'] ?? '', $file, $input['profession'] ?? '', intval($input['sort_order'] ?? 0)]
    );

    header('Location: ../admin_services.php?msg=added');
    exit();
}

header('Location: ../admin_services.php');
exit();
?>
