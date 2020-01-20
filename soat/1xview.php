<?php
session_start();
$id=$_GET['id'];
$urli = explode("/", $id);
$url=$urli[0];


$domain = "http://" . $_SERVER['HTTP_HOST'] ."/soat";

$urls = array(1 => "inicio", 2 => "guia-de-atencion-de-su-siniestro", 3=>"precios-2017", 4=> "puntos-de-venta", 5=> "formulario-soat", 6 => "consulta-para-verificación-de-vigencia-de-soat", 7 => "puntos-de-venta?p=1", 8 => "contactanos");
$titles = array(1 => "Inicio", 2 => "Guía de atención de su siniestro", 3=>"Precios SOAT", 4=> "Puntos de Venta", 5=> "Comprobante SOAT", 6 => "Verificar de vigencia de SOAT", 7 => "Compra tu SOAT", 8 => "Contáctanos");

/*$urls = array(1 => "inicio", 2 => "guia-de-atencion-de-su-siniestro", 3=>"precios-2017", 4=> "puntos-de-venta", 5=> "formulario-soat", 6 => "consulta-para-verificación-de-vigencia-de-soat", 7 => "contactanos");
$titles = array(1 => "Inicio", 2 => "Guía de atención de su siniestro", 3=>"Precios SOAT", 4=> "Puntos de Venta", 5=> "Comprobante SOAT", 6 => "Verificar de vigencia de SOAT", 7 => "Contáctanos");*/

// if($url=='exec'){
// 	// include 'exec/sendmailExec.php';
// 	$url='contactanos';
// 	header('Location:'.$domain.'/contactanos');
// }
if($url!='exec'){
	if(isset($urli[1]) && $urli[1]!=""){
	header("Location: ../");
}
	$u_id = array_search($url, $urls);

	if ($url=="") {
		$u_id = 1;
	}

	switch ($u_id) {
		case 1:
		$page="inicio.php";
		break;
		case 2:
		$page="guia.php";
		break;
		case 3:
		$page="precios.php";
		break;
		case 4:
		$page="puntos.php";
		break;
		case 5:
		$page="certificado.php";
		break;
		case 6:
		$page="consulta.php";
		break;
		case 7:
		$page="ventas.php";
		break;
		case 8:
		$page="contacto.php";
		break;
		
	}
	include	$page;
}else{
	include	'skins/sendmailExec.php';
}
