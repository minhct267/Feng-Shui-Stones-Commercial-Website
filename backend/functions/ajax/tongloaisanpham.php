<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sqlSoLuongLoaiSanPham = "SELECT COUNT(*) AS soluong_loaisanpham FROM loaisanpham";
    $result = mysqli_query($conn, $sqlSoLuongLoaiSanPham);
    $dataSoLuongLoaiSanPham = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $dataSoLuongLoaiSanPham[] = array(
            'soluong_loaisanpham' => $row['soluong_loaisanpham']
        );
    }
    echo json_encode($dataSoLuongLoaiSanPham[0]);
?>