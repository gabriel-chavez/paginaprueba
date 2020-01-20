<?php
 $tel="(591-2) 2151000";
 $dir="Av. Camacho, esquina Calle Bueno, N° 1485, Edificio La Urbana, piso 3.";
 $mail="atencionalcliente@univida.bo";
 ?>
<!DOCTYPE html>
<html lang="es" xml:lang="es">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>Contáctanos | SOAT | UNIVida S.A.</title>
    <link rel="shortcut icon" href="favicon.ico" />

    <link rel="stylesheet" href="<?php echo $domain ?>/css/style.css">

    <script src="<?php echo $domain ?>/js/jquery.min.js"></script>
    <script src="<?php echo $domain ?>/js/jquery.flexslider.js"></script>
    <script src="<?php echo $domain ?>/js/validable4.js"></script>
    <script src="<?php echo $domain ?>/js/contacto.js"></script>
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
	<input type="hidden" id="domain" value="<?php echo $domain ?>"/>

    <div class="wrapper">

       <?php include 'skin/header.php' ?>

      <section class="contentIn">
        <div class="cntCntIn">

            <h1 class="bgLn">Contáctanos</h1>

            <p>Cualquier información adicional no dude en contactarnos  o  comunicarse  con nuestra línea de atención al cliente.</p>
				<br/>
            <span class="txtResponse" id="messageBox" style="display:none;"><?php if(!empty($_SESSION['MSG'])){ echo $_SESSION['MSG'];}?></span>
            <?php
            if(!empty($_SESSION['MSG'])){
              unset($_SESSION['MSG']);
            }
            ?>
            </br>
            <form class="formA validable" action="#" method="post" id="formContact">
             <fieldset>
                <div class="bxTxtI">
                    <ul class="contact-info">
                        <li class="telephone">
                          <?php echo $tel?>
                        </li>
                        <li class="address">
                        <?php echo $dir?>
                        </li>
                        <li class="mail">
                        <?php echo $mail?>
                        </li>
                        <li class="redesSociales">	
                          <span class="facebook"></span>
                          <span class="instagram"></span>
                          <span class="linkedin"></span>
                          <span class="youTube"></span>
                          UNIVida S.A
                        </li>
                        
                      </ul>
                  </div>
                 <p>
                     <input type="text" id="nombre" placeholder="Tu nombre" size="90" class="inpB required alphanum" name="name" autocomplete="off"/>
                     <span id="div_nombre" style="display:none;" class="bxEr">requerido</span>
                     <span id="div_nombre_2" style="display:none;" class="bxEr">invalido</span>
                 </p>
                 <p>
                      <input type="text" id="email" placeholder="Tu email" size="90" class="inpB required email" name="email" autocomplete="off"/>
                      <span id="div_email" style="display:none;" class="bxEr">requerido</span>
                      <span id="div_email_2" style="display:none;" class="bxEr">invalido</span>
                 </p>
                 <p>
                      <textarea name="message" id="message" placeholder="Tu mensaje" cols="90" rows="4" class="required alphanum"></textarea>
                 </p>
                 <p class="boxError" style="display:none">
                   <span class="cntEr" >Los campos son incorrectos</span>
                 </p>
                  <p>
                    <!-- <input type="button" value="enviar mensaje" class="button" id="btnSendMail"/> -->
                    <input type="button" value="enviar mensaje" class="button" id="sbmSendMail"/>
                  </p>
                </fieldset>
              </form>
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
