<?php
$pag_view = "";
if(isset($_GET["view"]))
	$pag_view = $_GET["view"];

$pag_mod = "";
if(isset($_GET["mod"]))
	$pag_mod = $_GET["mod"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msvalidate.01" content="C93E53DE1C54A948BE2182B1D62396E5" />
	<meta name="description" content="UNIVida: Seguro de Accidentes Personales, Seguro de Vida, Seguro de Desgravamen, Seguro de Cesantía, SOAT, FISO."/>
	<meta name="keywords" content="UNIVida,Seguro de Accidentes Personales,Seguro de Vida,Seguro de Desgravamen,Seguro de Cesantía,SOAT,FISO,soat 2018"/>
	<link rel="icon" type="image/jpeg" href="<?php print TEMPLATE_URL; ?>/favicon.jpg">
	<?php switch($pag_view){
		case "authlogin":?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Formulario de acceso</title>;
		<?php break;
		case "authregister":?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Formulario de registro</title>;
		<?php break;
		case "login":
			if($pag_mod == "users"){
		?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Autenticación usuario</title>;
		<?php 
			}else{?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Autenticación</title>;
		<?php }
		break;
		case "recover_pwd":
			if($pag_mod == "users"){
		?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Recuperación de contraseña usuario</title>;
		<?php 
			}else{?>
			<title>SEGUROS Y  REASEGUROS PERSONALES UNIVida S.A. | Recuperación de contraseña</title>;
		<?php }
		break;
		default:?>
			<title><?php lt_title(); ?></title>
		<?php break;
	}?>
	<!-- <title><?php lt_title(); ?></title> -->
	<link href="<?php print BASEURL; ?>/js/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php print TEMPLATE_URL; ?>/css/style.css" rel="stylesheet">
	<link href="<?php print TEMPLATE_URL; ?>/style.css?var=<?php print rand();?>" rel="stylesheet">
	<link href="<?php print BASEURL; ?>/css/validationEngine.jquery.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Cabin:400,500,600,700,400italic,500italic,600italic,700italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!--[if IE 8]><link rel="stylesheet" type="text/css" href="css/ie8.css" /><![endif]-->
	<script src="<?php print BASEURL; ?>/js/jquery.min.js"></script>
	<script src="<?php print BASEURL; ?>/js/bootstrap-3.3.5/js/bootstrap.min.js"></script>
	<?php lt_head(); ?>
	<script language="JavaScript">
	    function updateAuthor(theForm){
	    if(theForm.extensionField_Name){
	    if(theForm.extensionField_Name.value!=""){
	    theForm.author.value=theForm.extensionField_Name.value;
	    theForm.extensionField_Name.name="extensionField_h_Name";
	    return(true);}}
	    if(theForm.extensionField_Email){
	    if(theForm.extensionField_Email.value!=""){
	    theForm.author.value=theForm.extensionField_Email.value;
	    return(true);}}
	    return(true);}
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
<body <?php print lt_body_class(lt_is_frontpage() ? 'homepage' : 'contentpage'); ?>>
	<div id="VentanaChat" style="position: fixed; bottom: 0; z-index: 100000 !important; width: 100%">
		<div class="container">
			<div class="row" style="height: :1px; overflow: show;">
				<div class="col-md-4 col-md-offset-8" style="background: #fff; margin-bottom: 30px; display: none" id="Chat">
					<!--<form action="https://192.168.18.103/ccp/chat/form/100000" class="form-horizontal" method="post" onsubmit="return updateAuthor(this)">-->
					<!-- <form action="https://webchat.univida.bo:9443/ccp/chat/form/100000" class="form-horizontal" method="post" onsubmit="return updateAuthor(this)"> -->
					<form action="https://webchat.univida.bo:9443/ccp/chat/form/100000" class="form-horizontal" id="FormChat" method="post" onsubmit="return updateAuthor(this)">
						<div class="form-group" style="margin-top: 10px">
							<h3 class="col-md-12">
								Escríbenos
								<small class="pull-right" id="Cerrar" style="cursor: pointer;">Cerrar</small>
							</h3>
						</div>
						<div class="form-group">
		                    <label class="control-label col-md-3" >Nombre:</label>
		                    <div class="col-md-9">
		                    	<input type="text" class="form-control validate[required]" name="extensionField_Nombre" />
		                    </div>
		                </div>
		                <div class="form-group">
		                	<label class="control-label col-md-3">Correo-e:</label>
		                	<div class="col-md-9">
		                		<input type="text" class="form-control validate[custom[email]]" name="extensionField_Correo" />
		                	</div>
		                </div>
		                <div class="form-group">
		                	<label class="control-label col-md-3">Teléfono:</label>
		                	<div class="col-md-9">
		                		<input type="text" class="form-control validate[required]" name="extensionField_Telefono" />
		                	</div>
		                </div>
		                <div class="form-group">
		                	<label class="control-label col-md-3">Ciudad:</label>
		                	<div class="col-md-9">
		                		<input type="text" class="form-control" name="extensionField_Ciudad" />
		                	</div>
		                </div>
		                <div class="form-group">
		                	<label class="control-label col-md-3">Detalle:</label>
		                	<div class="col-md-9">
		                		<input type="text" class="form-control" name="extensionField_Detalle" />
		                	</div>
		                </div>
		                <div class="form-group">
		                	<label class="control-label col-md-3">Problema:</label>
		                	<div class="col-md-9">
		                		<select name="extensionField_ccxqueuetag" class="form-control">
							        <option value="Chat_Csq7">SOAT</option>
							        <option value="Chat_Csq7">FISO</option>
							        <option value="Chat_Csq7">Seguros Personales</option>
							    </select>
		                	</div>
		                </div>
		                <div class="form-group">
		                	<div class="col-md-12">
		                		<input type="submit" class="btn btn-default btn-green btn-block" value="Enviar mensaje"/>
		                		<!-- <input type="hidden" name="author" value="Customer"/> -->
		                		<input type="hidden" name="author" value="Customer"/>
								<input type="hidden" name="title" value="ccx chat"/>
								<input type="hidden" name="extensionField_h_widgetName" value="WebChat1"/>
								<input type="hidden" name="extensionField_contextServiceCustomFieldSets" value="">
								<input type="hidden" name="extensionField_chatLogo" value="http://www.univida.bo/templates/univida/images/logo-univida.png">
								<input type="hidden" name="extensionField_chatWaiting" value="Bienvenido, en breve lo atenderá un agente.">
								<input type="hidden" name="extensionField_chatAgentJoinTimeOut" value="Los agentes se encuentran ocupados, por favor intente nuevamente.">
								<input type="hidden" name="extensionField_chatError" value="Lo sentimos, el servicio de chat no esta disponible.">
		                	</div>
		                </div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="VentanaChatBoton" style="position: fixed; bottom: 0; z-index: 100000 !important; width: 100%">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-8">
					<a id="AbreChat" class="btn btn-default btn-block">Escríbenos</a>
				</div>
			</div>
		</div>	
	</div>

	<!-- Navigation -->
	<div class="navbar navbar-default navbar-fixed-top affix" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<h1>
					<a href="<?php print SB_Route::_('index.php')?>">
						<img src="<?php print TEMPLATE_URL; ?>/images/logo-univida.png" alt="" class="img-responsive" />
					</a>
				</h1>
			</div>	
			<div class="navbar-collapse collapse">
				<!--<ul class="nav navbar-nav pull-right">
					<li>
						<?php if( !sb_is_user_logged_in() ): ?>
						<a href="<?php print SB_Route::_('index.php?mod=users&view=login'); ?>">
							<span data-hover="<?php _e('Ingreso', 'uv'); ?>"><?php _e('Ingreso', 'uv'); ?></span>
						</a>
						<?php else: ?>
						<a href="<?php print SB_Route::_('index.php?mod=users&task=logout'); ?>">
							<span data-hover="<?php _e('Cerrar sesion', 'uv'); ?>"><?php _e('Cerrar sesion', 'uv'); ?></span>
						</a>
						<?php endif; ?>
					</li>
				</ul>-->
				<?php lt_show_content_menu('navegacion_'.LANGUAGE, array('class' => 'nav navbar-nav', 'sub_menu_class' => 'dropdown-menu')); ?>
			</div>
		</div>
	</div>
	<!-- Navigation end -->
