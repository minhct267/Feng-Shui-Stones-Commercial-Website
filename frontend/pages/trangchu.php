<?php include_once(__DIR__.'/../layouts/config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php include_once(__DIR__.'/../layouts/head.php') ?>

</head>
<body>
    <!-- Header-->
    <?php include_once(__DIR__.'/../layouts/partials/header.php') ?>

    <!-- Slide-->
    <?php include_once(__DIR__.'/../layouts/partials/slider.php') ?>

    <!-- content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="border:1px solid red; width:100%; height:500px;">

            </div>
            <div class="col-md-3" style="border:1px solid blue;width:100%; height:500px;">
            
            </div>
        </div>
    </div>

    <!-- Footer-->
    <footer>
        <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
    </footer>
    <!-- File script  -->
    <?php include_once(__DIR__.'/../layouts/scripts.php') ?>

    <script>
        $(document).ready(function(){
            //Feather icons
            feather.replace()
        });
    </script>

    <script src="/web_thuongmai/assets/frontend/js/image_slide.js"></script>    
</body>
</html>