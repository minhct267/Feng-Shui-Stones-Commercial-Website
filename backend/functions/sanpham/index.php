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
                    <h1 class="h2">Danh sách sản phẩm</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="create.php">Create</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php 
                        //Hiển thị lỗi
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);
                        //database
                        include_once(__DIR__.'/../../../dbconnect.php');
                        $sql =<<<MMM
                        SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota_ngan, sp.sp_mota_chitiet, sp.sp_soluong, sp.sp_ngaycapnhat,
		                        lsp.lsp_ma, lsp.lsp_ten, 
                                km.km_ma ,km.km_ten, km.km_chitiet, km.km_tungay, km.km_denngay
                        FROM sanpham sp
                        JOIN loaisanpham lsp ON sp.lsp_ma = lsp.lsp_ma
                        LEFT JOIN khuyenmai km ON sp.km_ma = km.km_ma
                        ORDER BY sp.sp_ma DESC 
MMM;
                        $result = mysqli_query($conn,$sql);
                        $danhsachSanpham = [];
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $km_tomtat = '';
                            if (!empty($row['km_ten'])) {
                                $km_tomtat = sprintf(
                                    "Khuyến mãi %s, nội dung: %s, thời gian: %s-%s",
                                    $row['km_ten'],
                                    $row['km_chitiet'],
                                    date('d/m/Y', strtotime($row['km_tungay'])),    
                                    date('d/m/Y', strtotime($row['km_denngay']))
                                );  
                            }
                            $danhsachSanpham[] = array(
                                'sp_ma' => $row['sp_ma'],
                                'sp_ten' => $row['sp_ten'],
                                'sp_gia' => number_format($row['sp_gia'], 2, ".", ",") . ' vnđ',
                                'sp_giacu' => number_format($row['sp_giacu'], 2, ".", ",") . ' vnđ',
                                'sp_mota_ngan' => $row['sp_mota_ngan'],
                                'sp_mota_chitiet' => $row['sp_mota_chitiet'],
                                'sp_ngaycapnhat' => date('d/m/Y', strtotime($row['sp_ngaycapnhat'])),
                                'sp_soluong' => number_format($row['sp_soluong'], 0, ".", ","),
                                'lsp_ma' => $row['lsp_ma'],
                                'km_ma' => $row['km_ma'],
                                // Các cột dữ liệu lấy từ liên kết khóa ngoại
                                'lsp_ten' => $row['lsp_ten'],
                                'km_tomtat' => $km_tomtat,
                            );
                        }
                    ?>
                    <table class="table table-hover text-center" id="tblSanpham">
                        <thead class="thead-light text-nowrap">
                            <tr>
                                <th>Mã</th>
                                <th>Tên </th>
                                <th>Giá</th>
                                <th>Giá cũ</th>
                                <th>Mô tả ngắn</th>
                                <th>Mô tả chi tiết</th>
                                <th>Ngày cập nhật</th>
                                <th>Số lượng</th>
                                <th>Loại</th>
                                <th>Khuyến mãi</th>
                                <th>Thay đổi</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($danhsachSanpham as $sp): ?>
                            <tr>
                                <td><?= $sp['sp_ma'] ?></td>
                                <td><?= $sp['sp_ten'] ?></td>
                                <td><?= $sp['sp_gia'] ?></td>
                                <td><?= $sp['sp_giacu'] ?></td>
                                <td><?= $sp['sp_mota_ngan'] ?></td>
                                <td><?= $sp['sp_mota_chitiet'] ?></td>
                                <td><?= $sp['sp_ngaycapnhat'] ?></td>
                                <td><?= $sp['sp_soluong'] ?></td>
                                <td><?= $sp['lsp_ten'] ?></td>
                                <td><?= $sp['km_tomtat'] ?></td>
                                <td>
                                    <a href="edit.php?sp=<?= $sp['sp_ma'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></a>
                                </td>
                                <td>
                                    <button class="btn btnDelete btn-outline-primary" data-sp_ma="<?= $sp['sp_ma'] ?>"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16"><path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></button>
                                </td>
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
    <!--File javascript tự tạo-->
    <script src="/web_thuongmai/assets/vendor/datatables/datatables.min.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/Buttons-1.6.5/js/buttons.bootstrap4.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="/web_thuongmai/assets/vendor/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="/web_thuongmai/assets/vendor/sweetalert/node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace();
            //Datatable
            $("#tblSanpham").DataTable({
                dom: '<"mb-2"B><"row"<"col"l><"col"f>>rtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            //alert
            $('#tblSanpham').on('click', '.btnDelete', function(){
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
                    var sp_ma = $(this).data('sp_ma');
                    var url = "delete.php?sp=" + sp_ma;
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
