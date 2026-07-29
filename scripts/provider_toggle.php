<?php
include_once "session.php";
include_once "checklogin.php";
include_once "DB.php";

if (!check()) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user = $_SESSION['user'];
$id = $user->id;

if (isset($_POST['online'])) {
    $online = intval($_POST['online']);
    DB::query("UPDATE providers SET is_online=? WHERE id=?", [$online, $id]);

    if ($online == 0) {
        DB::query("UPDATE providers SET current_lat=NULL, current_lng=NULL WHERE id=?", [$id]);
    }

    echo json_encode(['success' => true, 'online' => $online]);
    exit();
}

echo json_encode(['error' => 'Invalid request']);
exit();
?>
