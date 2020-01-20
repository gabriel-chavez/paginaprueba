
<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
  <title>Puntos de venta | SOAT | UNIVida S.A.</title>
  <link rel="shortcut icon" href="<?php echo $domain ?>/lib/favicon.ico" />
  <link rel="stylesheet" href="<?php echo $domain ?>/css/style.css">

  <script src="<?php echo $domain ?>/js/jquery.min.js"></script>
  <script src="<?php echo $domain ?>/js/jquery.flexslider.js"></script>
  <script type="text/javascript">
  $(window).load(function(){
    $('.flexslider').flexslider({
      animation: "fade"});
  });

  $(document).ready(function () {
    $('#codEntidad').change( function () {
      $('#form').submit();
    });
  });
  </script>
  <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122046420-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-122046420-1');
  </script>
</head>

<body>

  <div class="wrapper">

   <?php include 'skin/header.php' ?>

   <section class="contentIn">
    <div class="cntCntIn">
      
      <div class="row">
        <iframe src="http://dev1.vulcan.technology:83/" width="100%" height="750"></iframe>
      </div>
    </div>
  </section>

    <?php include 'skin/footer.php' ?>

  </div>

  <script src="<?php echo $domain ?>/js/jquery.pageslide.min.js"></script>
  <script>
  $(".open").pageslide();
  </script>

</body>
</html>
