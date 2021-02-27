<?php
if (session_id() === '') {
    session_start();
}

include_once(__DIR__ . '/../../../dbconnect.php');

$sp_ma = $_POST['sp_ma'];
if (isset($_SESSION['giohangdata'])) {
    $data = $_SESSION['giohangdata'];
    
    if(isset($data[$sp_ma])) {
        unset($data[$sp_ma]);
    }
    $_SESSION['giohangdata'] = $data;
}

echo json_encode($_SESSION['giohangdata']);