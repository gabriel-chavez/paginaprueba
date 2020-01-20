<?php
session_start();
$id=$_GET['id'];
$urli = explode("/", $id);
$url=$urli[0];


$domain = "https://" . $_SERVER['HTTP_HOST'] ."/fiso";
$urls = array(1 => "inicio", 2 => "guia-de-atencion-de-su-siniestro", 3 => "contactanos");
$titles = array(1 => "Inicio", 2 => "Guía de atención de su siniestro", 3 => "Contáctanos");
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
		$page="contacto.php";
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
		$page="contacto.php";
		break;
	}
	include	$page;
}else{
	include	'skins/sendmailExec.php';
}
