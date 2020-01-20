<h4>Referencias Laborales</h4>
<div>
	<a href="#" id="btn-add-work-reference" class="btn btn-default">
		<span class="glyphicon glyphicon-plus"></span> <?php _e('Add Work Reference', 'rrhh'); ?>
	</a>
</div>
<div id="wr-messages"></div>
<table id="table-work_references" class="table table-condensed">
<thead>
<tr>
	<th><?php _e('Name', 'rrhh'); ?></th>
	<th><?php _e('Company', 'rrhh'); ?></th>
	<th><?php _e('Position', 'rrhh'); ?></th>
	<th><?php _e('Relacion Laboral', 'rrhh'); ?></th>
	<th><?php _e('Telephone', 'rrhh'); ?></th>
	<th><?php _e('Mobile Telephone', 'rrhh'); ?></th>
	<th><?php _e('Email', 'rrhh'); ?></th>
	<th></th>
</tr>
</thead>
<tbody>
<?php foreach($person->GetWorkReferences() as $ref) include 'pr-row.php'; ?>
</tbody>
</table>
<div id="modal-work-reference" class="modal fade">
	<form id="form-work-reference" action="" method="post" class="modal-dialog form-group-sm form-horizontal">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_reference" />
		<input type="hidden" name="ajax" value="1" />
		<input type="hidden" id="wr_id" name="id" value="0" />
		<input type="hidden" name="type" value="work" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Work Reference', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Full Name', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="wr_full_name" name="name" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Company', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="wr_company" name="company" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Position', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="wr_position" name="position" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Relacion Laboral', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="wr_relationship" name="relationship" value="" class="form-control requried" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Telephone', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="wr_telephone" name="telephone" value="" class="form-control required" />
				</div>
				<label class="control-label col-sm-3"><?php _e('Cell phone', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="wr_cell_phone" name="cell_phone" value="" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3"><?php _e('Email', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="wr_email" name="email" value="" class="form-control" />
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'rrhh');?></button>
        	<button type="submit" id="btn-save-wr" class="btn btn-green"><?php _e('Save', 'rrhh'); ?></button>
		</div>
	</form>
</div>
<script>
jQuery(function()
{
	jQuery('#btn-add-work-reference').click(function()
	{
		jQuery('#wr_id').val('0');
		jQuery('#wr_full_name').val('');
		jQuery('#wr_company').val('');
		jQuery('#wr_position').val('');
		jQuery('#wr_relationship').val('');
		jQuery('#wr_telephone').val('');
		jQuery('#wr_cell_phone').val('');
		jQuery('#btn-save-wr').prop('disabled', false);
		jQuery('#modal-work-reference').modal('show');
	});
	
	jQuery('#form-work-reference').submit(function()
	{
		if( this.name.value.trim().length <= 0 )
		{
			alert('Debe ingresar el nombre');
			return false;
		}
		if( this.company.value.trim().length <= 0 )
		{
			alert('Debe ingresar el nombre de la empresa');
			return false;
		}
		if( this.position.value.trim().length <= 0 )
		{
			alert('Debe ingresar el cargo');
			return false;
		}
		if( this.relationship.value.trim().length <= 0 )
		{
			alert('Debe seleccionar el parentesco');
			return false;
		}
		if( this.telephone.value.trim().length <= 0 )
		{
			alert('Debe ingresar el numero de telefono');
			return false;
		}
		var params = jQuery(this).serialize();
		jQuery('#btn-save-wr').prop('disabled', true);
		jQuery.post('index.php', params, function(res)
		{
			jQuery('#modal-work-reference').modal('hide');
			refreshReferences('work');
			if( res.status == 'ok' )
			{
				jQuery('#wr-messages').append('<div class="alert alert-success">'+
												'<button type="button" class="close" data-dismiss="alert">'+
												'<span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
			}
			else
			{
				alert(res.error);
			}
			jQuery('#btn-save-wr').prop('disabled', false);
		});
		return false;
	});
});
</script>
