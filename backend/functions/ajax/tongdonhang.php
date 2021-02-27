<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sqlSoLuongDonHang = "SELECT COUNT(*) AS soluong_donhang FROM donhang";
    $result = mysqli_query($conn, $sqlSoLuongDonHang);
    $dataSoLuongDonHang = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $dataSoLuongDonHang[] = array(
            'soluong_donhang' => $row['soluong_donhang']
        );
    }
    echo json_encode($dataSoLuongDonHang[0]);
?>