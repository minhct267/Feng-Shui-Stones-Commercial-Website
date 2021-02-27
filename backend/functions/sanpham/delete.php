<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__.'/../../../dbconnect.php');
$sp_ma = $_GET['sp'];
$sql = "DELETE FROM sanpham WHERE sp_ma = $sp_ma";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);
header('location:index.php');
?>