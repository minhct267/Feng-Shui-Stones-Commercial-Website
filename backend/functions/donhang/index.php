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
    <!--File CSS riêng--> 
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
                    <h1 class="h2">Danh sách loại sản phẩm</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="create.php">Create</a>
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="print.php">Print</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!--Lấy dsloaisanpham từ database-->
                    <?php
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL); 
                        include_once(__DIR__.'/../../../dbconnect.php');
                        $sql = <<<EOT
                        SELECT 
                            dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai
                            , SUM(spdh.sp_dh_soluong * spdh.sp_dh_dongia) AS TongThanhTien
                        FROM donhang dh
                        JOIN sanpham_donhang spdh ON dh.dh_ma = spdh.dh_ma
                        JOIN khachhang kh ON dh.kh_ma = kh.kh_ma
                        JOIN hinhthucthanhtoan httt ON dh.httt_ma = httt.httt_ma
                        GROUP BY dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai
EOT;
                        $result = mysqli_query($conn, $sql);
                        $data = [];
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $data[] = array(
                                'dh_ma' => $row['dh_ma'],
                                'dh_ngaylap' => date('d/m/Y', strtotime($row['dh_ngaylap'])),
                                'dh_ngaygiao' => empty($row['dh_ngaygiao']) ? '' : date('d/m/Y', strtotime($row['dh_ngaygiao'])),
                                'dh_noigiao' => $row['dh_noigiao'],
                                'dh_trangthaithanhtoan' => $row['dh_trangthaithanhtoan'],
                                'httt_ten' => $row['httt_ten'],
                                'kh_ten' => $row['kh_ten'],
                                'kh_dienthoai' => $row['kh_dienthoai'],
                                'TongThanhTien' => number_format($row['TongThanhTien'], 2, ".", ",") . ' vnđ'
                            );
                        }
                    ?>
                    <!--Bảng dữ liệu-->
                    <table class="table table-hover text-center" id="tblDonhang">
                        <thead class="thead-light text-nowrap">
                            <tr>
                                <th>Mã Đơn đặt hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày lập</th>
                                <th>Ngày giao</th>
                                <th>Nơi giao</th>
                                <th>Hình thức thanh toán</th>
                                <th>Tổng thành tiền</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Xử lí</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $dh):?>
                                <tr>
                                    <td><?= $dh['dh_ma'] ?></td>
                                    <td><b><?= $dh['kh_ten'] ?></b><br /><?php if(!empty($dh['kh_dienthoai'])): ?>(<?= $dh['kh_dienthoai'] ?>)<?php endif;?></td>
                                    <td><?= $dh['dh_ngaylap'] ?></td>
                                    <td><?= $dh['dh_ngaygiao'] ?></td>
                                    <td><?= $dh['dh_noigiao'] ?></td>
                                    <td><span class="badge badge-primary"><?= $dh['httt_ten'] ?></span></td>
                                    <td><?= $dh['TongThanhTien'] ?></td>
                                    <td>
                                        <?php if ($dh['dh_trangthaithanhtoan'] == 0) : ?>
                                            <span class="badge badge-danger">Chưa xử lý</span>
                                        <?php else : ?>
                                            <span class="badge badge-success">Đã giao hàng</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if($dh['dh_trangthaithanhtoan'] == 0): ?>
                                        <td>
                                            <a href="edit.php?dh_ma=<?= $dh['dh_ma'] ?>" class="btn btn-outline-primary"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></a>
                                            <button class="btn btnDelete btn-outline-primary" data-dh_ma="<?= $dh['dh_ma'] ?>"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16"><path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></button>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <a href="print.php?dh_ma=<?= $dh['dh_ma'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg></a>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!--Footer-->
                <?php include_once(__DIR__.'/../../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../../layouts/scripts.php')  ?>
    <!--File javascript riêng-->
    <script src="/web_thuongmai/assets/vendor/datatables/datatables.min.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/Buttons-1.6.5/js/buttons.bootstrap4.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="/web_thuongmai/assets/vendor/sweetalert/node_modules/sweetalert/dist/sweetalert.min.js"></script>
                
    <script>
        $(document).ready(function(){
            //Datatable
            $("#tblDonhang").DataTable({
                dom: '<"mb-2"B><"row"<"col"l><"col"f>>rtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            //Feather icons
            feather.replace();
            //alert
            $('#tblDonhang').on('click', '.btnDelete', function(){
                swal({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Một khi đã xóa, không thể phục hồi....",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                //debugger;
                if (willDelete) {
                    var dh_ma = $(this).data('dh_ma');
                    var url = "delete.php?dh_ma=" + dh_ma;
                    location.href = url;

                } else {
                    swal("Cẩn thận hơn nhé!");
                }
            });
            })
        });
    </script>
</body>

</html>
