<?php
?>
<div class="container">
	<div>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh'); ?>" class="btn btn-default <?php print $view == 'default' ? 'active' : ''; ?>">
			<?php _e('Announcements', 'rrhh'); ?>
		</a>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=profile'); ?>" class="btn btn-default <?php print $view == 'profile' ? 'active' : ''; ?>">
			<?php _e('My Profile', 'rrhh'); ?>
		</a>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh&task=logout'); ?>" class="btn btn-default">
			<?php _e('Cerrar Sesi&oacute;n', 'rrhh'); ?>
		</a>
	</div><br/>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	    <li class="active"><a href="#datos_del_postulante" aria-controls="datos_del_postulante" role="tab" data-toggle="tab">Datos del Postulante</a></li>
	    <li ><a href="#formacion_academica" aria-controls="formacion_academica" role="tab" data-toggle="tab">Informacion Academica</a></li>
	    <li ><a href="#tab-cursos" data-toggle="tab">Cursos/Talleres</a></li>
	    <li ><a href="#tab-idiomas" data-toggle="tab">Idiomas</a></li>
	    <li ><a href="#tab-sistemas" data-toggle="tab">Sistemas</a></li>
	    <li ><a href="#experiencia_laboral" aria-controls="experiencia_laboral" role="tab" data-toggle="tab">Experiencia Laboral</a></li>
	    <li ><a href="#referencia_personal" aria-controls="conocimientos_requeridos" role="tab" data-toggle="tab">Referencia Personal</a></li>
	    <li ><a href="#referencia_laboral" aria-controls="referencia_laboral" role="tab" data-toggle="tab">Referencia Laboral</a></li>
	    <li ><a href="#my_cv" aria-controls="referencia_laboral" role="tab" data-toggle="tab">Mi Hoja de Vida</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content form-group-sm">
		<div class="tab-pane active" id="datos_del_postulante"><?php require_once ('tab-registro_datos.php');?></div>
		<div class="tab-pane" id="formacion_academica"><?php require_once ('tab-formacion_academica.php');?></div>
		<div class="tab-pane" id="tab-cursos"><?php require_once ('tab-cursos.php');?></div>
		<div class="tab-pane" id="tab-idiomas"><?php require_once ('tab-idiomas.php');?></div>
		<div class="tab-pane" id="tab-sistemas"><?php require_once ('tab-sistemas.php');?></div>
		<div class="tab-pane" id="experiencia_laboral"><?php require_once ('tab-experiencia_laboral.php');?></div>
		<div class="tab-pane" id="referencia_personal"><?php require_once ('tab-ref_personal.php');?></div>
		<div class="tab-pane" id="referencia_laboral"><?php require_once ('tab-referencia_laboral.php');?></div>
		<div id="my_cv" class="tab-pane">
			<h2>
				<?php _e('Hoja de Vida', 'rrhh'); ?>
				<span class="pull-right text-right">
					<?php /*
					<a href="<?php print SB_Route::_('index.php?mod=rrhh&task=profile2excel'); ?>" title="<?php _e('Download Excel'); ?>" target="_blank">
						<img src="<?php print MOD_RRHH_URL; ?>/images/excel-xls-icon.png" alt="<?php _e('Download Excel', 'rrhh'); ?>" width="48" />
					</a>
					*/ ?>
					<a href="<?php print SB_Route::_('index.php?mod=rrhh&task=profile2pdf'); ?>" title="<?php _e('Download PDF'); ?>" target="_blank">
						<img src="<?php print MOD_RRHH_URL; ?>/images/icon-pdf-96x96.png" alt="<?php _e('Download PDF', 'rrhh'); ?>" width="48" />
					</a>
				</span>
			</h2>
			<?php include 'tab-my_cv.php'; ?>
		</div>
	</div>
</div>
