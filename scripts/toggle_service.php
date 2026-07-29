<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

if (!check("admin")) {
    header('Location: ../logout.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    DB::query("UPDATE services SET active = NOT active WHERE id=?", [$id]);
}

header('Location: ../admin_services.php?msg=toggled');
exit();
?>
