<?php
/**
 * Template: Contacto
 * Fields: telephone,address,mail,latitud,longitud, api_key
 */
require("/home/univida/public_html/include/libs/PHPMailer/class.phpmailer.php");
require("/home/univida/public_html/include/libs/PHPMailer/class.smtp.php");

if( SB_Request::getString('send_form') )
{
	$email 		= $article->_mail;
	$name 		= SB_Request::getString('fullname');
	$cemail 	= SB_Request::getString('email');
	$message 	= SB_Request::getString('message');
	$body 		= "Nombre: $name<br/>".
					"Email: $cemail<br/>".
					"Mensaje:<br/>$message<br/><br/><br/>".
					sprintf("%s", SITE_TITLE);

	//$email = $email.",".$cemail;
 			
	$headers = array(
			'Content-type:text/html',
			sprintf("From: %s <info@univida.bo>", SITE_TITLE),
			"Reply-To: $cemail"
	);

	/**$maila = new PHPMAiler();
	$maila -> IsSMTP();
	$maila -> SMTPAuth = true;
	$maila -> AuthType = 'LOGIN';
	$maila -> SMTPSecure = "ssl";
	$maila -> Host = "mail.univida.bo";
	$maila -> Port = 587;
	// cuenta enviador
	$maila -> Username = 'info@univida.bo';
	$maila -> Password = 'info123$#';
	// agregar cuenta de donde se envia
	//$maila -> SetFrom("info@univida.bo");
        $maila -> From = "info@univida.bo";
        $maila -> FromName = "info@univida.bo";

	$maila -> AddReplyTo("info@univida.bo");
	//$maila -> isHTML(true);
	// agregar cuenta destinatario
	$maila -> AddAddress("info@univida.bo");
	$maila -> Subject = "SOLICITUD DE INFORMACION";
	$maila -> Body = $message;
	if ($maila -> send())
   	{
		SB_MessagesStack::AddMessage(__('Su mensaje fue enviado correctamente, le responderemos oportunamente. Gracias.'),'success');
	}
	else
	{
		SB_MessagesStack::AddMessage(__('Existe algun error en el envio de sus mensaje, espere e intente nuevamente. Gracias'.$maila->ErrorInfo),'success');
	}*/
	


	lt_mail($email, 'Formulario de Contacto - ' . SITE_TITLE, $body, $headers);
	//mail($email, 'Formulario de Contacto - ' . SITE_TITLE, $body, implode("\r\n", $headers));
	SB_MessagesStack::AddMessage(__('Su mensaje fue enviado correctamente, le responderemos dentro del plazo de 24 horas.'), 'success');
}
sb_add_script(TEMPLATE_URL . '/js/gmap3.min.js', 'gmap3');
lt_get_header();
?>
<script type="text/javascript" src="//maps.google.com/maps/api/js?language=es&key=<?php print $article->_api_key; ?>"></script>
<script>
var map_location = {lat:<?php print $article->_latitud;?>,lng:<?php print $article->_longitud; ?>,address: '<?php print $article->_address; ?>'};
</script>
<style>
h3 span {
    height: auto;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12 centered">
			
			<h3><span>Puntos de atención al cliente</span></h3>
			
		</div>
	</div>
	<div class="row vdivide">
		<div class="col-md-4">
			<div class="bloque">
				<b class="colorTitulo">OFICINA NACIONAL</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Camacho, esquina Calle Bueno, Edificio La Urbana, piso 3, N° 1485, Zona Central.<br>
				<span class="colorSubTitulo">Teléfono: </span>2151000 <br>			
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL LA PAZ</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Camacho N° 1415-1425, Edificio Crispieri Nardin, Planta Baja y Primer Piso, Zona Central.<br>
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 77727369<br>			
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA EL ALTO</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Panorámica, S/N, Eficicio Teleférico Rojo, Piso 1, Local LC2  y LC3, Zona 16 de Julio.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 77724801<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL COCHABAMBA</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Tupiza N°1174, Zona Queru Queru.<br>
				<span class="colorSubTitulo">Teléfono: </span>4114444 – 4114445 - 78898896<br>			
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA CHIMORE </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Los Pinos Distrito 01, Lote 2 Manzano 01, Plaza Principal.<br>	
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69415082<br>					
			</div>
			<div class="bloque">
				<b class="colorTitulo">AGENCIA SACABA</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Comercio Nº S/N, entre Calles Granado y Padilla, Zona Central.<br>					
				<span class="colorSubTitulo">Teléfono: </span>4114444 - 69415081<br>	
			</div>
		</div>
		<div class="col-md-4">
		
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA QUILLACOLLO </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Albina Patiño N°520, Km 14,5 Esquina Pasaje Los Pinos, Edificio Centro Comercial Guadalupe II, Planta Baja,  Zona Oeste. <br>
				<span class="colorSubTitulo">Teléfono: </span>4114444 - 69415079<br>	
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL SANTA CRUZ</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Libertad, Nº153, Zona Casco Viejo.<br>	
				<span class="colorSubTitulo">Teléfono: </span>3144444 – 78898893<br>							
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA SANTA CRUZ</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Villamontes y Tercer Anillo Interno, S/N, a media cuadra de la Calle Santos Dumont, Zona Sud Oeste.<br>									
				<span class="colorSubTitulo">Teléfono: </span>78898893<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA MONTERO</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle 1ro de Mayo, Edificio Parqueo Central, Planta Baja, S/N, entre calles Sucre y Ayacucho, Barrio Centro Historico.<br>				
				<span class="colorSubTitulo">Teléfono: </span>3144444 - 77020356<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL ORURO </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Adolfo Mier N°369 entre Calles Pagador y Potosí, Zona Central.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 77141136<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL POTOSÍ</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Bolívar S/N, entre Calles Ustarez y Pizarro, Planta Baja, Zona San Martín.<br>
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69607481<br>			
			</div>
		</div>
		<div class="col-md-4">
		
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL CHUQUISACA</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Loa N°682, Esquina Calle Ayacucho, Zona Central.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69670159<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL TARIJA</b> <br>
				<span class="colorSubTitulo">Dirección: </span>Zona La Pampa Calle Ingavi N°E-156 entre calle Colón y Suipacha Edificio Coronado Planta Baja.<br>				
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 6115139<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA YACUIBA  </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Juan XXIII, N° 431, Planta Baja, entre Calles Ballivián y Santa Cruz, Zona Sur Oeste.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69340407<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL TRINIDAD  </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Melitón Villavicencio, esquina Avenida del Mar frente a la Plazuela del Benemérito (o Plazuela Rosada), Zona San Vicente.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69656817<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">AGENCIA RIBERALTA  </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Avenida Medardo Chávez N° 677, entre Avenida Bernardino Ochoa y Calle Dr. Martínez, Edificio Tokio, Planta Baja, Zona Central.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 69656857<br>
			</div>
			<div  class="bloque">
				<b class="colorTitulo">SUCURSAL PANDO  </b> <br>
				<span class="colorSubTitulo">Dirección: </span>Calle Beni N°56, entre Av. Tcnl. Emilio Fernández Molina y Avenida 9 de Febrero, Zona Central.<br>					
				<span class="colorSubTitulo">Teléfono: </span>2151000 - 76103659
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12 centered">
			<?php SB_MessagesStack::ShowMessages(); ?>
			<h3><span><?php print $article->title; ?></span></h3>
			<div><?php print stripslashes($article->TheContent()); ?></div>
		</div>
	</div>
</div>
<div class="container">
	<!-- <div id="map" data-stellar-background-ratio=".3"></div>  -->
</div>

<div class="container content">
	<div class="row">
		<div class="col-md-8">
			<form role="form" id="contact_form" action="<?php print $article->link ?>" method="post">
				<input type="hidden" name="send_form" value="1" />
				<div class="form-group">
					<label for="InputName"><?php _e('Your name', 'uv'); ?></label>
					<input type="text" class="form-control" id="fullname" name="fullname" placeholder="<?php _e('Your name', 'uv'); ?>">
				</div>
				<div class="form-group">
					<label for="InputEmail"><?php _e('Your email', 'uv'); ?></label>
					<input type="email" class="form-control" id="email" name="email" placeholder="<?php _e('Your email', 'uv'); ?>">
				</div>
				<div class="form-group">
					<label for="InputMesaagel"><?php _e('Your messsage', 'uv'); ?></label>
					<textarea class="form-control" id="message" name="message" placeholder="<?php _e('Your message', 'uv'); ?>" rows="8"></textarea>
				</div>
				<button type="submit" class="btn btn-default btn-green"><?php _e('Send message', 'uv'); ?></button>
			</form>
			<script>
			jQuery('#contact_form').submit(function()
			{
				if( this.fullname.value.trim().length <= 0 )
				{
					alert('Debe ingresar su nombre');
					this.fullname.focus();
					return false;
				}
				if( this.email.value.trim().length <= 0 )
				{
					alert('Debe ingresar su email');
					this.email.focus();
					return false;
				}
				if( this.message.value.trim().length <= 0 )
				{
					alert('Debe ingresar un mensaje');
					this.message.focus();
					return false;
				}
				return true;
			});
			</script>
		</div>
		<div class="col-md-4">
			<ul class="contact-info">
				<li class="telephone">
					<?php print $article->_telephone; ?>
				</li>
				<li class="address">
					<?php print $article->_address; ?>
				</li>
				<li class="mail">
					<?php print $article->_mail; ?>
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
	</div>

	
</div>
<?php lt_get_footer(); ?>
