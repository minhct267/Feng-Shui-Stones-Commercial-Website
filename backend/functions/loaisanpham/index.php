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
                        $sql = "SELECT* FROM loaisanpham";
                        $result = mysqli_query($conn, $sql);
                        $ds_loaisanpham = [];
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $ds_loaisanpham[] = array(
                                'lsp_ma' => $row['lsp_ma'],
                                'lsp_ten' => $row['lsp_ten'],
                                'lsp_mota' => $row['lsp_mota'],
                            );
                        }
                    ?>
                    <!--Bảng dữ liệu-->
                    <table class="table table-hover text-center" id="tblLoaisanpham">
                        <thead class="thead-light">
                            <tr>
                                <th>Mã</th>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Thay đổi</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ds_loaisanpham as $lsp): ?>
                                <tr>
                                    <td><?= $lsp['lsp_ma'] ?></td>
                                    <td><?= $lsp['lsp_ten'] ?></td>
                                    <td><?= $lsp['lsp_mota'] ?></td>
                                    <td>
                                        <a href="edit.php?lsp=<?= $lsp['lsp_ma'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></a>
                                    </td>
                                    <td>
                                        <button class="btn btnDelete btn-outline-primary" data-lsp_ma="<?= $lsp['lsp_ma'] ?>"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16"><path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            $("#tblLoaisanpham").DataTable({
                dom: '<"mb-2"B><"row"<"col"l><"col"f>>rtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            //Feather icons
            feather.replace(); 
            //alert
            $('#tblLoaisanpham').on('click', '.btnDelete', function(){
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
                    var lsp_ma = $(this).data('lsp_ma');
                    var url = "delete.php?lsp=" + lsp_ma;
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
