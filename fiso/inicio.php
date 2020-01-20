<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>FISO | UNIVida S.A.</title>
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

        <section class="serv">
        <div class="cntServ">

        	<h1>¿Qué es el FISO?</h1>

						<p>En el caso de ocurrir un accidente de tránsito en el cual el o los vehículos se evadan impidiendo su identificación, la(s) persona(s) lesionada(s), o los beneficiarios del fallecido, para cobrar la indemnización del SOAT, deberán presentar al FISO los documentos descritos en el Art. 29 del Reglamento Único del Seguro Obligatorio de Accidentes de Tránsito SOAT, Decreto Supremo No 27295, entre los cuales el INFORME MÉDICO FORENSE certifique que la(s) lesión(es) o muerte(s) se deben a accidentes de tránsito.</p>

            <ul>
                <li><a href="<?php echo $domain."/guia-de-atencion-de-su-siniestro" ?>">
                    <span class="bxIcoA"></span>
                    Guía de atención de su siniestro
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
