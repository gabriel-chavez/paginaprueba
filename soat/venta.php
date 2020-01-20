<?php
  //
  $servername = "localhost";
  $username = "root";
  $password = "sesamo";
  $dbname = "cms";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Error en la conexión a la Base de datos: " . $conn->connect_error);
  } 

  $query = 'SELECT * FROM soat_departamentos WHERE 1 ORDER BY departamento';
  
  $result = $conn->query($query);


  $opciones = '';
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if($row["codEntidad"] == $_POST['codEntidad'])
          $selected = 'selected';
        else
          $selected = '';
        $opciones.= '<option value="'.$row["codEntidad"].'" '.$selected.'>'.utf8_encode($row["departamento"]).'</option>';
      }
  } else {
      echo "0 results";
  }

  // generación del iframe
  $codEntidad = 0;
  $eticket = 'UV'.date('dmY') . rand();

  $data = $codEntidad.'_'.substr($eticket,0,15);
  $key = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYzEXAMPLEKEY";
  $key2 = base64_decode($key);

  $pass1 = hash_hmac('sha1', $data, $key2, true);
  $s = urlencode(base64_encode($pass1));

  $codEntidad = $_POST['codEntidad'];
  $codEmpresa = 118;
  $codCriterio = 1;
  $valor = '';


  //$url1 = 'https://test.sintesis.com.bo/IFrame2App-war/paramcompat?codEntidad='.$codEntidad.'&eticket='.$eticket.'&codEmpresa='.$codEmpresa.'&codCriterio='.$codCriterio.'&valor='.$valor.'&s='.$s;
  $url1 = 'https://web.sintesis.com.bo/IFrameAtc/paramcompat?codEntidad=0&eticket='.$eticket.'&codEmpresa='.$codEmpresa.'&codCriterio='.$codCriterio.'&valor='.$valor.'&s='.$s;
  $url2 = 'https://web.sintesis.com.bo/IFrameAtc/paramcompat?codEntidad='.$codEntidad.'&eticket='.$eticket.'&codEmpresa='.$codEmpresa.'&codCriterio='.$codCriterio.'&valor='.$valor.'&s='.$s;
?>

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

      <h1 class="bgLn">Ventas</h1>
      <p>introduzca los datos requeridos pare realizar la compra del SOAT.</p>
      
      <div class="row">
        <form accept="" method="post" class="form-horizontal" id="form">
          <div class="col-md-6 text-right">
            <label class="control-label">Elija su departamento</label>
          </div>
          <div class="col-md-6 text-left">
            <select class="form-control" name="codEntidad" id="codEntidad">
              <option value=""></option>
              <?php echo $opciones?>
            </select>
          </div>
        </form>
        <?php if($_POST['codEntidad'] != ''){?>
        <h3>Formulario de compra</h3>
        <!-- <p>
          Datos:<br>
          <?php echo 'codEntidad: '.$codEntidad.'<br>'; ?>
          <?php echo 'eticket: '.$eticket.'<br>'; ?>
          <?php echo 'codEmpresa: '.$codEmpresa.'<br>'; ?>
          <?php echo 'codCriterio: '.$codCriterio.'<br>'; ?>
          <?php echo 'valor: '.$valor.'<br>'; ?>
          <?php echo 's: '.$s.'<br>'; ?>
        </p>
        <p style="font-size: 13px"><?php echo $url2?></p> -->

        <iframe src="<?php echo $url2?>" width="100%" height="750"></iframe>
        <!-- <h3>Venta normal</h3>
        <p style="font-size: 13px"><?php echo $url1?></p>
        <iframe src="<?php echo $url1?>" width="100%" height="350"></iframe> -->
        <?php }?>
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
