<?php

require_once 'session.php';
require_once 'DB.php';
require_once 'helpers.php';

if (isset($_POST['review'])) {
    $input = clean($_POST); // Assuming clean() sanitizes input

    $Full_Name = $input['Full_Name'];
    $email = $input['email'];
    $Mobile_No = $input['Mobile_No'];
    $inputState = $input['inputState'];
    $review = $input['comment'];
    
    $commentss = DB::query("INSERT INTO comments VALUES (DEFAULT,?, ?, ?, ?, ?)", [
     $Full_Name, $email, $Mobile_No, $inputState, $review
    ]);

    if ($commentss) {
        header('Location: ../index.php?msg=success');
        exit();
    } else {
        header('Location: ../about.php?msg=failed');
        exit();
    }
}
?>
