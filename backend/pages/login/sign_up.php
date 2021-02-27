<?php 
    if (session_id() === ''){
        session_start();
    }

    //Đăng xuất
    if(isset($_SESSION['kh_tendangnhap_logged'])) {
        unset($_SESSION['kh_tendangnhap_logged']);
        header('location:sign_in.php');
    }
?>