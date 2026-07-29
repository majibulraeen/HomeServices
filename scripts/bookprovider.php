<?php
require_once 'helpers.php';
require_once 'DB.php';

if (isset($_POST['book'])) {
    $input = clean($_POST);

    $provider = $_POST['provider'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $adder = $_POST['adder'];
    $date = $_POST['date'];
    $queries = $_POST['queries'];
    $payment = $_POST['payment'];
    $amount = floatval($_POST['amount']);

    $sql = "INSERT INTO bookings (provider_id, name, contact, adder, status, date, payment, queries, amount) VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?)";
    $isBooked = DB::query($sql, [
        $provider, $name, $contact, $adder, $date, $payment, $queries, $amount
    ]);

    if ($isBooked) {
        header("Location: ../booking.php?provider=$provider&msg=success");
        exit();
    } else {
        header("Location: ../booking.php?provider=$provider&msg=failed");
        exit();
    }
}
?>
