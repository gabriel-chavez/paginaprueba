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
  function city (ci) {
    if (ci!="") {
      $('.todas').hide();
      $('.ciudad').hide();
      $('#'+ci).show();

    }else{
      $('.todas').show();
      $('.ciudad').show();
    };
  }
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

      <h1 class="bgLn">Puntos de venta</h1>

      <p>Adquiera su SOAT   en el punto de venta más cercano,  le mostramos nuestros puntos de venta a Nivel Nacional.</p>

      <form class="formA" action="/" method="post">
        <fieldset>
          <p>
            <label class="labB">Escoge tu ciudad:</label>
            <select name="ct_area" id="ct_area" class="selC" onchange="city(this.value)">
              <option value="">Todas</option>
              <option value="santa">Santa Cruz</option>
              <option value="lapaz">La Paz</option>
              <option value="tarija">Tarija</option>
              <option value="montero">Montero</option>
              <option value="beni">Riberalta</option>
              <option value="trinidad">Trinidad</option>
              <option value="pando">Pando</option>
              <option value="chuquisaca">Chuquisaca</option>
              <option value="potosi">Potosí</option>
              <option value="oruro">Oruro</option>
              <option value="elalto">El Alto</option>
              <option value="yacuiba">Yacuiba</option>
              <option value="cochabamba">Cochabamba</option>
            </select>
          </p>
        </fieldset>
      </form>
      <span class="clear"></span>
      <span class="todas">
        <h2>Todas:</h2>
        <span class="clear"></span>
        <br>
      </span>
      <?php
      $string = "Frente a Transito Av. Mscal. Santa Cruz
			Zona Franca El Alto
			Frente a Transito Av. Mscal. Santa Cruz
			Zona Franca Patacamaya
			Estadio Hernando Siles
			Zona Franca El Alto - Aduana Interior
			CARMAX - Casa Comercial
			Oficinas UNIVIDA
			Oficinas UNIVIDA
			Av. 20 de Octubre Nro. 2782";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='lapaz'><h3>La Paz</h3>";
      echo $newstring.'</span>';



      $string = "2do Anillo Santos Dumont Nro. 58 (BCS Broker)
3er anillo Santos Dumont (frente Tránsito)
Samaipata
Calle Usuri esq. Mamorecillo
Toyosa, Av. Banzer (entre 3er y 4to anillo)
Ovando (Av. La Salle esq. 2do Anillo)
Av. Trinidad detrás del SER
Calle Florida Nº 130
Calle Florida Nº 130
Calle Florida Nº 130
Cotoca";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='santa'><h3>Santa Cruz</h3>";
      echo $newstring.'</span>';





      $string = "Calle Carlos Lazcano N°138";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='tarija'><h3>Tarija</h3>";
      echo $newstring.'</span>';



      $string = "Plaza Principal acera Norte
Calle Santa Cruz No. 287 esq. calle Ángel Mariano Cuellar";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='montero'><h3>Montero</h3>";
      echo $newstring.'</span>';




      $string = "Av. Nicolas Suárez Nro. 486 esq. Medardo Chavez";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='beni'><h3>Riberalta</h3>";
      echo $newstring.'</span>';



      $string = "Av. Germán Busch Esq. Cochabamba Nro. 9 y 11
Av. Ganadera";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='trinidad'><h3>Trinidad</h3>";
      echo $newstring.'</span>';

      $string = "Av. 09 de Febrero, Km. 2, Edif. CIP PANDO Planta Baja";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='pando'><h3>Pando</h3>";
      echo $newstring.'</span>';



      $string = "Calle Bolivar No. 385";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='chuquisaca'><h3>Chuquisaca</h3>";
        echo $newstring.'</span>';



        $string = "Calle Challanta entre calle Smith y 10 de Noviembre
Av. Murillo esq. Ancelmo Tapia
Av. Serrudo N°153 entre Av. Civica y Arce";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='potosi'><h3>Potosí</h3>";
        echo $newstring.'</span>';




        $string = "Calle Raika Backovick No. 2235 entre Sta. Barbara y Jaen
				Aduana Oruro
				Calle Presidente Montes Nro. 5937 entre Junín y Adolfo Mier";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='oruro'><h3>Oruro</h3>";
        echo $newstring.'</span>';


        $string = "Ciudad Satelite Plan 97, Av. Diego de Portugal N. 954
				Av. Juan Pablo II, Frente a Organismo OperativoTransito
				Aduana Interior Puerta de Ingreso
				Av. Juan Pablo II, Frente a Organismo OperativoTransito
				Av. Juan Pablo II, Frente a Hotel Mirador, Zona Final Los Andes
				Av. 6 de Marzo, frente a puerta ingreso Aduana Comercial";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='elalto'><h3>El Alto</h3>";
        echo $newstring.'</span>';



        $string = "Calle Comercio # 1145 entre calles Jacinto Delfin y Juan XXIII";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='yacuiba'><h3>Yacuiba</h3>";
        echo $newstring.'</span>';



        $string = "Av. Panamericana y C. Beni
Av. Ramon Rivero
Av. Uyuni Nº 547";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='cochabamba'><h3>Cochabamba</h3>";
        echo $newstring.'</span>';


        ?>

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
