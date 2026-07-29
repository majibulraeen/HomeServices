<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";
include_once "helpers.php";

if (!check("admin")) {
    header('Location: ../logout.php');
    exit();
}

if (isset($_POST['add_slide'])) {
    $input = clean($_POST);
    $image = $_FILES['image'];

    $file = upload($image, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    if ($file === false) {
        header('Location: ../admin_slides.php?msg=failed');
        exit();
    }

    DB::query(
        "INSERT INTO slides (image, title, subtitle, link, sort_order) VALUES (?, ?, ?, ?, ?)",
        [$file, $input['title'] ?? '', $input['subtitle'] ?? '', $input['link'] ?? '', intval($input['sort_order'] ?? 0)]
    );

    header('Location: ../admin_slides.php?msg=added');
    exit();
}

header('Location: ../admin_slides.php');
exit();
?>
