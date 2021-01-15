<?php include_once(__DIR__.'/../layouts/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include_once(__DIR__.'/../layouts/head.php'); ?>

</head>

<body class="d-flex flex-column h-100">

    <div class="container-fluid" style="padding:10px;">
        <?php include_once(__DIR__.'/../layouts/partials/header.php'); ?>
    </div>

    <div>
        <?php include_once(__DIR__.'/../layouts/partials/navbar.php'); ?>
    </div>

    <div class="text-center" style="margin:10px 0px;">
        <img src="/web_thuongmai/assets/frontend/img/Anastasia.jpg" class="img-fluid" style="height:550px;" >
    </div>

    <div class="jumbotron text-center">
        <h1>Content here</h1>
    </div>

    <div class="jumbotron text-center">
        <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
    </div>

    <?php include_once(__DIR__.'/../layouts/scripts.php'); ?>

</body>

</html>