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
                    <h1 class="h2">Thêm loại sản phẩm</h1>
                </div>
                <div>
                    <form id="frmCreate" name="frmCreate" method="post" action="">
                        <div class="form-group row">
                            <label for="lsp_ten" class="col-sm-3 control-label">Tên loại sản phẩm <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lsp_ten" name="lsp_ten" placeholder="Tên loại sản phẩm" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lsp_mota" class="col-sm-3 control-label">Mô tả <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="lsp_mota" name="lsp_mota" placeholder="Mô tả" value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button class="btn btn-outline-success" id="btnCreate" name="btnCreate">Create</button>
                                <a class="btn btn-outline-primary" id="btnBack" name="btnBack" href="index.php">Back</a>
                            </div>
                        </div>
                    </form>

                    <!--Xử lí PHP -->
                    <!--Tạo ràng buộc -->
                    <?php
                        //Hiển thị lỗi
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);
                        //Database 
                        include_once(__DIR__.'/../../../dbconnect.php');
                        if (isset($_POST['btnCreate'])){
                            $lsp_ten = htmlentities($_POST['lsp_ten']);
                            $lsp_mota = htmlentities($_POST['lsp_mota']);
                            //Biến lỗi
                            $errors = [];
                            //Ràng buộc cho Tên loại sản phẩm
                            //required
                            if (empty($lsp_ten)) {
                                $errors['lsp_ten'][] = [
                                  'rule' => 'required',
                                  'rule_value' => true,
                                  'value' => $lsp_ten,
                                  'msg' => 'Vui lòng nhập tên Loại sản phẩm'
                                ];
                            }
                            //minlength
                            if (!empty($lsp_ten) && strlen($lsp_ten) < 3) {
                                $errors['lsp_ten'][] = [
                                  'rule' => 'minlength',
                                  'rule_value' => 3,
                                  'value' => $lsp_ten,
                                  'msg' => 'Tên Loại sản phẩm phải có ít nhất 3 ký tự'
                                ];
                            }
                            //maxlength
                            if (!empty($lsp_ten) && strlen($lsp_ten) > 50) {
                                $errors['lsp_ten'][] = [
                                  'rule' => 'maxlength',
                                  'rule_value' => 50,
                                  'value' => $lsp_ten,
                                  'msg' => 'Tên Loại sản phẩm không được vượt quá 50 ký tự'
                                ];
                            }
                            //Ràng buộc cho Mô tả
                            //maxlength
                            if (!empty($lsp_mota) && strlen($lsp_mota) > 255) {
                                $errors['lsp_mota'][] = [
                                  'rule' => 'maxlength',
                                  'rule_value' => 255,
                                  'value' => $lsp_mota,
                                  'msg' => 'Mô tả loại sản phẩm không được vượt quá 255 ký tự'
                                ];
                            }
                        }
                    ?>
                    <!--Hiển thị ràng buộc-->
                    <?php if (isset($_POST['btnCreate']) && isset($errors) && (!empty($errors))) : ?>
                        <div id="errors-container" class="alert alert-danger face my-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                <?php foreach ($errors as $fields) : ?>
                                    <?php foreach ($fields as $field) : ?>
                                    <li><?php echo $field['msg']; ?></li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <!--Xử lí công việc khi ko có lỗi Ràng buộc-->
                    <?php
                        if(isset($_POST['btnCreate']) && (!isset($errors) || (empty($errors)))){
                            $sql = "INSERT INTO loaisanpham (lsp_ten, lsp_mota) VALUES ('$lsp_ten', '$lsp_mota');";
                            mysqli_query($conn,$sql);
                            mysqli_close($conn);
                            echo '<script>location.href="index.php";</script>';
                        } 
                    ?>
                </div>
                <!--Footer-->
                <?php include_once(__DIR__.'/../../layouts/partials/footer.php') ?>
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
</body>

</html>