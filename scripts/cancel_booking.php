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
    $reason = isset($_GET['reason']) ? trim($_GET['reason']) : '';

    $stmt = DB::query("SELECT * FROM bookings WHERE id=?", [$id]);
    $booking = $stmt->fetch(PDO::FETCH_OBJ);

    if ($booking && ($booking->status == 0 || $booking->status == 1)) {
        $isProvider = ($user->role == 'provider' && $booking->provider_id == $user->id);
        $isCustomer = ($user->role == 'customer');
        $isAdmin = ($user->name == 'admin');

        if ($isProvider || $isCustomer || $isAdmin) {
            DB::query("UPDATE bookings SET status=4, cancellation_reason=? WHERE id=?", [$reason, $id]);
            header('Location: ../' . ($isProvider ? 'viewrequest.php' : ($isCustomer ? 'user_request.php' : 'admin.php')) . '?msg=cancelled');
            exit();
        }
    }
}

header('Location: ../index.php');
exit();
?>
