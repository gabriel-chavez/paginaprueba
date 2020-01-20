<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>SOAT | UNIVida S.A.</title>
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

    <script type="text/javascript" src="js/shadowbox.js"></script>
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
        
        <section class="serv">
        <div class="cntServ">
        
        	<h1>¿Qué es el SOAT?</h1>

            <p>Es el seguro obligatorio de accidentes de tránsito que todo vehículo debe tener, el cual  ampara los gastos médicos, muerte e incapacidad total y permanente , en caso de un accidente de tránsito.</p>

            <!--<a href="http://app-desarrollo/UNIVidaNetSorteo/" target="_blank" class="btn02" data-lity>Sorteo</a>-->

            <ul>
                <li><a href="<?php echo $domain."/guia-de-atencion-de-su-siniestro" ?>">
                    <span class="bxIcoA"></span>
                    Guía de atención de su siniestro
                </a></li>
                <li><a href="<?php echo $domain."/precios" ?>">
                    <span class="bxIcoB"></span>
                    Precios SOAT
                </a></li>
                <li><a href="<?php echo $domain."/puntos-de-venta" ?>">
                    <span class="bxIcoC"></span>
                    Puntos de Venta
                </a></li>
                <li><a href="<?php echo $domain."/formulario-soat" ?>">
                    <span class="bxIcoD"></span>
                    Comprobante SOAT
                </a></li>
                <!-- <li><a target="_blank" href="http://181.188.175.133:9097/Modulos_/Cliente/Login/wfLoginCliente">
                    <span class="bxIcoH"></span>
                    Modificar Datos
                </a></li>
                <li><a href="<?php echo $domain."/consulta-para-verificación-de-vigencia-de-soat" ?>">
                    <span class="bxIcoE"></span>
                    Consulta para verificación de vigencia de SOAT
                </a></li>
                <li><a href="<?php echo $domain."/puntos-de-venta?p=1" ?>">
                    <span class="bxIcoG"></span>
                    Compra tu SOAT
                </a></li>
                <li><a href="<?php echo $domain."/contactanos" ?>">
                    <span class="bxIcoF"></span>
                    Contáctanos
                </a></li> -->
            </ul>
            <ul><!-- 
                <li><a href="<?php echo $domain."/guia-de-atencion-de-su-siniestro" ?>"> -->
                <!--     <span class="bxIcoA"></span>
                    Guía de atención de su siniestro
                </a></li>
                <li><a href="<?php echo $domain."/precios-2017" ?>">
                    <span class="bxIcoB"></span>
                    Precios SOAT
                </a></li>
                <li><a href="<?php echo $domain."/puntos-de-venta" ?>">
                    <span class="bxIcoC"></span>
                    Puntos de Venta
                </a></li>
                <li><a href="<?php echo $domain."/formulario-soat" ?>">
                    <span class="bxIcoD"></span>
                    Comprobante SOAT
                </a></li> -->
                <li><a target="_blank" href="http://soat.univida.bo:9097/UNIVidaNetSOATClienteFinal/Modulos_/Cliente/Login/wfLoginCliente">
                    <span class="bxIcoH"></span>
                    Modificar Datos
                </a></li>
                <li><a href="<?php echo $domain."/consulta-para-verificación-de-vigencia-de-soat" ?>">
                    <span class="bxIcoE"></span>
                    Consulta para verificación de vigencia de SOAT
                </a></li>
                <li><a href="<?php echo $domain."/puntos-de-venta?p=1" ?>">
                    <span class="bxIcoG"></span>
                    Compra tu SOAT
                </a></li>
                <li><a href="<?php echo $domain."/contactanos" ?>">
                    <span class="bxIcoF"></span>
                    Contáctanos
                </a></li>
            </ul>
        </div>
        </section>
        <br>
        <a href="../ganadoresSOAT2017.pdf" download="ganadoresSOAT2017.pdf">
              </a>        
        <?php include 'skin/footer.php' ?>
         
    </div>
     
    <script src="<?php echo $domain ?>/js/jquery.pageslide.min.js"></script>
    <script>
        $(".open").pageslide();
    </script>
        
</body>
</html>
