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
    <!--Css riêng-->
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/backend/css/chitietsanpham.css">
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
                    <h1 class="h2">Thông tin chi tiết sản phẩm</h1>
                </div>
                <!--Xử lí PHP-->
                <?php 
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    include_once(__DIR__.'/../../dbconnect.php');
                    //Lấy sp_ma từ phía người dùng
                    $sp_ma = $_GET['sp_ma'];
                    //Sản phẩm
                    $sqlSanPham = <<<MMM
                    SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota_ngan, sp.sp_mota_chitiet, sp.sp_soluong, lsp.lsp_ten
                    FROM sanpham sp
                    JOIN loaisanpham lsp on sp.lsp_ma = lsp.lsp_ma
                    WHERE sp.sp_ma = $sp_ma
MMM;
                    $resultSanPham = mysqli_query($conn,$sqlSanPham);
                    $sanphamRow;
                    while ($row = mysqli_fetch_array($resultSanPham, MYSQLI_ASSOC)) {
                        $sanphamRow = array(
                            'sp_ma' => $row['sp_ma'],
                            'sp_ten' => $row['sp_ten'],
                            'sp_giaraw' => $row['sp_gia'],
                            'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ', 
                            'sp_giacu' => number_format($row['sp_giacu'], 2, ".", ",") . ' vnđ',
                            'sp_giacu_raw' => $row['sp_giacu'],
                            'sp_mota_ngan' => $row['sp_mota_ngan'],
                            'sp_mota_chitiet' => $row['sp_mota_chitiet'],
                            'sp_soluong' => $row['sp_soluong'],
                            'lsp_ten' => $row['lsp_ten']
                        );
                    }
                    //Hình sản phẩm
                    $sqlHinhSanPham =<<<AAA
                    SELECT *
                    FROM hinhsanpham 
                    WHERE sp_ma = $sp_ma
                    ORDER BY hsp_ma
                    LIMIT 5
