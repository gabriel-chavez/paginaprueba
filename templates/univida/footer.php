<?php
$about_us = LT_HelperContent::GetPageBySlug('acerca-de-nosotros');
?>
<style>
	.divHorarios{
		margin-top: 30px;
		color: #1D488D;
		background-color: #E2E2E2;
		padding: 7px;
		text-align: center;
		font-weight: 700;
		letter-spacing: 1px;
		font-size: 16px;
	}
	.purchase
	{
		margin-top:0px;
	}
	</style>
	<div class="divHorarios">
		<div class="container content">
			<div class="row">
				Horarios de atención de lunes a viernes en todas nuestras Sucursales, Agencias y Oficina Nacional: 8:30 a 12:30 - 14:30 a 18:30			
			</div>
		</div>
	</div>
	<div class="purchase">
		<div class="container content">
			<div class="row">
				<p><small>Líneas gratuitas: &nbsp; UNIVida: 800-10-9119  &nbsp;|  &nbsp;SOAT: 800-10-8444  &nbsp;|  &nbsp;FISO: 800-10-8999</small></p>
				<p><small>"Atendemos las 24 horas, los 7 días de la semana."</small></p>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h6>Nuestra <span style="font-weight:bold;">Calificaci&oacute;n de Riesgo</span></h6>
					<div style="text-align:center;width:62%;">
						<p style="font-weight:bold;font-size:30px;">AA<span style="font-size:18px;">3</span></p>
						<p >Otorgada por <span style="font-weight:bold;">Moody's LA</span></p>
					</div>
				</div>
				<?php /*
				<div class="col-md-4 blog">
					<h6>Este operador esta bajo la fiscalización y control de la Autoridad de Fiscalización y Control de Pensiones y Seguros -APS</h6>
					<img src="<?php print TEMPLATE_URL; ?>/images/logo-aps.jpg" alt="" style="max-width:100%;" />
				</div>
				*/?>
				<div class="col-md-4">
					<h6><?php _e('P&aacute;ginas', 'uv'); ?></h6>
					<?php if( !lt_show_content_menu('menu_pie_'.LANGUAGE) ): ?>
					<ul>
						<li><a href="index.php" title="">Inicio</a></li>
						<li>
							<a href="<?php $page = LT_HelperContent::GetPageBySlug('acerca-de-nosotros');print $page->link; ?>" title="">Empresa</a>
						</li>
						<li><a href="#" title="">Servicios</a></li>
						<li><a href="#" title="">Preguntas Frecuentes</a></li>
						<li><a href="#" title="">Contacto</a></li>
					</ul>
					<?php endif; ?>
				</div>
				<div class="col-md-4 contact-info">
					<h6><?php _e('Contacto', 'uv'); ?></h6>
					<p>Av. Camacho, Edificio la Urbana N° 1485. Piso 3, <br>Ciudad de La Paz.</p>
					<?php /*
					<p class="social">
						<a href="#" class="facebook"></a> <a href="#" class="pinterest"></a> <a href="#" class="twitter"></a>
					</p>
					*/?>
					<p class="c-details">
						<span>Email:</span> <a href="mailto:atencionalcliente@univida.bo" title="">atencionalcliente@univida.bo</a><br >
						<span>Telf:</span> +591-2-2151000
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
                	<span class="bxLgl"><img src="lib/logo_aps.jpg" alt="APS"><span>Este operador esta bajo la fiscalización y control de la Autoridad de Fiscalización y Control de Pensiones y Seguros -APS</span></span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 copyright">
					<p class="pull-left">&copy; <a href="http://sinticbolivia.net" target="_blank">Sintic Bolivia</a> <?php print date('Y')?>. Todos los derechos reservados.</p>
					<p class="pull-right"><a href="<?php print SB_Route::_('index.php'); ?>" title="Univida Template"><?php print SITE_TITLE; ?></a></p>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer end -->	
	<!-- Javascript plugins -->
	<script src="<?php print TEMPLATE_URL; ?>/js/carouFredSel.js"></script>
	<script src="<?php print TEMPLATE_URL; ?>/js/jquery.stellar.min.js"></script>
	<script src="<?php print TEMPLATE_URL; ?>/js/ekkoLightbox.js"></script>
	<script src="<?php print TEMPLATE_URL; ?>/js/custom.js"></script>
	<script src="<?php print BASEURL; ?>/js/jquery.validationEngine.js"></script>
	<script src="<?php print BASEURL; ?>/js/languages/jquery.validationEngine-es.js"></script>
	<script type="text/javascript">
		$(function () {
			$('#AbreChat').click(function () {
		        $('#VentanaChat div div div').fadeIn();
		    })
		    $('#Cerrar').click(function () {
		        $('#VentanaChat div div div').fadeOut();
		    })
		    
		})
		
		$(document).ready(function(){
		   $("#FormChat").validationEngine();
		})
	</script>
</body>
</html>