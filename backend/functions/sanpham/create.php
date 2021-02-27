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
    <!--CSS thêm-->
    <link rel="stylesheet" href="/web_thuongmai/assets/vendor/jquery-ui/jquery-ui.min.css">

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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-1 mb-3 border-bottom">
                    <h1 class="h2">Thêm sản phẩm</h1>
                </div>
                <!--Lấy dữ liệu-->
                <?php
                //Hiển thị lỗi
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                //Database 
                include_once(__DIR__.'/../../../dbconnect.php');
                //Loại sản phẩm
                $sqlLoaisanpham = "SELECT* FROM loaisanpham";
                $resultLoaisanpham = mysqli_query($conn,$sqlLoaisanpham);
                $dataLoaisanpham = [];
                while ($rowLoaisanpham = mysqli_fetch_array($resultLoaisanpham, MYSQLI_ASSOC)) {
                    $dataLoaisanpham[] = array(
                        'lsp_ma' => $rowLoaisanpham['lsp_ma'],
                        'lsp_ten' => $rowLoaisanpham['lsp_ten'],
                        'lsp_mota' => $rowLoaisanpham['lsp_mota'],
                    );
                }
                //Khuyến mãi
                $sqlKhuyenmai = "SELECT * FROM khuyenmai";
                $resultKhuyenmai = mysqli_query($conn,$sqlKhuyenmai);
                $dataKhuyenmai = [];
                while ($rowKhuyenmai = mysqli_fetch_array($resultKhuyenmai, MYSQLI_ASSOC)) {
                    $km_tomtat = '';
                    if (!empty($rowKhuyenmai['km_ten'])) {
                        $km_tomtat = sprintf(
                            "Khuyến mãi %s, nội dung: %s, thời gian: %s-%s",
                            $rowKhuyenmai['km_ten'],
                            $rowKhuyenmai['km_chitiet'],
                            date('d/m/Y', strtotime($rowKhuyenmai['km_tungay'])),
                            date('d/m/Y', strtotime($rowKhuyenmai['km_denngay']))
                        );
                    }
                    $dataKhuyenmai[] = array(
                        'km_ma' => $rowKhuyenmai['km_ma'],
                        'km_tomtat' => $km_tomtat,
                    );
                }
                ?>
                <div>
                    <form id="frmCreate" name="frmCreate" method="post" action="">
                        <div class="form-group row">
                            <label for="sp_ten" class="col-sm-3 control-label">Tên loại sản phẩm <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sp_ten" name="sp_ten" placeholder="Tên loại sản phẩm" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_gia" class="col-sm-3 control-label">Giá <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sp_gia" name="sp_gia" placeholder="Giá sản phẩm" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_giacu" class="col-sm-3 control-label">Giá cũ <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sp_giacu" name="sp_giacu" placeholder="Giá cũ sản phẩm" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_ngaycapnhat" class="col-sm-3 control-label">Ngày cập nhật <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sp_ngaycapnhat" name="sp_ngaycapnhat" placeholder="Ngày cập nhật" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_soluong" class="col-sm-3 control-label">Số lượng <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="sp_soluong" name="sp_soluong" placeholder="Số lượng" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lsp_ma" class="control-label col-sm-3">Loại sản phẩm <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="lsp_ma" name="lsp_ma">
                                    <?php foreach ($dataLoaisanpham as $loaisanpham) : ?>
                                        <option value="<?= $loaisanpham['lsp_ma'] ?>"><?= $loaisanpham['lsp_ten'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="km_ma" class="col-sm-3 control-label">Khuyến mãi <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="km_ma" name="km_ma">
                                    <option value="">Không áp dụng khuyến mãi</option>
                                    <?php foreach ($dataKhuyenmai as $khuyenmai) : ?>
                                        <option value="<?= $khuyenmai['km_ma'] ?>"><?= $khuyenmai['km_tomtat'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_mota_ngan" class="col-sm-3 control-label">Mô tả ngắn <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="sp_mota_ngan" name="sp_mota_ngan" placeholder="Mô tả ngắn" value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sp_mota_chitiet" class="col-sm-3 control-label">Mô tả chi tiết <span style="color:red;">(*)</span> :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="sp_mota_chitiet" name="sp_mota_chitiet" placeholder="Mô tả chi tiết" value=""></textarea>
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
                        if (isset($_POST['btnCreate'])){
                            //Lấy giá trị người dùng gửi đến
                            $sp_ten = htmlentities($_POST['sp_ten']);
                            $sp_gia = htmlentities($_POST['sp_gia']);
                            $sp_giacu = htmlentities($_POST['sp_giacu']);
                            $sp_mota_ngan = htmlentities($_POST['sp_mota_ngan']);
                            $sp_mota_chitiet = htmlentities($_POST['sp_mota_chitiet']);
                            $sp_ngaycapnhat = date('Y/m/d', strtotime($_POST['sp_ngaycapnhat']));
                            $sp_soluong = $_POST['sp_soluong'];
                            $lsp_ma = $_POST['lsp_ma'];
                            $km_ma = (empty($_POST['km_ma']) ? 'NULL' : $_POST['km_ma']);
                            //Biến lỗi
                            $errors = [];
                            //Ràng buộc cho Tên loại sản phẩm
                            //required
                            if (empty($sp_ten)) {
                                $errors['sp_ten'][] = [
                                  'rule' => 'required',
                                  'rule_value' => true,
                                  'value' => $sp_ten,
                                  'msg' => 'Vui lòng nhập tên sản phẩm'
                                ];
                            }
                            //minlength
                            if (!empty($sp_ten) && strlen($sp_ten) < 3) {
                                $errors['sp_ten'][] = [
                                  'rule' => 'minlength',
                                  'rule_value' => 3,
                                  'value' => $sp_ten,
                                  'msg' => 'Tên Loại sản phẩm phải có ít nhất 3 ký tự'
                                ];
                            }
                            //maxlength
                            if (!empty($sp_ten) && strlen($sp_ten) > 50) {
                                $errors['sp_ten'][] = [
                                  'rule' => 'maxlength',
                                  'rule_value' => 50,
                                  'value' => $sp_ten,
                                  'msg' => 'Tên Loại sản phẩm không được vượt quá 50 ký tự'
                                ];
                            }
                            //Ràng buộc cho giá 
                            //required
                            if (empty($sp_gia)) {
                                $errors['sp_gia'][] = [
                                  'rule' => 'required',
                                  'rule_value' => true,
                                  'value' => $sp_gia,
                                  'msg' => 'Vui lòng nhập giá sản phẩm'
                                ];
                            }
                            //Ràng buộc cho Mô tả ngắn
                            //maxlength
                            if (!empty($sp_mota_ngan) && strlen($sp_mota_ngan) > 100) {
                                $errors['sp_mota_ngan'][] = [
                                  'rule' => 'maxlength',
                                  'rule_value' => 100,
                                  'value' => $sp_mota_ngan,
                                  'msg' => 'Mô tả ngắn sản phẩm không được vượt quá 100 ký tự'
                                ];
                            }
                            //Ràng buộc cho Mô tả chi tiết
                            //maxlength
                            if (!empty($sp_mota_chitiet) && strlen($sp_mota_chitiet) > 800) {
                                $errors['sp_mota_chitiet'][] = [
                                  'rule' => 'maxlength',
                                  'rule_value' => 800,
                                  'value' => $sp_mota_chitiet,
                                  'msg' => 'Mô tả chi tiết sản phẩm không được vượt quá 800 ký tự'
                                ];
                            }
                            //Ràng buộc cho số lượng 
                            //required
                            if (empty($sp_soluong)) {
                                $errors['sp_soluong'][] = [
                                  'rule' => 'required',
                                  'rule_value' => true,
                                  'value' => $sp_soluong,
                                  'msg' => 'Vui lòng nhập số lượng'
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
                            $sql = "INSERT INTO sanpham (sp_ten, sp_gia, sp_giacu, sp_mota_ngan, sp_mota_chitiet, sp_ngaycapnhat, sp_soluong, lsp_ma, km_ma) VALUES ('$sp_ten', $sp_gia, $sp_giacu, '$sp_mota_ngan', '$sp_mota_chitiet', '$sp_ngaycapnhat', $sp_soluong, $lsp_ma, $km_ma);";
                            mysqli_query($conn, $sql);
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
    <!--File javascript riêng-->
    <!--JqueryUI-->
    <script src="/web_thuongmai/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <!--Javascript tự tạo-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace()
            //DatePicker
            $("#sp_ngaycapnhat").datepicker();
        });
    </script>
</body>

</html>