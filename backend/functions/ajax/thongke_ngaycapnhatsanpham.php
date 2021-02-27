<?php
    include_once(__DIR__.'/../../../dbconnect.php');
    $sql =<<<MMM
    SELECT COUNT(*) AS soluong, MONTH(sp_ngaycapnhat) AS thang
    FROM sanpham
    GROUP BY MONTH(sp_ngaycapnhat)    
MMM;
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $data[] = array(
            'thang' => $row['thang'],
            'soluong' => $row['soluong']
        );
    }
    echo json_encode($data);
?>