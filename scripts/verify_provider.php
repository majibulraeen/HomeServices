<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

if (!check("admin")) {
    header('Location: ../logout.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'verify') {
        DB::query("UPDATE providers SET verified=1 WHERE id=?", [$id]);
        header('Location: ../manageprovider.php?msg=verified');
        exit();
    } elseif ($action === 'unverify') {
        DB::query("UPDATE providers SET verified=0 WHERE id=?", [$id]);
        header('Location: ../manageprovider.php?msg=unverified');
        exit();
    }
}

header('Location: ../manageprovider.php');
exit();
?>
