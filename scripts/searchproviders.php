<?php

require_once 'helpers.php';
require_once 'DB.php';

if (isset($_POST['city']) && isset($_POST['profession']) && isset($_POST['lat']) && isset($_POST['lon'])) {
    $input = clean($_POST);
    
    $city = $input['city'];
    $profession = $input['profession'];
    $userLat = $input['lat'];
    $userLon = $input['lon'];

    // Haversine formula to calculate distance
    $sql = "
    SELECT *, 
    (
        6371 * acos(
            cos(radians(:lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians(:lon)) +
            sin(radians(:lat)) * sin(radians(latitude))
        )
    ) AS distance
    FROM `providers`
    WHERE city = :city AND profession = :profession
    HAVING distance <20
    ORDER BY distance ASC";

    $stmt = DB::query($sql, [
        ':lat' => $userLat,
        ':lon' => $userLon,
        ':city' => $city,
        ':profession' => $profession
    ]);

    $providers = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (count($providers) > 0) {
        echo json_encode($providers);
    } else {
        echo '{"failed": true }';
    }
} else {
    echo '{"error": "Invalid parameters"}';
}
