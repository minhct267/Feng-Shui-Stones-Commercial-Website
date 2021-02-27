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
                    <h1 class="h2">Danh sách hình sản phẩm</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="create.php">Create</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!--Lấy danh sách hình ảnh từ database-->
                    <?php
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);
                        include_once(__DIR__.'/../../../dbconnect.php');
                        $sql=<<<MMM
                        SELECT *
                        FROM hinhsanpham hsp
                        JOIN sanpham sp on hsp.sp_ma = sp.sp_ma
MMM;
                        $result = mysqli_query($conn,$sql);
                        $data = [];
                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                            $sp_tomtat = sprintf(
                                "Sản phẩm: %s, giá: %s",
                                $row['sp_ten'],
                                number_format($row['sp_gia'], 2, ".", ",") . ' vnđ'
                            );
                            $data[] = array(
                                'hsp_ma' => $row['hsp_ma'],
                                'hsp_ten' => $row['hsp_ten'],
                                'sp_tomtat' => $sp_tomtat
                            );
                        };
                    ?>
                    <!--Bảng dữ liệu-->
                    <table class="table table-hover text-center" id="tblHinhsanpham">
                        <thead class="thead-light">
                            <tr>
                                <th>Mã</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình</th>
                                <th>Thay đổi</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $hsp): ?>
                                <tr>
                                    <td><?= $hsp['hsp_ma'] ?></td>
                                    <td><?= $hsp['sp_tomtat'] ?></td>
                                    <td>
                                        <img src="/web_thuongmai/assets/uploads/products/<?= $hsp['hsp_ten'] ?>" class="img-fluid" width="100px" style="border-radius:7px; border:1px solid lightgrey">
                                    </td>
                                    <td>
                                        <a href="edit.php?hsp=<?= $hsp['hsp_ma'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></a>
                                    </td>
                                    <td>
                                        <button class="btn btnDelete btn-outline-primary" data-hsp_ma="<?= $hsp['hsp_ma'] ?>"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16"><path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></button>
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
            $("#tblHinhsanpham").DataTable({
                dom: '<"mb-2"B><"row"<"col"l><"col"f>>rtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            //Feather icons
            feather.replace();
            //alert
            $('#tblHinhsanpham').on('click', '.btnDelete', function(){
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
                    var hsp_ma = $(this).data('hsp_ma');
                    var url = "delete.php?hsp=" + hsp_ma;
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
