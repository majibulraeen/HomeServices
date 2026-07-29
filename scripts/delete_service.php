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
    $stmt = DB::query("SELECT image FROM services WHERE id=?", [$id]);
    $service = $stmt->fetch(PDO::FETCH_OBJ);

    if ($service) {
        @unlink('../images/' . $service->image);
        DB::query("DELETE FROM services WHERE id=?", [$id]);
    }
}

header('Location: ../admin_services.php?msg=deleted');
exit();
?>
