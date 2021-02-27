<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/vendor/paper-css/paper-css.css">
    <!--Định khổ giấy-->
    <style>
        @page {
            size: A4
        }
    </style>
</head>
<body class="A4" style="font-size:17px;">
    <?php
    //Kết nối database
    include_once(__DIR__ . '/../../../dbconnect.php');
    //Lấy dữ liệu Đơn hàng
    $dh_ma = $_GET['dh_ma'];
    $sqlSelectDonDatHang = <<<EOT
    SELECT 
        dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai
        , SUM(spdh.sp_dh_soluong * spdh.sp_dh_dongia) AS TongThanhTien
    FROM donhang dh
    JOIN sanpham_donhang spdh ON dh.dh_ma = spdh.dh_ma
    JOIN khachhang kh ON dh.kh_ma = kh.kh_ma
    JOIN hinhthucthanhtoan httt ON dh.httt_ma = httt.httt_ma
    GROUP BY dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ten, kh.kh_dienthoai    
EOT;
    $resultSelectDonDatHang = mysqli_query($conn, $sqlSelectDonDatHang);
    $dataDonDatHang;
    while ($row = mysqli_fetch_array($resultSelectDonDatHang, MYSQLI_ASSOC)) {
        $dataDonDatHang = array(
            'dh_ma' => $row['dh_ma'],
            'dh_ngaylap' => date('d/m/Y H:i:s', strtotime($row['dh_ngaylap'])),
            'dh_ngaygiao' => empty($row['dh_ngaygiao']) ? '' : date('d/m/Y', strtotime($row['dh_ngaygiao'])),
            'dh_noigiao' => $row['dh_noigiao'],
            'dh_trangthaithanhtoan' => $row['dh_trangthaithanhtoan'],
            'httt_ten' => $row['httt_ten'],
            'kh_ten' => $row['kh_ten'],
            'kh_dienthoai' => $row['kh_dienthoai'],
            'TongThanhTien' => number_format($row['TongThanhTien'], 2, ".", ",") . ' vnđ',
        );
    }

    //Lấy dữ liệu Sản phẩm đơn đặt hàng
    $sqlSelectSanPham =<<<MMM
    SELECT 
        sp.sp_ma, sp.sp_ten, spdh.sp_dh_dongia, spdh.sp_dh_soluong
        , lsp.lsp_ten
    FROM sanpham_donhang spdh
    JOIN sanpham sp ON spdh.sp_ma = sp.sp_ma
    JOIN loaisanpham lsp ON sp.lsp_ma = lsp.lsp_ma
    WHERE spdh.dh_ma=$dh_ma
MMM;
    $resultSelectSanPham = mysqli_query($conn, $sqlSelectSanPham);
    $dataSanPham = [];
    while ($row = mysqli_fetch_array($resultSelectSanPham, MYSQLI_ASSOC)) {
        $dataSanPham[] = array(
            'sp_ma' => $row['sp_ma'],
            'sp_ten' => $row['sp_ten'],
            'sp_dh_dongia' => $row['sp_dh_dongia'],
            'sp_dh_soluong' => $row['sp_dh_soluong'],
            'lsp_ten' => $row['lsp_ten'],
        );
    }
    $dataDonDatHang['danhsachsanpham'] = $dataSanPham;
    ?>

    <section class="sheet padding-10mm">
        <!--Header-->
        <table border="0" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td align="center"><img src="/web_thuongmai/assets/shared/img/print_icon.jpg" width="100px" height="100px"></td>
                    <td align="center">
                        <b style="font-size:20px;text-transform:uppercase;">vườn đá của nấm</b><br/>
                        <small>Bla Bla Bla</small>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Thông tin đơn hàng -->
        <p><i><u>Thông tin Đơn hàng</u></i></p>
        <table border="0" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <td width="30%">Khách hàng:</td>
                    <td><b>
                    <?= $dataDonDatHang['kh_ten'] ?> 
                    <?php if($dataDonDatHang['kh_dienthoai']==''): ?>
                    <?php else:?>
                        (<?= $dataDonDatHang['kh_dienthoai'] ?>)
                    <?php endif;?>
                    </b></td>
                </tr>
                <tr>
                    <td>Ngày lập:</td>
                    <td><b><?= $dataDonDatHang['dh_ngaylap'] ?></b></td>
                </tr>
                <tr>
                    <td>Hình thức thanh toán:</td>
                    <td><b><?= $dataDonDatHang['httt_ten'] ?></b></td>
                </tr>
                <tr>
                    <td>Tổng thành tiền:</td>
                    <td><b><?= $dataDonDatHang['TongThanhTien'] ?></b></td>
                </tr>
            </tbody>
        </table>

        <!-- Thông tin sản phẩm -->
        <p><i><u>Chi tiết đơn hàng</u></i></p>
        <table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach($dataDonDatHang['danhsachsanpham'] as $sanpham): ?>
                <tr>
                    <td align="center"><?= $stt; ?></td>
                    <td>
                        <b><?= $sanpham['sp_ten'] ?></b><br />
                        <small><i><?= $sanpham['lsp_ten'] ?></i></small><br />
                    </td>
                    <td align="right"><?= $sanpham['sp_dh_soluong'] ?></td>
                    <td align="right"><?= $sanpham['sp_dh_dongia'] ?></td>
                    <td align="right"><?= $sanpham['sp_dh_soluong'] * $sanpham['sp_dh_dongia'] ?></td>
                </tr>
                <?php $stt++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right"><b>Tổng thành tiền</b></td>
                    <td align="right"><b><?= $dataDonDatHang['TongThanhTien'] ?></b></td>
                </tr>
            </tfoot>
        </table>
        <!-- Thông tin Footer -->
        <br />
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <small>Xin cám ơn Quý khách đã ủng hộ Cửa hàng, Chúc Quý khách An Khang, Thịnh Vượng!</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>


</body>
</html>