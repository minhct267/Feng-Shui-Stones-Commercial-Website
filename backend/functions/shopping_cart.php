<?php 
    if(session_id() ===''){
        session_start();
    }
?>
<!-- Config-->
<?php include_once(__DIR__.'/../layouts/config.php') ?>

<!DOCTYPE html>
<html>

<head>
    <!--Head-->
    <?php include_once(__DIR__.'/../layouts/head.php') ?>
</head>

<body>

    <!--Header-->
    <?php include_once(__DIR__.'/../layouts/partials/header.php')  ?>
    <!--Main-->
    <div class="container-fluid">
        <div class="row">
            <!--Sidebar-->
            <?php include_once(__DIR__.'/../layouts/partials/sidebar.php') ?>
            <!--Main-->
            <main class="col-md-9 col-lg-10 ml-sm-auto">
                <!--Content-->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-1 mb-2 border-bottom">
                    <h1 class="h2">Cart</h1>
                </div>
                <?php 
                    include_once(__DIR__.'/../../dbconnect.php');
                    $giohangdata = [];
                    if (isset($_SESSION['giohangdata'])) {
                        $giohangdata = $_SESSION['giohangdata'];
                    } else {
                        $giohangdata = [];
                    }
                ?>
                <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
                    <div id="thongbao">&nbsp;</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <?php if (!empty($giohangdata)) : ?>
                    <table id="tblCart" class="table table-strpied text-center">
                        <thead class="thead-light text-nowrap text-center">
                            <tr>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody id="datarow">
                            <?php $stt = 1?>
                            <?php foreach ($giohangdata as $sanpham) :?>
                                <tr>
                                    <td><?= $stt?><?php $stt++?></td> 
                                    <td><?=$sanpham['sp_ten'] ?></td>
                                    <td>
                                        <?php if (empty($sanpham['hinhdaidien'])) : ?>
                                            <img src="/web_thuongmai/assets/shared/img/image_icon.png"  style="width:100px;height:100px; object-fit:contain;" />
                                        <?php else : ?>
                                            <img src="/web_thuongmai/assets/uploads/products/<?= $sanpham['hinhdaidien'] ?>"  style="width:100px;height:100px; object-fit:contain;"/>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_format($sanpham['gia'], 2, ".", ",") . ' vnđ'?></td>
                                    <td><input type="number" class="form-control" id="soluong_<?= $sanpham['sp_ma'] ?>" name="soluong" value="<?= $sanpham['soluong'] ?>" /></td>
                                    <td>
                                        <button class="btn btn-outline-primary" id="btnEdit" data-sp-ma="<?= $sanpham['sp_ma'] ?>">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-danger" id="btnDelete" data-sp-ma="<?= $sanpham['sp_ma'] ?>">Delete</button>
                                    </td>
                                    <td><?= number_format($sanpham['soluong'] * $sanpham['gia'], 2, ".", ",")?> vnđ</td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php else:?>
                        <h4>Giỏ hảng trống</h4>
                    <?php endif; ?>
                    <div class="d-flex flex-row justify-content-center">
                        <a href="#" class="btn btn-outline-success">Thanh toán</a>
                        <a href="/web_thuongmai/backend/pages/trangchu.php" class="btn btn-outline-info">Home</a>
                    </div>
                </div>
                <!--Footer-->
                <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->
    <script src="/web_thuongmai/assets/vendor/datatables/datatables.min.js"></script>
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace();
        });
    </script>

    <script>
        $(document).ready(function(){
            function removeSanPhamVaoGioHang(id) {
                // Dữ liệu gởi
                var dulieugoi = {
                    sp_ma: id
                };

                // AJAX đến API xóa sản phẩm khỏi Giỏ hàng trong Session
                $.ajax({
                    url: '/web_thuongmai/backend/functions/ajax/giohang-xoasanpham.php',
                    method: "POST",
                    dataType: 'json',
                    data: dulieugoi,
                    success: function(data) {
                        // Refresh lại trang
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Không thể xử lý</h1>`;
                        $('#thongbao').html(htmlString);
                        // Hiện thông báo
                        $('.alert').removeClass('d-none').addClass('show');
                    }
                });
            };
            
            $('#tblCart').on('click', '#btnDelete', function(event) {
                // debugger;
                event.preventDefault();
                var id = $(this).data('sp-ma');

                console.log(id);
                removeSanPhamVaoGioHang(id);
            });

            // Cập nhật số lượng trong Giỏ hảng
            function capnhatSanPhamTrongGioHang(id, soluong) {
                // Dữ liệu gởi
                var dulieugoi = {
                    sp_ma: id,
                    soluong: soluong
                };

                $.ajax({
                    url: '/web_thuongmai/backend/functions/ajax/giohang-capnhatsanpham.php',
                    method: "POST",
                    dataType: 'json',
                    data: dulieugoi,
                    success: function(data) {
                        // Refresh lại trang
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        var htmlString = `<h1>Không thể xử lý</h1>`;
                        $('#thongbao').html(htmlString);
                        // Hiện thông báo
                        $('.alert').removeClass('d-none').addClass('show');
                    }
                });
            };
            $('#tblCart').on('click', '#btnEdit', function(event) {
                // debugger;
                event.preventDefault();
                var id = $(this).data('sp-ma');
                var soluongmoi = $('#soluong_' + id).val();
                capnhatSanPhamTrongGioHang(id, soluongmoi);
            });
        })
    </script>
</body>

</html>
