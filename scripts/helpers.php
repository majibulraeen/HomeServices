<?php


function clean($data = array())
{
    foreach ($data as $key => $val) {
        $val = trim($val);
        $val = stripslashes($val);
        $data[$key] = htmlspecialchars($val);
    }
    return $data;
}

function upload($file, $allowed = ['png', 'jpg', 'jpeg', 'gif', 'pdf'])
{
    $a = explode('.', $file['name']) ?: '';
    $ext = strtolower(end($a));
    if (array_search($ext, $allowed) === false) {
        return false;
    }
    $dest = uniqid().'.'.$ext;

    if (move_uploaded_file($file['tmp_name'], '../images/'.$dest)) {
        return $dest;
    }
    return false;
}
