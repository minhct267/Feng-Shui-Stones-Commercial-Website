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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    <h1 class="h2">Thêm đơn hàng</h1>
                </div>
                <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                // Truy vấn database
                include_once(__DIR__ . '/../../../dbconnect.php');
                //Hình thức thanh toán
                $sqlHinhThucThanhToan = "SELECT * FROM hinhthucthanhtoan";
                $resultHinhThucThanhToan = mysqli_query($conn, $sqlHinhThucThanhToan);
                $dataHinhThucThanhToan = [];
                while ($rowHinhThucThanhToan = mysqli_fetch_array($resultHinhThucThanhToan, MYSQLI_ASSOC)) {
                    $dataHinhThucThanhToan[] = array(
                        'httt_ma' => $rowHinhThucThanhToan['httt_ma'],
                        'httt_ten' => $rowHinhThucThanhToan['httt_ten'],
                    );
                }
                // Khách hàng
                $sqlKhachHang = "SELECT * FROM khachhang";
                $resultKhachHang = mysqli_query($conn, $sqlKhachHang);
                $dataKhachHang = [];
                while ($rowKhachHang = mysqli_fetch_array($resultKhachHang, MYSQLI_ASSOC)) {
                    $kh_tomtat = sprintf(
                        "Họ tên %s, số điện thoại: %s",
                        $rowKhachHang['kh_ten'],
                        $rowKhachHang['kh_dienthoai']
                    );

                    $dataKhachHang[] = array(
                        'kh_ma' => $rowKhachHang['kh_ma'],
                        'kh_tomtat' => $kh_tomtat
                    );
                }
                // Sản phẩm
                $sqlSanPham = "SELECT * FROM sanpham";
                $resultSanPham = mysqli_query($conn, $sqlSanPham);
                $dataSanPham = [];
                while ($rowSanPham = mysqli_fetch_array($resultSanPham, MYSQLI_ASSOC)) {
                    $dataSanPham[] = array(
                        'sp_ma' => $rowSanPham['sp_ma'],
                        'sp_gia' => $rowSanPham['sp_gia'],
                        'sp_ten' => $rowSanPham['sp_ten'],
                    );
                }
                ?>

                <form name="frmhinhsanpham" id="frmhinhanpham" method="post" action="" enctype="multipart/form-data">
                    <fieldset id="donHangContainer">
                        <legend>Thông tin Đơn hàng</legend>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Khách hàng</label>
                                    <select name="kh_ma" id="kh_ma" class="form-control">
                                        <option value="">Vui lòng chọn Khách hàng</option>
                                        <?php foreach ($dataKhachHang as $khachhang) : ?>
                                            <option value="<?= $khachhang['kh_ma'] ?>"><?= $khachhang['kh_tomtat'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Ngày lập</label>
                                    <input type="text" name="dh_ngaylap" id="dh_ngaylap" class="form-control" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Ngày giao</label>
                                    <input type="text" name="dh_ngaygiao" id="dh_ngaygiao" class="form-control" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Nơi giao</label>
                                    <input type="text" name="dh_noigiao" id="dh_noigiao" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Trạng thái thanh toán</label><br />
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="dh_trangthaithanhtoan" id="dh_trangthaithanhtoan-1" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="dh_trangthaithanhtoan-1">Chưa thanh toán</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="dh_trangthaithanhtoan" id="dh_trangthaithanhtoan-2" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="dh_trangthaithanhtoan-2">Đã thanh toán</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Hình thức thanh toán</label>
                                    <select name="httt_ma" id="httt_ma" class="form-control">
                                    <option value="">Vui lòng chọn Hình thức thanh toán</option>
                                        <?php foreach ($dataHinhThucThanhToan as $httt) : ?>
                                            <option value="<?= $httt['httt_ma'] ?>"><?= $httt['httt_ten'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset id="chiTietDonHangContainer">
                        <legend>Thông tin Chi tiết Đơn hàng</legend>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="sp_ma">Sản phẩm</label>
                                    <select class="form-control" id="sp_ma" name="sp_ma">
                                        <option value="">Vui lòng chọn Sản phẩm</option>
                                        <?php foreach ($dataSanPham as $sanpham) : ?>
                                            <option value="<?= $sanpham['sp_ma'] ?>" data-sp_gia="<?= $sanpham['sp_gia'] ?>"><?= $sanpham['sp_ten'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" name="soluong" id="soluong" class="form-control" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Xử lý</label><br />
                                    <button type="button" id="btnThemSanPham" class="btn btn-secondary">Thêm vào đơn hàng</button>
                                </div>
                            </div>
                        </div>

                        <table id="tblChiTietDonHang" class="table table-striped table-responsive-sm">
                            <thead>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </fieldset>

                    <button class="btn btn-outline-success" name="btnCreate">Create</button>
                    <a href="index.php" class="btn btn-outline-primary" name="btnBack" id="btnBack">Back</a>
                </form>

                <?php
                if (isset($_POST['btnCreate'])) {
                    $kh_ma = $_POST['kh_ma'];
                    $dh_ngaylap =htmlentities(date('Y/m/d', strtotime($_POST['dh_ngaylap'])));
                    $dh_ngaygiao = htmlentities(date('Y/m/d', strtotime($_POST['dh_ngaygiao'])));
                    $dh_noigiao = htmlentities($_POST['dh_noigiao']);
                    $dh_trangthaithanhtoan = $_POST['dh_trangthaithanhtoan'];
                    $httt_ma = $_POST['httt_ma'];

                    // Thông tin các dòng chi tiết đơn hàng
                    $arr_sp_ma = $_POST['sp_ma'];
                    $arr_sp_dh_soluong = $_POST['sp_dh_soluong'];
                    $arr_sp_dh_dongia = $_POST['sp_dh_dongia'];

                    $sqlInsertDonHang = "INSERT INTO donhang (dh_ngaylap, dh_trangthaithanhtoan, dh_noigiao, dh_ngaygiao, kh_ma, httt_ma) VALUES ('$dh_ngaylap', $dh_trangthaithanhtoan, '$dh_noigiao', '$dh_ngaygiao', $kh_ma, $httt_ma)";

                    // Thực thi INSERT Đơn hàng
                    mysqli_query($conn, $sqlInsertDonHang);
                    $dh_ma = $conn->insert_id;

                    for($i = 0; $i < count($arr_sp_ma); $i++) {
                        // 4.1. Chuẩn bị dữ liệu cho câu lệnh INSERT vào table 'sanpham_dondathang'
                        $sp_ma = $arr_sp_ma[$i];
                        $sp_dh_soluong = $arr_sp_dh_soluong[$i];
                        $sp_dh_dongia = $arr_sp_dh_dongia[$i];

                        // 4.2. Câu lệnh INSERT
                        $sqlInsertSanPhamDonDatHang = "INSERT INTO sanpham_donhang (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia) VALUES ($sp_ma, $dh_ma, $sp_dh_soluong, $sp_dh_dongia)";

                        // 4.3. Thực thi INSERT
                        mysqli_query($conn, $sqlInsertSanPhamDonDatHang);
                    }

                    // 5. Thực thi hoàn tất, điều hướng về trang Danh sách
                    echo '<script>location.href = "index.php";</script>';
                }
                ?>
                <!--Footer-->
                <?php include_once(__DIR__.'/../../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace()
            //DatePicker
            $('#dh_ngaygiao').datepicker();
            $('#dh_ngaylap').datepicker();
        });
    </script>
    <script>
        // Đăng ký sự kiện Click nút Thêm Sản phẩm
        $('#btnThemSanPham').click(function() {
            //debugger;
            // Lấy thông tin Sản phẩm
            var sp_ma = $('#sp_ma').val();
            var sp_gia = $('#sp_ma option:selected').data('sp_gia');
            var sp_ten = $('#sp_ma option:selected').text();
            var soluong = $('#soluong').val();
            var thanhtien = (soluong * sp_gia);
            
            // Tạo mẫu giao diện HTML Table Row
            var htmlTemplate = '<tr>'; 
            htmlTemplate += '<td>' + sp_ten + '<input type="hidden" name="sp_ma[]" value="' + sp_ma + '"/></td>';
            htmlTemplate += '<td>' + soluong + '<input type="hidden" name="sp_dh_soluong[]" value="' + soluong + '"/></td>';
            htmlTemplate += '<td>' + sp_gia + '<input type="hidden" name="sp_dh_dongia[]" value="' + sp_gia + '"/></td>';
            htmlTemplate += '<td>' + thanhtien + '</td>';
            htmlTemplate += '<td><button type="button" class="btn btn-danger btn-delete-row">Xóa</button></td>';
            htmlTemplate += '</tr>';

            // Thêm vào TABLE BODY
            $('#tblChiTietDonHang tbody').append(htmlTemplate);

            // Clear
            $('#sp_ma').val('');
            $('#soluong').val('');
        });

        // Đăng ký sự kiện cho tất cả các nút XÓA có sử dụng class .btn-delete-row
        $('#chiTietDonHangContainer').on('click', '.btn-delete-row', function() {
            $(this).parent().parent()[0].remove();
        });
    </script>

</body>

</html>