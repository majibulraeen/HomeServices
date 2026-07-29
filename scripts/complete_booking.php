<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

if (!check()) {
    header('Location: ../logout.php');
    exit();
}

$user = $_SESSION['user'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = DB::query("SELECT * FROM bookings WHERE id=? AND provider_id=?", [$id, $user->id]);
    $booking = $stmt->fetch(PDO::FETCH_OBJ);

    if ($booking && $booking->status == 2) {
        DB::query("UPDATE bookings SET status=3 WHERE id=?", [$id]);
        header('Location: ../viewrequest.php?msg=completed');
        exit();
    }
}

header('Location: ../viewrequest.php');
exit();
?>
