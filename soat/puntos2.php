<?php
// try {
//     $client = new SoapClient("http://localhost:1380/Modulos/Ventas/Apk/wsVentasApk.svc?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
//     $param = array("Contrasenia" => "123", "Usuario" => "UNIVida");
//     $ready = $client->ApkVen08ObtieneCatalogo(array('oEApkVen08ObtieneCatalogo' => array("Placa" => null, "PuntoVenta" => null, "Contrasenia" => "123", "Usuario" => "UNIVida")));
//     echo '<pre>';
//     print_r($ready);
//     echo '</pre>';

//     $resultado = $ready->ApkVen08ObtieneCatalogoResult->lApkVen08Catalogo->CApkVen08Catalogo;

//     foreach($resultado as $res){
//       echo $res->Catalogo;
//     }

// } catch (Exception $e) {
//     trigger_error($e->getMessage(), E_USER_WARNING);
// }

if($_GET["p"] == ""){
?>


<?php
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
        if($row["sigla"] == $_POST['ct_area'])
          $selected = 'selected';
        else
          $selected = '';
        $opciones.= '<option value="'.$row["sigla"].'" '.$selected.'>'.utf8_encode($row["departamento"]).'</option>';
      }
  }

  $opt_ciudad = '';
  $query = 'SELECT * FROM t_par_ciudades WHERE ID_DEPARTAMENTO = "'.$_POST['ct_area'].'" AND LATITUD != "" AND LONGITUD != "" ORDER BY CIUDAD';
  $res_c = $conn->query($query);

  if ($res_c->num_rows > 0) {
      while($rw_c = $res_c->fetch_assoc()) {
        if($rw_c["ID"] == $_POST['ct_ciudad'])
          $selected = 'selected';
        else
          $selected = '';
        $opt_ciudad.= '<option value="'.$rw_c["ID"].'" '.$selected.'>'.utf8_encode($rw_c["CIUDAD"]).'</option>';
      }
  }
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
    $('#ct_area').change( function () {
      $('#form').submit();
    });

    $('#ct_ciudad').change( function () {
      $('#form').submit();
    });
  });
  </script>

  <?php
            function comillas($str){
              $str = str_replace('"', '\"', $str);
              $str = str_replace("'", "\'", $str);
              return $str;
            }

            $latitud = '-16.51238731233846';
            $longitud = '-68.11926053312459';

            if($_POST['ct_ciudad'] != ''){

              $query = 'SELECT * FROM t_par_ciudades WHERE ID = "'.$_POST['ct_ciudad'].'"';
              $res_ciu = $conn->query($query);

              $rw_ciu = $res_ciu->fetch_assoc();

                $latitud = $rw_ciu["LATITUD"];
                $longitud = $rw_ciu["LONGITUD"];

              $direcciones = '';
              $query = 'SELECT *, if(d.T_PAR_BANCOS_FK = 0, "", (SELECT entidad FROM soat_entidad WHERE id_entidad = d.T_PAR_BANCOS_FK)) AS entidad, (SELECT codigo FROM t_par_catalogo WHERE id = d.T_PAR_CATALOGO) AS codigo
              FROM t_direccion AS d
              WHERE T_PAR_CIUDADES_FK = "'.$_POST['ct_ciudad'].'" AND LATITUD != "" AND LONGITUD != ""
              AND (T_PAR_CATALOGO != 1000003 OR (T_PAR_CATALOGO = 1000003 AND EXISTS(SELECT 1 FROM soat_entidad WHERE id_entidad = d.T_PAR_BANCOS_FK AND habilitado = 1)) )
              AND T_PAR_CATALOGO != 1000002
              ORDER BY AGENCIA';
              
              

              $res_d = $conn->query($query);

              if ($res_d->num_rows > 0) {
                  while($rw_d = $res_d->fetch_assoc()) {
                    $datos_adicionales = '';
                    if($rw_d["ATENCION"] != '')
                      $datos_adicionales = '<br><strong>ATENCIÓN:</strong> '.$rw_d["ATENCION"];
                    if($rw_d["HORARIO"] != '')
                      $datos_adicionales = '<br><strong>HORARIO:</strong> '.$rw_d["HORARIO"];
                    switch($rw_d["codigo"]){
                      case 'univida':
                      $titulo = 'AGENCIA';
                      $IconBase = "http://www.univida.bo/images/puntero_amarillo.png";
                      break;
                      case 'pos':
                      $titulo = 'PUNTO DE VENTA';
                      $IconBase = "http://www.univida.bo/images/puntero_celeste.png";
                      break;
                      default:
                      $titulo = 'PUNTO DE ATENCIÓN AL CLIENTE';
                      $IconBase = "http://www.univida.bo/images/puntero_naranja.png";
                      break;
                    }
                    // ';
                    $direcciones.= 'var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location('.$rw_d["LATITUD"].', '.$rw_d["LONGITUD"].'), {icon: "'.$IconBase.'",anchor: new Microsoft.Maps.Point(15, 0)});
                    pin.metadata = {title: "'.$titulo.' - '.$rw_d["entidad"].$rw_d["AGENCIA"].'",description: "'.comillas(utf8_decode($rw_d["DIRECCION"])).comillas(utf8_decode($datos_adicionales)).'"};
                    Microsoft.Maps.Events.addHandler(pin, "click", pushpinClicked);
                    map.entities.push(pin);

                    ';
                  }
              }
            }
  ?>
  <script>
          var map, infobox;

          function GetMap() {
              map = new Microsoft.Maps.Map('#myMap', {
                center: new Microsoft.Maps.Location(<?php echo $latitud?>, <?php echo $longitud?>),
                zoom: 15,
                mapTypeId: Microsoft.Maps.MapTypeId.road
              });

              infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
                  visible: false
              });

              infobox.setMap(map);

              <?php echo $direcciones;?>
          }

          function pushpinClicked(e) {
              if (e.target.metadata) {
                  infobox.setOptions({
                      location: e.target.getLocation(),
                      title: e.target.metadata.title,
                      description: e.target.metadata.description,
                      visible: true
                  });
              }
          }
        </script>
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AqB90pqCu1zYjiqllDRgMLZ3T73VebTFupjMUu_n564ntUhDdtvIFg3n1y0Hlh-C' async defer></script>
</head>

