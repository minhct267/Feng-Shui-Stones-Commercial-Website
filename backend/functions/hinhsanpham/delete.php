<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once(__DIR__ . '/../../../dbconnect.php');
    $hsp_ma = $_GET['hsp'];
    $sqlSelect = "SELECT * FROM hinhsanpham WHERE hsp_ma=$hsp_ma;";
    $resultSelect = mysqli_query($conn, $sqlSelect);
    $hinhsanphamRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);
    $upload_dir = __DIR__ . "/../../../assets/uploads/";
    $products_dir = 'products/';
    $old_file = $upload_dir . $products_dir . $hinhsanphamRow['hsp_ten'];
    if (file_exists($old_file)) {
        unlink($old_file);
    }
    $sql = "DELETE FROM `hinhsanpham` WHERE hsp_ma=" . $hsp_ma;
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    header('location:index.php');
?>