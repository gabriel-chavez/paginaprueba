<?php
try {
  $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );

  $context = stream_context_create($opts);

  //$wsdlUrl = 'http://181.188.175.133:9801/Modulos/Seguridad/wsSeguridad.svc?wsdl';
  $wsdlUrl = 'http://192.168.10.78:10010/Modulos/Ventas/wsVentas.svc?wsdl';

  $soapClientOptions = array(
      'stream_context' => $context,
      'cache_wsdl' => WSDL_CACHE_NONE
  );

  $Ventas = new SoapClient($wsdlUrl, $soapClientOptions);

  $FactAutorizacionNumero = -1;
  $FactNumero = -1;
  $SoatNroComprobante = substr($_GET["p"], 0, 7);
  $SoatVentaCajero = '';
  $SeguridadToken = 23470015;
  $SoatTParGestionFk = -1;
  $SoatTParVentaCanalFk = 1;
  $SoatVentaVendedor = '';
  $VehiPlaca = '';
  $soatTIntermediarioFk = 0;
  $Usuario = 'UNIVida';

  $param = array("FactAutorizacionNumero" => $FactAutorizacionNumero, "FactNumero" => $FactNumero,"SoatNroComprobante" => $SoatNroComprobante, "SoatVentaCajero" => $SoatVentaCajero, "SeguridadToken" => $SeguridadToken, "SoatTParGestionFk" => $SoatTParGestionFk, "SoatTParVentaCanalFk" => $SoatTParVentaCanalFk, "SoatVentaVendedor" => $SoatVentaVendedor, "VehiPlaca" => $VehiPlaca, "soatTIntermediarioFk" => $soatTIntermediarioFk, "Usuario" => $Usuario);

  $Resultado = $Ventas->Ven05Obtener(array('oEVen05Obtener' => $param));

  if($Resultado->Ven05ObtenerResult->Exito)
  {

    $fecha_ini = explode('-', $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->SoatFechaCoberturaInicio); 
    $fecha_fin = explode('-', $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->SoatFechaCoberturaFin);
$domain = 'https://www.univida.bo';
    ?>




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
            <h1>Datos del Vehículo<br/><br/></h1>
            <div class="row">
              <div class="col-md-4"><strong>Placa:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->VehiPlaca; ?></div>
              <div class="col-md-4"><strong>Marca:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->VehiMarca; ?></div>
              <div class="col-md-4"><strong>Modelo:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->VehiModelo; ?></div>
            </div>
            <div class="row">
              <div class="col-md-4"><strong>Año:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->VehiAnio; ?></div>
            </div>
          </div>
          <div class="cntServ">
            <h1>Datos del SOAT<br/><br/></h1>
            <div class="row">
              <div class="col-md-4"><strong>Tipo de Vehículo:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->SoatTParVehiculoTipoDescripcion; ?></div>
              <div class="col-md-4"><strong>Tipo de Uso:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->SoatTParVehiculoUsoDescripcion; ?></div>
              <div class="col-md-4"><strong>Gestión de SOAT:</strong> <?php echo $Resultado->Ven05ObtenerResult->oSoatDatosCompletosFactura->SoatTParGestionFk; ?></div>
            </div>
            <div class="row">
              <div class="col-md-4"><strong>Fecha inicio de cobertura:</strong> <?php echo substr($fecha_ini[2], 0, 2).'/'.$fecha_ini[1].'/'.$fecha_ini[0]; ?></div>
              <div class="col-md-4"><strong>Fecha fin de cobertura:</strong> <?php echo substr($fecha_fin[2], 0, 2).'/'.$fecha_fin[1].'/'.$fecha_fin[0]; ?></div>
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




<?php
  }
  else
  {  ?>


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
            <h1>No se pudo encontrar la información</h1>
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

  //var_dump($cliente->__getFunctions());

} catch (Exception $e) {
    trigger_error($e->getMessage(), E_USER_WARNING);
}


?>


