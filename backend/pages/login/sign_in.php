<?php 
    if(session_id() === ''){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/backend/css/sign_in.css">
</head>
<body>

    <?php if(isset($_SESSION['kh_tendangnhap_logged']) && !empty($_SESSION['kh_tendangnhap_logged'])) : ?>
        <script>location.href="/web_thuongmai/backend/pages/trangchu.php"</script>
    <?php else: ?>
        <div class="loginbox">
            <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" id="avatar"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>
            <h1>Login Here</h1>
            <form name="frmLogin" id="frmLogin" method="post" action="" >
                <p>Username</p>
                <input type="text" name="username" id="username" placeholder="Enter Username">
                <p>Password</p>
                <input type="password" name="password" id="password" placeholder="Enter Password">
                <input type="submit" name="btnLogin" id="btnLogin" value="Login">
                <a href="#">Lost your password?</a><br>
                <a href="register.php">Don't have an account?</a>
            </form>
        </div>
    <!--Xử lí PHP-->
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        //Kết nối database
        include_once(__DIR__ . '/../../../dbconnect.php');
        //Lấy dữ liệu nhập vào form đăng nhập
        if(isset($_POST['btnLogin'])){
            $tk_username = addslashes($_POST['username']);
            $tk_password = addslashes($_POST['password']);
            //truy vấn dữ liệu
            $sql =<<<MMM
            SELECT*
            FROM taikhoan
            WHERE tk_username = '$tk_username' and tk_password = '$tk_password'
MMM;
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result) > 0){
                //Lưu thông tin tên tài khoản đã đăng nhập
                $_SESSION['kh_tendangnhap_logged'] = $tk_username;
                echo '<script>location.href="/web_thuongmai/backend/pages/trangchu.php"</script>' ;
            } else {
                echo '<h3 style="color: red;">Đăng nhập thất bại!</h3>';
            }
        }
        endif;
    ?>
</body>
</html>