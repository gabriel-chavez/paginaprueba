<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>Consulta para verificación de vigencia de SOAT | SOAT | UNIVida S.A.</title>
    <link rel="shortcut icon" href="<?php echo $domain ?>/lib/favicon.ico" />
    
    <link rel="stylesheet" href="<?php echo $domain ?>/css/style.css">
    
    <script src="<?php echo $domain ?>/js/jquery.min.js"></script>
    <script src="<?php echo $domain ?>/js/jquery.flexslider.js"></script>
      <script type="text/javascript">
        $(window).load(function(){
          $('.flexslider').flexslider({
            animation: "fade"});
        });
      </script>
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
        
            <h1 class="bgLn">Consulta para verificación de vigencia de SOAT</h1>

            <p>A continuación usted  puede consultar si el vehículo cuenta con la cobertura del seguro  SOAT  haciendo clic en la siguiente pestaña.</p>

            <a href="https://soat.univida.bo:9097/UNIVidaNetSOATClienteFinal/Modulos_/Cliente/ConsultasVerificacionSoat/wfObtener" target="_blank" class="btn02">Verificar vigencia SOAT</a>

            <?php if(date('Y') == 2017){?>
            <a href="http://consortium.alianza.com.bo/unividasoat/Home" target="_blank" class="btn02">Verificar vigencia 2017</a>
            <?php }?>
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
