<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sqlSoLuongKhachHang = "SELECT COUNT(*) AS soluong_khachhang FROM khachhang";
    $result = mysqli_query($conn, $sqlSoLuongKhachHang);
    $dataSoLuongKhachHang = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $dataSoLuongKhachHang[] = array(
            'soluong_khachhang' => $row['soluong_khachhang']
        );
    }
    echo json_encode($dataSoLuongKhachHang[0]);
?>