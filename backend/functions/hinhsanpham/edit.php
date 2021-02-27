<?php 
    if(session_id() === ''){
        session_start();
    }
?>
<!-- Config-->
<?php include_once(__DIR__.'/../../layouts/config.php') ?>

<!DOCTYPE html>
<html>

<head>
    <!--Head-->
    <?php include_once(__DIR__.'/../../layouts/head.php') ?>
</head>

<body>

    <!--Header-->
    <?php include_once(__DIR__.'/../../layouts/partials/header.php')  ?>
    <!--Main-->
    <div class="container-fluid">
        <div class="row">
            <!--Sidebar-->
            <?php include_once(__DIR__.'/../../layouts/partials/sidebar.php') ?>
            <!--Main-->
            <main class="col-md-9 col-lg-10 ml-sm-auto">
                <!--Content-->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-1 mb-2 border-bottom">
                    <h1 class="h2">Thay đổi hình sản phẩm</h1>
                </div>
                <!--Kết nối database-->
                <?php
                    //Hiển thị lỗi
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    //Database 
                    include_once(__DIR__.'/../../../dbconnect.php');
                    $hsp_ma = $_GET['hsp'];
                    //Lấy thông tin sản phẩm 
                    $sqlSanpham = "SELECT* FROM sanpham";
                    $resultSanpham = mysqli_query($conn,$sqlSanpham);
                    $dataSanpham = [];
                    while ($rowSanpham = mysqli_fetch_array($resultSanpham,MYSQLI_ASSOC)){
                        $sp_tomtat = sprintf(
                            "Sản phẩm %s, giá: %s",
                            $rowSanpham['sp_ten'],
                            number_format($rowSanpham['sp_gia'], 2, ".", ",") . ' vnđ'
                        );
                
                        $dataSanpham[] = array(
                            'sp_ma' => $rowSanpham['sp_ma'],
                            'sp_tomtat' => $sp_tomtat
                        );
                    }
                    //Lấy dòng record cần chỉnh sửa
                    $sqlHinhsanpham = "SELECT* FROM hinhsanpham WHERE hsp_ma = $hsp_ma";
                    $resultHinhsanpham = mysqli_query($conn,$sqlHinhsanpham);
                    $rowHinhsanpham = mysqli_fetch_array($resultHinhsanpham,MYSQLI_ASSOC);
                ?>
                <div>
                    <form id="frmCreate" name="frmCreate" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="hsp_ten" class="col-sm-3 control-label">Tên sản phẩm <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sp_ma" name="sp_ma">
                                    <?php foreach($dataSanpham as $sp): ?>
                                        <?php if($sp['sp_ma'] == $rowHinhsanpham['sp_ma']):?>
                                            <option value="<?= $sp['sp_ma'] ?>" selected><?= $sp['sp_tomtat'] ?></option>
                                        <?php else:?>
                                            <option value="<?= $sp['sp_ma'] ?>" ><?= $sp['sp_tomtat'] ?></option>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hsp_ten" class="col-sm-3 control-label">New file <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" id="hsp_ten" name="hsp_ten" value="<?= $rowHinhsanpham['hsp_ten'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <label for="hsp_mota" class="col-sm-3">Your current image:</label>
                            <div class="col-sm-9">
                                <div>
                                    <img src="/web_thuongmai/assets/uploads/products/<?= $rowHinhsanpham['hsp_ten'] ?>" style="width:300px; height:auto; border:1px solid lightgrey; border-radius:7px;">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="hsp_mota" class="col-sm-3">Your new image:</label>
                            <div class="col-sm-9">
                                <div>
                                    <img id="preview-img" src="/web_thuongmai/assets/shared/img/image_icon.png" style="width:300px; height:auto; border:1px solid lightgrey; border-radius:7px;background-color:lightgrey;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button class="btn btn-outline-info" id="btnSave" name="btnSave">Save</button>
                                <a class="btn btn-outline-primary" id="btnBack" name="btnBack" href="index.php">Back</a>
                            </div>
                        </div>
                    </form>

                    <!--Xử lí PHP -->
                    <?php
                        if (isset($_POST['btnSave'])){
                            $sp_ma = $_POST['sp_ma'];
                            if(isset($_FILES['hsp_ten'])){
                                $upload_dir = __DIR__.'/../../../assets/uploads/';
                                $products_dir = 'products/';
                                //Đuôi file hợp lệ
                                $allowed_image_extension = array(
                                    "png",
                                    "jpg",
                                    "jpeg"
                                );
                                //Lấy đuôi của file
                                $file_extension = pathinfo($_FILES["hsp_ten"]["name"], PATHINFO_EXTENSION);
                                if (($_FILES['hsp_ten']['error'] > 0) || ($_FILES['hsp_ten']['size'] > 10485760) || !(in_array($file_extension, $allowed_image_extension))) {
                                    echo 'File Upload Bị Lỗi'; die;
                                }else {
                                    //Xóa file cũ
                                    $old_file = $upload_dir . $products_dir . $rowHinhsanpham['hsp_ten'];
                                    if (file_exists($old_file)) {
                                        unlink($old_file);
                                    }
                                    $hsp_ten = $_FILES['hsp_ten']['name'];
                                    $ten = date('YmdHis') . '_' . $hsp_ten;
                                    move_uploaded_file($_FILES['hsp_ten']['tmp_name'], $upload_dir . $products_dir . $ten);
                                }

                                //--------------------------
                                $sql = "UPDATE hinhsanpham SET hsp_ten='$ten' WHERE hsp_ma=$hsp_ma;";
                                mysqli_query($conn, $sql);
                                mysqli_close($conn);
                                echo '<script>location.href = "index.php";</script>';
                            }
                        }
                    ?>
                </div>
                <!--Footer-->
                <?php include_once(__DIR__.'/../../layouts/partials/footer.php'); ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace()
        });
    </script>
    <!-- Hiển thị ảnh preview (xem trước) khi người dùng chọn Ảnh-->
    <script>
        const reader = new FileReader();
        const fileInput = document.getElementById("hsp_ten");
        const img = document.getElementById("preview-img");
        reader.onload = e => {
        img.src = e.target.result;
        }
        fileInput.addEventListener('change', e => {
        const f = e.target.files[0];
        reader.readAsDataURL(f);
        })
  </script>
</body>

</html>