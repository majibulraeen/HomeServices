<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

if (!check()) {
    header('Location: ../logout.php');
    exit();
}

if ($_SESSION['user']->role != 'customer') {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['rate'])) {
    $id = intval($_POST['booking_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }

    $stmt = DB::query("SELECT b.* FROM bookings b WHERE b.id=? AND b.status=3", [$id]);
    $booking = $stmt->fetch(PDO::FETCH_OBJ);

    if ($booking) {
        DB::query("UPDATE bookings SET rating=?, review=? WHERE id=?", [$rating, $review, $id]);
        header('Location: ../user_request.php?msg=rated');
        exit();
    }
}

header('Location: ../user_request.php');
exit();
?>
