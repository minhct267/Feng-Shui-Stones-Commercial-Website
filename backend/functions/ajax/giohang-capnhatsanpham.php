<?php
if (session_id() === '') {
    session_start();
}

include_once(__DIR__ . '/../../../dbconnect.php');

$sp_ma = $_POST['sp_ma'];
$soluong = $_POST['soluong'];

if (isset($_SESSION['giohangdata'])) {
    $data = $_SESSION['giohangdata'];
    $sanphamcu = $data[$sp_ma];
    
    $data[$sp_ma] = array(
        'sp_ma' => $sanphamcu['sp_ma'],
        'sp_ten' => $sanphamcu['sp_ten'],
        'soluong' => $soluong,
        'gia' => $sanphamcu['gia'],
        'thanhtien' => ($soluong * $sanphamcu['gia']),
        'hinhdaidien' => $sanphamcu['hinhdaidien']
    );

    $_SESSION['giohangdata'] = $data;
}

echo json_encode($_SESSION['giohangdata']);