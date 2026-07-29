<?php
    include_once "scripts/checklogin.php";
    include_once "include/header.php";
    include_once "scripts/DB.php";

    if (!check()) {
        header('Location: logout.php');
        exit();
    }

    $id = intval($_GET['id']);
    $stmt = DB::query("UPDATE bookings SET status=1 WHERE id=? AND status=0", [$id]);

    if ($stmt) {
        header('Location: viewrequest.php?msg=approved');
        exit();
    } else {
        echo "Error updating booking status.";
    }
?>
<?php include_once "include/footer.php"; ?>
