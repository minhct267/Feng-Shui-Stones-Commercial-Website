<?php
include_once(__DIR__.'/../../../dbconnect.php');
$dh_ma = $_GET['dh_ma'];
$sqlDeleteChiTietDonHang = "DELETE FROM sanpham_donhang WHERE dh_ma=" . $dh_ma;
$resultChiTietDonHang = mysqli_query($conn, $sqlDeleteChiTietDonHang);
$sqlDeleteDonHang = "DELETE FROM donhang WHERE dh_ma=" . $dh_ma;
$resultDonHang = mysqli_query($conn, $sqlDeleteDonHang);
header('location:index.php');
?>