AAA;
                    $resultHinhSanPham = mysqli_query($conn,$sqlHinhSanPham);
                    $danhsachhinhanh = [];
                    while ($hinhsanphamRow = mysqli_fetch_array($resultHinhSanPham, MYSQLI_ASSOC)) {
                        $danhsachhinhanh[] = array(
                            'hsp_ma' => $hinhsanphamRow['hsp_ma'],
                            'hsp_ten' => $hinhsanphamRow['hsp_ten']
                        );
                    }
                    $sanphamRow['danhsachhinhanh'] = $danhsachhinhanh;
                    
                ?>
                <!------------Product details--------------->
                
                <div class="container mt-4 single-product">
                    <form name="frmsanphamchitiet" id="frmsanphamchitiet" method="post" action="">
                        <!------------------------>
                        <!--Lấy thông tin ảnh đầu tiên-->
                        <?php $hinhsanphamdautien = empty($sanphamRow['danhsachhinhanh'][0]) ? '' : $sanphamRow['danhsachhinhanh'][0];?>

                        <input type="hidden" name="sp_ma" id="sp_ma" value="<?= $sanphamRow['sp_ma'] ?>" style="visibility:hidden; width:0px; height:0;" />
                        <input type="hidden" name="sp_ten" id="sp_ten" value="<?= $sanphamRow['sp_ten'] ?>" style="visibility:hidden; width:0px; height:0;"/>
                        <input type="hidden" name="sp_giaraw" id="sp_giaraw" value="<?= $sanphamRow['sp_giaraw'] ?>" style="visibility:hidden; width:0px; height:0;"/>
                        <input type="hidden" name="hinhdaidien" id="hinhdaidien" value="<?= empty($hinhsanphamdautien) ? '' : $hinhsanphamdautien['hsp_ten'] ?>" style="visibility:hidden; width:0px; height:0;"/>
                        <!------------------------>
                        <div class="row">
                            <!--Cột hình ảnh-->
                            <div class="col-md-6" id="imageCol">
                                <!--Nếu có hình ảnh duyệt vòng lặp-->
                                <?php if (count($sanphamRow['danhsachhinhanh']) > 0) : ?>
                                    <?php foreach ($sanphamRow['danhsachhinhanh'] as $hinhsanpham) : ?>
                                        <?php if($hinhsanpham == $hinhsanphamdautien): ?>
                                            <img src="/web_thuongmai/assets/uploads/products/<?= $hinhsanpham['hsp_ten'] ?>" width="100%" height="400px"class="p-0" id="img-first" value="<?= $hinhsanpham['hsp_ma'] ?>" alt="<?= $sanphamRow['sp_ten'] ?>">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    
                                    <div class="small-img-row">
                                        <?php foreach($sanphamRow['danhsachhinhanh'] as $hinhsanpham): ?>
                                            <?php if(!($hinhsanpham == $hinhsanphamdautien)): ?>
                                                <div class="small-img-col">
                                                    <img src="/web_thuongmai/assets/uploads/products/<?= $hinhsanpham['hsp_ten'] ?>" width="100%" id="img-small" value="<?= $hinhsanpham['hsp_ma'] ?>" alt="<?= $sanphamRow['sp_ten'] ?>">
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <img src="/web_thuongmai/assets/shared/img/anastasia/1.jpg" width="100%" height="400px"class="p-0" id="img-first" alt="Anastasia">
                                    <div class="small-img-row">
                                        <div class="small-img-col">
                                            <img src="/web_thuongmai/assets/shared/img/anastasia/12.png" width="100%" id="img-small" alt="Anastasia">
                                        </div>
                                        <div class="small-img-col">
                                            <img src="/web_thuongmai/assets/shared/img/anastasia/34.png" width="100%" id="img-small" alt="Anastasia">
                                        </div>
                                        <div class="small-img-col">
                                            <img src="/web_thuongmai/assets/shared/img/anastasia/41.png" width="100%" id="img-small" alt="Anastasia">
                                        </div>
                                        <div class="small-img-col">
                                            <img src="/web_thuongmai/assets/shared/img/anastasia/65.png" width="100%" id="img-small" alt="Anastasia">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!--Cột thông tin của sản phẩm-->
                            <div class="col-md-6" id="detailCol">
                                <p><?= $sanphamRow['lsp_ten'] ?></p>
                                <h2><?= $sanphamRow['sp_ten'] ?></h2>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <div class="d-flex gia">
                                    <h4 class="sp_gia"><?= $sanphamRow['sp_gia'] ?></h4>
                                    <?php if($sanphamRow['sp_giacu_raw'] == 0): ?>
                                    <?php else:?>
                                        <h4 class="sp_giacu"><?= $sanphamRow['sp_giacu'] ?></h4> <br/>
                                    <?php endif;?>
                                </div>
                                <input type="number" value="0" id="soluong" name="soluong">
                                <a href="#" class="btnAdd" style="text-decoration: none;" id="btnAdd">Add to cart</a>

                                <h3 class="h5">Product Details <i class="fa fa-indent" style="color: #ff523b"></i></h3>
                                <p><?= $sanphamRow['sp_mota_ngan'] ?></p>
                                <p><?= $sanphamRow['sp_mota_chitiet'] ?></p>

                                <!--Vùng alert hiển thị thông báo-->
                                <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
                                    <div id="thongbao">&nbsp;</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!------------------Modal--------------->
                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>
                <!------------Product details--------------->
                <!--Footer-->
                <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->

    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace();
        });
    </script>

    <!--Hiệu ứng với Image Gallery-->
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        var img = document.getElementById("img-first");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
            img.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        $('.close').on('click', function() { 
            modal.style.display = "none";
        })
    </script>

    <!--API cho giỏ hàng-->
    <script>
        function addSanPhamVaoGioHang() {
            debugger;
            // Chuẩn bị dữ liệu gởi
            var dulieugoi = {
                sp_ma: $('#sp_ma').val(),
                sp_ten: $('#sp_ten').val(),
                sp_gia: $('#sp_giaraw').val(),
                hinhdaidien: $('#hinhdaidien').val(),
                soluong: $('#soluong').val(),
            };
            // console.log((dulieugoi));

            // Gọi AJAX đến API ở URL `/php/myhand/frontend/api/giohang-themsanpham.php`
            $.ajax({
                url: '/web_thuongmai/backend/functions/ajax/giohang-themsanpham.php',
                method: "POST",
                dataType: 'json',
                data: dulieugoi,
                success: function(data) {
                    console.log(data);
                    var htmlString =
                        'Sản phẩm đã được thêm vào Giỏ hàng. <a href="/web_thuongmai/backend/functions/shopping_cart.php">Xem Giỏ hàng</a>.';
                    $('#thongbao').html(htmlString);
                    // Hiện thông báo
                    $('.alert').removeClass('d-none').addClass('show');
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

        // Đăng ký sự kiện cho nút Thêm vào giỏ hàng
        $('#btnAdd').on('click',function(event) {
            event.preventDefault();
            addSanPhamVaoGioHang();
        });
    </script>

</body>

</html>
