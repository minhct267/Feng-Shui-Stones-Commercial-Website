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
    <!--Nhúng ChartJs-->
    <link rel="stylsheet" type="text/css" href="/web_thuongmai/assets/vendor/chart/dist/Chart.min.css">
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
                    <h1 class="h2">Dashboard</h1>
                </div>
                <!----------------------------------------------------->
                <div class="row">
                    <!--Tổng số mặt hàng-->
                    <div class="col-sm-6 col-lg-3 mt-2">
                        <div class="card text-white bg-primary mb-2">
                            <div class="card-body pb-0">
                                <div class="text-value" id="baocaoSanPham_SoLuong">
                                    <h1>0</h1>
                                </div>
                                <div style="font-size:large">Tổng số mặt hàng</div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm form-control" id="refreshBaoCaoSanPham">Refresh dữ liệu</button>
                    </div>
                    <!--End-->

                    <!--Tổng loại sản phẩm-->
                    <div class="col-sm-6 col-lg-3 mt-2">
                        <div class="card text-white bg-success mb-2">
                            <div class="card-body pb-0">
                                <div class="text-value" id="baocaoLoaiSanPham_SoLuong">
                                    <h1>0</h1>
                                </div>
                                <div style="font-size:large">Tổng số loại sản phẩm</div>
                            </div>
                        </div>
                        <button class="btn btn-success btn-sm form-control" id="refreshBaoCaoLoaiSanPham">Refresh dữ liệu</button>
                    </div>
                    <!--End-->

                    <!--Tổng số đơn hàng-->
                    <div class="col-sm-6 col-lg-3 mt-2">
                        <div class="card text-white bg-warning mb-2">
                            <div class="card-body pb-0">
                                <div class="text-value" id="baocaoDonHang_SoLuong">
                                    <h1>0</h1>
                                </div>
                                <div style="font-size:large">Tổng số đơn hàng</div>
                            </div>
                        </div>
                        <button class="btn btn-warning btn-sm form-control" id="refreshBaoCaoDonHang">Refresh dữ liệu</button>
                    </div>
                    <!--End-->

                    <!--Tổng số đơn hàng-->
                    <div class="col-sm-6 col-lg-3 mt-2">
                        <div class="card text-white bg-info mb-2">
                            <div class="card-body pb-0">
                                <div class="text-value" id="baocaoKhachHang_SoLuong">
                                    <h1>0</h1>
                                </div>
                                <div style="font-size:large">Tổng số khách hàng</div>
                            </div>
                        </div>
                        <button class="btn btn-info btn-sm form-control" id="refreshBaoCaoKhachHang">Refresh dữ liệu</button>
                    </div>
                    <!--End-->
                </div>
                <!--Biểu đồ-->
                <div class="mt-4 row">
                    <!--Biểu đồ mối quan hệ giữa Loại sản phẩm và số sản phẩm của loại đó-->
                    <div class="col-md-6">
                        <canvas id="chartOfobjChartThongKeLoaiSanPham"></canvas>
                        <button class="btn btn-outline-primary btn-sm form-control" id="refreshThongKeLoaiSanPham">Refresh dữ liệu</button>
                    </div>
                    <!--End-->
                </div>
                <!----------------------------------------------------->
                <!--Footer-->
                <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->
        <!--Nhúng ChartJs-->
    <script src="/web_thuongmai/assets/vendor/chart/dist/Chart.min.js"></script>
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace();

            //---------------------------------------------
            //Ajax
            //Báo cáo tổng số mặt hàng
            function getDuLieuBaoCaoTongSoMatHang() {
                //debugger;
                $.ajax('/web_thuongmai/backend/functions/ajax/tongmathang.php', {
                success: function(data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.soluong_sanpham}</h1>`;
                    $('#baocaoSanPham_SoLuong').html(htmlString);
                },
                error: function() {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoSanPham_SoLuong').html(htmlString);
                }
                });
            }
            $('#refreshBaoCaoSanPham').click(function(event) {
                event.preventDefault();
                getDuLieuBaoCaoTongSoMatHang();
            });
            //Báo cáo tổng loại sản phẩm
            function getDuLieuBaoCaoLoaiSanPham() {
                //debugger;
                $.ajax('/web_thuongmai/backend/functions/ajax/tongloaisanpham.php', {
                success: function(data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.soluong_loaisanpham}</h1>`;
                    $('#baocaoLoaiSanPham_SoLuong').html(htmlString);
                },
                error: function() {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoLoaiSanPham_SoLuong').html(htmlString);
                }
                });
            }
            $('#refreshBaoCaoLoaiSanPham').click(function(event) {
                event.preventDefault();
                getDuLieuBaoCaoLoaiSanPham();
            });
            //Báo cáo tổng đơn hàng
            function getDuLieuBaoCaoDonHang() {
                //debugger;
                $.ajax('/web_thuongmai/backend/functions/ajax/tongdonhang.php', {
                success: function(data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.soluong_donhang}</h1>`;
                    $('#baocaoDonHang_SoLuong').html(htmlString);
                },
                error: function() {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoDonHang_SoLuong').html(htmlString);
                }
                });
            }
            $('#refreshBaoCaoDonHang').click(function(event) {
                event.preventDefault();
                getDuLieuBaoCaoDonHang();
            });
            //Báo cáo tổng khách hàng
            function getDuLieuBaoCaoKhachHang() {
                //debugger;
                $.ajax('/web_thuongmai/backend/functions/ajax/tongkhachhang.php', {
                success: function(data) {
                    var dataObj = JSON.parse(data);
                    var htmlString = `<h1>${dataObj.soluong_khachhang}</h1>`;
                    $('#baocaoKhachHang_SoLuong').html(htmlString);
                },
                error: function() {
                    var htmlString = `<h1>Không thể xử lý</h1>`;
                    $('#baocaoKhachHang_SoLuong').html(htmlString);
                }
                });
            }
            $('#refreshBaoCaoKhachHang').click(function(event) {
                event.preventDefault();
                getDuLieuBaoCaoKhachHang();
            });
            //Chạy hàm khi trang được chạy
            getDuLieuBaoCaoTongSoMatHang();
            getDuLieuBaoCaoKhachHang();
            getDuLieuBaoCaoDonHang();
            getDuLieuBaoCaoLoaiSanPham();

            //----------------------------
            //Biểu đồ Tên loại sản phẩm - Số lượng sản phẩm 
            var $objChartThongKeLoaiSanPham;
            var $chartOfobjChartThongKeLoaiSanPham = document.getElementById("chartOfobjChartThongKeLoaiSanPham").getContext(
                "2d");

            function renderChartThongKeLoaiSanPham() {
                $.ajax({
                url: '/web_thuongmai/backend/functions/ajax/thongke_loaisanpham.php',
                type: "GET",
                success: function(response) {
                    var data = JSON.parse(response);
                    var myLabels = [];
                    var myData = [];
                    $(data).each(function() {
                        myLabels.push((this.ten_loai));
                        myData.push(this.soluong_sanpham);
                    });
                    myData.push(0); // tạo dòng số liệu 0
                    if (typeof $objChartThongKeLoaiSanPham !== "undefined") {
                        $objChartThongKeLoaiSanPham.destroy();
                    }
                    $objChartThongKeLoaiSanPham = new Chart($chartOfobjChartThongKeLoaiSanPham, {
                    // Kiểu biểu đồ muốn vẽ. Các bạn xem thêm trên trang ChartJS
                    type: "bar",
                    data: {
                        labels: myLabels,
                        datasets: [{
                        data: myData,
                        borderColor: "#9ad0f5",
                        backgroundColor: "#9ad0f5",
                        borderWidth: 1
                        }]
                    },
                    // Cấu hình dành cho biểu đồ của ChartJS
                    options: {
                        legend: {
                        display: false
                        },
                        title: {
                        display: true,
                        text: "Thống kê Loại sản phẩm"
                        },
                        responsive: true
                    }
                    });
                }
                });
            };
            $('#refreshThongKeLoaiSanPham').click(function(event) {
                event.preventDefault();
                renderChartThongKeLoaiSanPham();
            });
            //Vẽ biểu đồ khi khởi động trang
            renderChartThongKeLoaiSanPham();        
        });
    </script>
</body>

</html>
