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
    <title>Đăng kí</title>
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/backend/css/register.css">
</head>
<body>
        <div class="loginbox">
            <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" id="avatar"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>
            <h1>Be our member</h1>
            <form name="frmLogin" id="frmLogin" method="post" action="" >
                <p>Username</p>
                <input type="text" name="username" id="username" placeholder="Enter Username">
                <p>Password</p>
                <input type="password" name="password" id="password" placeholder="Enter Password">
                <p>Verify your password</p>
                <input type="password" name="ver_password" id=" ver_password" placeholder="Enter again your password">
                <input type="submit" name="btnRegister" id="btnRegister" value="Register">
                <a href="sign_in.php">Already had an account?</a>
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
        if(isset($_POST['btnRegister'])){
            $tk_username = $_POST['username'];
            $tk_password = $_POST['password'];
            $ver_password = $_POST['ver_password'];
            if ($tk_password === $ver_password){
                //Thêm tài khoản
                $sql =<<<MMM
                INSERT INTO taikhoan
                (tk_username, tk_password)
                VALUES ('$tk_username', '$tk_password')    
MMM;
                $result = mysqli_query($conn,$sql);
            }
            //Triển khai đăng nhập
            $_SESSION['kh_tendangnhap_logged'] = $tk_username;
            echo '<script>location.href="/web_thuongmai/backend/pages/trangchu.php"</script>' ;
        }
    ?>
</body>
</html>