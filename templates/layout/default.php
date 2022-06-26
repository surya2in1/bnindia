<?php
use Cake\Routing\Router;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
     <!-- Basic Page Needs ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="Supermarket, 750 Branches, Fixed Deposits " />
    <meta name="description" content="Shriram Chits">
    <meta name="google-site-verification" content="7x4DBO783a8DoXY0De_F6KaRFiGWEONeDDJszSNp93o" />
    <meta name="facebook-domain-verification" content="saptetm41p8l7eoox8n85tssb6o00n" />
    <title>Welcome to Shriram Chits - Wise Investments - Wise Borrowings</title>
    <link rel="icon" type="image/png" href="/css/logos/logo11.png">

    <!-- CSS
    ================================================== -->
      <!-- Bootstrap -->
      <link rel="stylesheet" href="css/theme/plugins/bootstrap/bootstrap.min.css">
      <!-- FontAwesome -->
      <link rel="stylesheet" href="css/theme/plugins/fontawesome/css/all.min.css">
      <!-- Animation -->
      <link rel="stylesheet" href="css/theme/plugins/animate-css/animate.css">
      <!-- slick Carousel -->
      <link rel="stylesheet" href="css/theme/plugins/slick/slick.css">
      <link rel="stylesheet" href="css/theme/plugins/slick/slick-theme.css">
      <!-- Colorbox -->
      <link rel="stylesheet" href="css/theme/plugins/colorbox/colorbox.css">
      <!-- Template styles-->
      <link rel="stylesheet" href="css/theme/css/style.css">
</head>
<body>
    <div class="body-inner">

    <div id="top-bar" class="top-bar" style="padding: 0 !important;background: none !important;">
    </div>
    <!--/ Topbar end -->

    <!-- begin:: Header -->
     <?= $this->element('theme_header'); ?>
    <!-- end:: Header -->
   
    <?= $this->fetch('content') ?>  
    
    <footer id="footer" class="footer bg-overlay">
        <?= $this->element('theme_footer'); ?>
    </footer><!-- Footer end -->

  <!-- Javascript Files
  ================================================== -->

  <!-- initialize jQuery Library -->
  <script src="js/theme/plugins/jQuery/jquery.min.js"></script>
  <!-- Bootstrap jQuery -->
  <script src="js/theme/plugins/bootstrap/bootstrap.min.js" defer></script>
  <!-- Slick Carousel -->
  <script src="js/theme/plugins/slick/slick.min.js"></script>
  <script src="js/theme/plugins/slick/slick-animation.min.js"></script>
  <!-- Color box -->
  <script src="js/theme/plugins/colorbox/jquery.colorbox.js"></script>
  <!-- shuffle -->
  <script src="js/theme/plugins/shuffle/shuffle.min.js" defer></script>


  <!-- Google Map API Key-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
  <!-- Google Map Plugin-->
  <script src="js/theme/plugins/google-map/map.js" defer></script>

  <!-- Template custom -->
  <script src="js/theme/js/script.js"></script>

  </div><!-- Body inner end -->
</body>
</html>
