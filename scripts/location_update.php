<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

header('Content-Type: application/json');

if (!check()) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user = $_SESSION['user'];
$id = $user->id;

if (isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['online'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $online = intval($_POST['online']);

    DB::query(
        "UPDATE providers SET current_lat=?, current_lng=?, is_online=? WHERE id=?",
        [$lat, $lng, $online, $id]
    );

    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['error' => 'Missing parameters']);
exit();
?>
