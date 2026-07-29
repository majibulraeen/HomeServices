<?php

require_once 'helpers.php';
require_once 'DB.php';

if (isset($_POST['city']) && isset($_POST['profession']) && isset($_POST['lat']) && isset($_POST['lon'])) {
    $input = clean($_POST);
    
    $city = $input['city'];
    $profession = $input['profession'];
    $userLat = floatval($input['lat']);
    $userLon = floatval($input['lon']);

    $sql = "
    SELECT *, 
    COALESCE(NULLIF(current_lat, ''), latitude) AS display_lat,
    COALESCE(NULLIF(current_lng, ''), longitude) AS display_lng
    FROM `providers`
    WHERE city LIKE :city 
      AND profession = :profession 
      AND verified = 1 
      AND is_online = 1";

    $stmt = DB::query($sql, [
        ':city' => '%' . $city . '%',
        ':profession' => $profession
    ]);

    $allProviders = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Calculate distance in PHP to avoid PDO named param reuse issues
    $results = [];
    foreach ($allProviders as $p) {
        $plat = floatval($p->display_lat);
        $plng = floatval($p->display_lng);
        if ($plat == 0 && $plng == 0) continue;

        $angle = cos(deg2rad($userLat)) * cos(deg2rad($plat)) * cos(deg2rad($plng) - deg2rad($userLon)) +
                 sin(deg2rad($userLat)) * sin(deg2rad($plat));
        // Clamp to [-1, 1] to prevent NaN from floating point drift
        $angle = max(-1, min(1, $angle));
        $distance = 6371 * acos($angle);

        if ($distance < 20) {
            $p->distance = round($distance, 2);
            // Override lat/lng with runtime values for map display
            $p->latitude = $p->display_lat;
            $p->longitude = $p->display_lng;
            unset($p->display_lat);
            unset($p->display_lng);
            $results[] = $p;
        }
    }

    usort($results, function($a, $b) {
        return $a->distance <=> $b->distance;
    });

    if (count($results) > 0) {
        echo json_encode($results);
    } else {
        echo '{"failed": true}';
    }
}
?>
