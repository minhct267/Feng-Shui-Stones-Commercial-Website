<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sqlThongKeLoaiSanPham =<<<MMM
    SELECT lsp.lsp_ten AS ten_loai, COUNT(*) AS soluong_sanpham
    FROM sanpham sp
    JOIN loaisanpham lsp ON sp.lsp_ma = lsp.lsp_ma
    GROUP BY sp.lsp_ma    
MMM;
    $result = mysqli_query($conn, $sqlThongKeLoaiSanPham);
    $dataThongKeLoaiSanPham = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $dataThongKeLoaiSanPham[] = array(
            'ten_loai' => $row['ten_loai'],
            'soluong_sanpham' => $row['soluong_sanpham']
        );
    }
    echo json_encode($dataThongKeLoaiSanPham);
?>