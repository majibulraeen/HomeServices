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
    $stmt = DB::query("SELECT image FROM slides WHERE id=?", [$id]);
    $slide = $stmt->fetch(PDO::FETCH_OBJ);

    if ($slide) {
        @unlink('../images/' . $slide->image);
        DB::query("DELETE FROM slides WHERE id=?", [$id]);
    }
}

header('Location: ../admin_slides.php?msg=deleted');
exit();
?>
