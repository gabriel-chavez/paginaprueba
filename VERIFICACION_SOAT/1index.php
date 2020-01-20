<?php
try {
  $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );

  $context = stream_context_create($opts);

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
  <title>Puntos de venta | SOAT | UNIVida S.A.</title>
  <link rel="shortcut icon" href="https://www.univida.bo/soat/lib/favicon.ico" />
  <link rel="stylesheet" href="https://www.univida.bo/soat/css/style.css">

  <script src="https://www.univida.bo/soat/js/jquery.min.js"></script>
  <script src="https://www.univida.bo/soat/js/jquery.flexslider.js"></script>
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

    <link rel="stylesheet" type="text/css" href="css/shadowbox.css">
 <header>        
    <div class="cntHd">

       <a href="https://www.univida.bo/soat" class="logo">UNIVIDA</a>
</div>
</header>
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

    ﻿ <style>
	.divHorarios{
		
		color: #1D488D;
		background-color: #E2E2E2;
		padding: 7px;
		text-align: center;
		font-weight: 700;
		letter-spacing: 1px;
		font-size: 16px;
        font-family: 'Lato', sans-serif;
	}
	.purchase
	{
		margin-top:0px;
	}
	</style>
	<!-- <div class="divHorarios">
		<div class="">
			<div class="row">
            Horarios de atención de lunes a viernes en todas nuestras Sucursales, Agencias y Oficina Nacional: 8:30 a 12:30 - 14:30 a 18:30				
			</div>
		</div>
	</div> -->
<section class="content">
        <div class="contentCnt">
            
            <p>
                <small>Líneas Gratuitas: UNIVida: 800-10-9119 | SOAT: 800-10-8444</small>
                </p>
                <p>"Atendemos las 24 horas, los 7 días de la semana."</p>
        
        </div>
        </section>
        
        <section class="inf">
        <div class="cntInf">
            <p>
                <b>Nuestra Calificación de Riesgo</b>
                <span class="txtB">AA</span><span class="txtM">3</span>
                <span class="small">Otorgada por Moody's LA</span>
            </p>        
        	<ul>
                <li><b>Páginas</b></li>
                <li><a href="https://www.univida.bo/index.php">Inicio</a></li>
                <li><a href="https://www.univida.bo/index.php?mod=content&view=article&id=1">Empresa</a></li>
                <li><a href="https://www.univida.bo/index.php?mod=content&view=article&id=6">Servicios</a></li>
                <li><a href="https://www.univida.bo/index.php?mod=content&view=article&id=5">Preguntas Frecuentes</a></li>
                <li><a href="https://www.univida.bo/index.php?mod=content&view=article&id=4">Contacto</a></li>
            </ul>
            <p class="pAL">
                <b>contáctanos</b>
                Av. Camacho, esquina Calle Bueno, N° 1485<br> Edificio La Urbana, piso 3.                <br>
                <br>
                <span class="color2">Email:</span> <a href="mailto:info@univida.bo" class="lnk2">atencionalcliente@univida.bo</a><br>
                <span class="color2">(591-2) 2151000 </span>
            </p>
            <span class="clear"></span>

            <span class="bxLgl"><img src="https://www.univida.bo/lib/logo_aps.jpg" alt="APS"><span>Este operador esta bajo la fiscalización y control de la Autoridad de Fiscalización y Control de Pensiones y Seguros -APS</span></span>
        </div>
        </section>
        
        <footer>
        <div>        
            <p>SEGUROS Y REASEGUROS PERSONALES UNIVida S.A.</p>
        </div>
        </footer>

<script type="text/javascript" src="../soat/js/shadowbox.js"></script>
  </div>

  <script src="https://www.univida.bo/soat/js/jquery.pageslide.min.js"></script>
  <script>
  $(".open").pageslide();
  </script>

</body>
</html>
