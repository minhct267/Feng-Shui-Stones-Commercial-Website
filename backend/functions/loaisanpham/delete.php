<?php
    //Hiển thị tất cả các lỗi trong PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //truy vấn database
    include_once(__DIR__.'/../../../dbconnect.php');
    $lsp_ma = $_GET['lsp'];
    $sql = "DELETE FROM loaisanpham WHERE lsp_ma = $lsp_ma";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    header('location:index.php');
?>