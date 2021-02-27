<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sqlSoLuongSanPham = "select count(*) as soluong_sanpham from sanpham";
    $result = mysqli_query($conn, $sqlSoLuongSanPham);
    $dataSoLuongSanPham = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $dataSoLuongSanPham[] = array(
            'soluong_sanpham' => $row['soluong_sanpham']
        );
    }
    echo json_encode($dataSoLuongSanPham[0]);
?>