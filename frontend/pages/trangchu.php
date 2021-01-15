<?php include_once(__DIR__.'/../layouts/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include_once(__DIR__.'/../layouts/head.php'); ?>
    <link rel="stylesheet" type="text/css" href="/web_thuongmai/assets/frontend/css/img_slide.css" />

</head>

<body class="d-flex flex-column h-100">
    <!-- Header -->   
    <div class="container-fluid" style="padding:10px;">
        <?php include_once(__DIR__.'/../layouts/partials/header.php'); ?>
    </div>
    <!-- Image slide -->
    <div class="container" id="slideshow-container" >
        <div class="mySlides fade">
            <img src="/web_thuongmai/assets/frontend/img/Anastasia.jpg" style="width:100%; height:500px;" class="img-fluid">
        </div>

        <div class="mySlides fade">
            <img src="/web_thuongmai/assets/frontend/img/Anastasia1.png" style="width:100%; height:500px;" class="img-fluid">
        </div>

        <div class="mySlides fade">
            <img src="/web_thuongmai/assets/frontend/img/Anastasia2.jpg" style="width:100%; height:500px;" class="img-fluid">
        </div>
        <br>
        <div style="text-align:center">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>
    </div>
    <!-- Footer -->
    <?php include_once(__DIR__.'/../layouts/partials/footer.php') ?>
    <!-- scripts chung -->
    <?php include_once(__DIR__.'/../layouts/scripts.php'); ?>
    <!-- script cho image slide -->
    <script>
       var slideIndex = 0;
        showSlides();

        function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 2000); // Change image every 2 seconds
        }
    </script>

</body>

</html>