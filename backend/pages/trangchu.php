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
    <!--CSS tự tạo-->
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/backend/css/trangchu.css">
    <!--Pagniation-->
    <style>
        .simple-pagination ul {
            margin: 0 0 20px;
            padding: 0;
            list-style: none;
            text-align: center;
        }

        .simple-pagination li {
            display: inline-block;
            margin-right: 5px;
        }

        .simple-pagination li a,
        .simple-pagination li span {
            color: #666;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #EEE;
            background-color: #FFF;
            box-shadow: 0px 0px 10px 0px #EEE;
        }

        .simple-pagination .current {
            color: #FFF;
            background-color: #FF7182;
            border-color: #FF7182;
        }

        .simple-pagination .prev.current,
        .simple-pagination .next.current {
            background: #e04e60;
        }
    </style>
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
                
                <!--Xử lí PHP-->
                <?php 
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL); 
                    include_once(__DIR__.'/../../dbconnect.php');
                    $sql = <<<MMM
                    SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_mota_ngan, lsp.lsp_ten, Min(hsp.hsp_ten) AS hsp_ten
                    FROM sanpham sp
                    JOIN loaisanpham lsp ON sp.lsp_ma = lsp.lsp_ma
                    LEFT JOIN hinhsanpham hsp ON sp.sp_ma = hsp.sp_ma
                    GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_mota_ngan, lsp.lsp_ten
MMM;
                    $result = mysqli_query($conn,$sql);
                    $data = [];
                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        $data[] = array(
                            'sp_ma' => $row['sp_ma'],
                            'sp_ten' => $row['sp_ten'],
                            'sp_gia' => $row['sp_gia'],
                            'sp_mota_ngan' => $row['sp_mota_ngan'],
                            'lsp_ten' => $row['lsp_ten'],
                            'hsp_ten' => $row['hsp_ten'],
                        );
                    }
                ?>

                <!--Content-->
                <div class="small-container">
                    <h2 class="title">Feature Products</h2>
                    <div class="row-product">
                        <?php foreach($data as $item): ?>
                            <div class="col-4-product">
                                <a href="/web_thuongmai/backend/functions/chitietsanpham.php?sp_ma=<?= $item['sp_ma'] ?>">
                                <?php if(!empty($item['hsp_ten'])): ?>
                                    <img src="/web_thuongmai/assets/uploads/products/<?= $item['hsp_ten'] ?>">
                                <?php else: ?>
                                    <img src="/web_thuongmai/assets/shared/img/image_icon.png">
                                <?php endif; ?>
                                </a>
                                <h4><?=$item['sp_ten'] ?></h4>
                                <div class="rating">
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star-half-o"></li>
                                </div>
                                <p><?= number_format($item['sp_gia'], 2, ".", ",") . ' vnđ'?></p>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <!--Pagniation-->
                <div id="pagination-container" class="mt-4"></div>

                <!--Footer-->
                <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
            </main>
        </div>
    </div>

    <!--File javascript chung-->
    <?php include_once(__DIR__.'/../layouts/scripts.php')  ?>
    <!--File javascript tự tạo-->
    <!--simplePagination-->
    <script src="/web_thuongmai/assets/vendor/pagniation/jquery.simplePagination.js"></script>
    <!--Nhúng icon feather-->
    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace();
        })
    </script>
    <!--Pagniation-->
    <script>
        var items = $(".row-product .col-4-product");
        var numItems = items.length;
        var perPage = 8;

        items.slice(perPage).hide();

        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "&laquo;",
            nextText: "&raquo;",
            onPageClick: function (pageNumber) {
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
            }
        });
    </script>
</body>
</html>
