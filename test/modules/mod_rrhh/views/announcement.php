<?php
?>
<div class="container">
	<div class="row">
		<div class="col-md-12 centered">
			<h3><span><?php print $title; ?></span></h3>
		</div>
	</div>
</div>
<div id="announcement-container" class="container">
	<div class="row">
		<div class="col-xs-12 col-md-9">
			<div id="announcement-content"><?php print $obj->description; ?></div>
		</div>
		<div class="col-xs-12 col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><?php _e('Information', 'rrhh'); ?></h3></div>
				<div class="panel-body">
					<table>
					<tr>
						<td><b><?php _e('Limit Date:', 'rrhh'); ?></b></td><td><?php print sb_format_date($obj->end_date);?></td>
					</tr>
					<tr>
						<td><b><?php _e('Vacancies:', 'rrhh'); ?></b></td><td><?php print $obj->vacancies; ?></td>
					</tr>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><?php _e('Actions', 'rrhh'); ?></h3></div>
				<div class="panel-body">
					<a href="<?php print SB_Route::_('index.php?mod=rrhh'); ?>" class="btn btn-default"><?php _e('Back', 'rrhh'); ?></a>
					<?php if( $obj->status == 'active' ): ?>
					<a href="#" id="btn-apply-now" class="btn btn-default btn-success"><?php _e('Apply Now', 'rrhh'); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- end id="announcement-container" -->
<script>
jQuery(function()
{
	jQuery('#btn-apply-now').click(function(e)
	{
		jQuery('#modal-apply-now').modal('show');
		return false;
	});
	jQuery('.experience-row').click(function()
	{
		var cb = jQuery(this).find('input[type=checkbox]:first');
		cb.prop('checked', !cb.is(':checked'));
	});
});
</script>
<style>
.experience-row:nth-of-type(odd){background-color: #f9f9f9;}
.experience-row:hover{cursor:pointer;}
</style>
<div id="modal-apply-now" class="modal fade">
	<form action="" method="post" class="modal-dialog form-horizontal">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="apply" />
		<input type="hidden" name="id" value="<?php print $obj->id; ?>" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Apply to Announcement', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label col-sm-3"><?php _e('Code', 'rrhh'); ?></label>
				<div class="col-sm-3"><p class="form-control-static"><?php print $obj->code; ?></p></div>
				<label class="control-label col-sm-2"><?php _e('Announcement', 'rrhh'); ?></label>
				<div class="col-sm-4"><p class="form-control-static"><?php print $obj->name; ?></p></div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-12" style="text-align:left;"><?php _e('Specific Experience', 'rrhh'); ?></label>
				<div class="col-sm-12">
					<div style="padding:0 14px;">
						<div class="row">
							<div class="col-sm-1 text-center"><b><?php _e('General', 'rrhh'); ?></b></div>
							<div class="col-sm-1 text-center"><b><?php _e('Specific', 'rrhh'); ?></b></div>
							<div class="col-sm-4 text-center"><b><?php _e('Company', 'rrhh'); ?></b></div>
							<div class="col-sm-5 text-center"><b><?php _e('Position', 'rrhh'); ?></b></div>
						</div>
					</div>
					<div style="width:100%;height:180px;overflow:auto;border:1px solid #dedede;padding:0 14px;">
						<?php foreach($person->GetWorkExperience() as $exp): ?>
						<div class="row experience-row">
							<div class="col-sm-1 text-center">
								<input type="checkbox" name="specific_experience[]" value="<?php print $exp->id; ?>" />
							</div>
							<div class="col-sm-1 text-center">
								<input type="checkbox" name="specific_experience[]" value="<?php print $exp->id; ?>" />
							</div>
							<div class="col-sm-4 text-center"><?php print $exp->company; ?></div>
							<div class="col-sm-5 text-center"><?php print $exp->position; ?></div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="label-control col-sm-3"><?php _e('Salary Pretension', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="salary_pretension" value="" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3"><?php _e('Inmediate availability', 'rrhh'); ?></label>
				<label class="control-label col-sm-2"><input type="radio" name="inmediate_availability" value="yes" /><?php _e('Yes', 'rrhh'); ?></label>
				<label class="control-label col-sm-2"><input type="radio" name="inmediate_availability" value="no" /><?php _e('No', 'rrhh'); ?></label>
				<label class="control-label col-sm-2"><?php _e('Days', 'rrhh'); ?></label>
				<div class="col-sm-3"><input type="number" min="1" name="days" value="1" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-12" style="text-align:left;">
					<input type="checkbox" name="i_agree" value="1" />
					TODA LA INFORMACIÓN DECLARADA  ES VERDADERA Y  ESTOY EN CONDICIONES DE SUSTENTARLA A REQUERIMIENTO DE LA INSTITUCION. 
					EL FORMULARIO ES UNA DECLARACIÓN JURADA, SEGUROS Y REASEGUROS UNIVIDA SA. SE RESERVA EL DERECHO DE LA VERIFICACIÓN DE LA 
					INFORMACIÓN QUE CONTIENE.
				</label>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?php _e('Close', 'rrhh');?></button>
        	<button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span> <?php _e('Apply', 'rrhh'); ?></button>
		</div>
	</form>
</div>