<body>
  <div class="wrapper">

   <?php include 'skin/header.php' ?>

   <section class="contentIn">
    <div class="cntCntIn">

      <h1 class="bgLn">Puntos de venta</h1>

      <p>Adquiera su SOAT   en el punto de venta más cercano,  le mostramos nuestros puntos de venta a Nivel Nacional.</p>

      <form class="formA" action="" id="form" method="post">
        <fieldset>
          <div style="width:33%; float: left; text-align: center">
            <label class="" id="" style="width: auto; display: inline-block; float: none;">Departamento:</label>
            <select name="ct_area" id="ct_area" class="" style="width: auto; display: inline-block; float: none;">
              <option value=""></option>
              <?php echo $opciones?>
            </select>
          </div>
          <?php if($_POST['ct_area'] != ""){?>
          <div style="width:34%; float: left; text-align: center">
            <label class="" id="ciudad" style="width: auto; display: inline-block; float: none;">Ciudad:</label>
            <select name="ct_ciudad" id="ct_ciudad" class="" style="width: auto; display: inline-block; float: none;">
              <option value=""></option>
              <?php echo $opt_ciudad?>
            </select>

          </div>
          <!-- <div style="width:33%; float: right; text-align: center">
            <label class="" id="ciudad" style="width: auto; display: inline-block; float: none;">Tipo de venta:</label>
            <select name="ct_catalogo" id="ct_catalogo" class="" style="width: auto; display: inline-block; float: none;">
              <option value="">Todos</option>
              <option value="santa">Oficinas UNIVida</option>
              <option value="lapaz">Bancos</option>
              <option value="tarija">Puntos Fijos</option>
            </select>
          </div> -->
          <?php }?>
        </fieldset>
      </form>
      
      <span class="clear"></span>
      <span class="todas">
        <span class="clear"></span>
        <br>
      </span>
      <div style="width: 100%; height: 600px">
        <?php if($_POST['ct_ciudad'] != ""){?>
        <div id="myMap" style="position:relative;width:1170px;height:800px;"></div>
        <?php }?>
      </div>
      <?php

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


<?php 
} else{?>
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
  <title>Ventas | SOAT | UNIVida S.A.</title>
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

        <iframe src="<?php echo $url2?>" width="100%" height="850"></iframe>
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

<?php }