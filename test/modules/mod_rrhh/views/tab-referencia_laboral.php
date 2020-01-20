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
	<th><?php _e('Relationship', 'rrhh'); ?></th>
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
		<input type="hidden" id="pr_id" name="id" value="0" />
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
				<label class="control-label col-sm-3 required"><?php _e('Relationship', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<select class="form-control" id="wr_relationship" name="relationship">
						<option value="">-- opcion --</option>
						<optgroup label="FAMILIAR">
							<option value="ABUELO">ABUELO</option>
							<option value="BISABUELOS">BISABUELOS</option>
							<option value="BIZNIETOS">BIZNIETOS</option>
							<option value="CU&Ntilde;ADO">CU&Ntilde;ADO</option>
							<option value="CONYUGUE">CONYUGUE</option>
							<option value="HERMANOS">HERMANOS</option>
							<option value="HIJOS">HIJOS</option>
							<option value="NIETOS">NIETOS</option>
							<option value="YERNO-NUERA">YERNO-NUERA</option>
							<option value="PADRES">PADRES</option>
							<option value="PRIMOS">PRIMOS</option>
							<option value="SOBRINOS">SOBRINOS</option>
							<option value="SUEGROS">SUEGROS</option>
							<option value="TIOS">TIOS</option>
						</optgroup>
						<option value="LABORAL">LABORAL</option>
						<option value="AMISTAD">AMISTAD</option>
						<option value="OTRO">OTRO</option>
					</select>
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
        	<button type="submit" class="btn btn-green"><?php _e('Save', 'rrhh'); ?></button>
		</div>
	</form>
</div>
<script>
function refreshReferences(type)
{
	jQuery.post('index.php', 'mod=rrhh&task=ajax&action=get_references&type='+type, function(res)
	{
		if(res.status == 'ok')
		{
			jQuery('#table-work_references tbody').html(res.html);
		}
		else
		{
			alert(res.error);
		}
	});
}
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
		jQuery('#wr_email').val('');
		jQuery('#modal-work-reference').modal('show');
	});
	jQuery(document).on('click', '.btn-edit-reference', function(res)
	{
		jQuery('#wr_id').val(this.dataset.id);
		jQuery('#wr_full_name').val(this.dataset.name);
		jQuery('#wr_company').val(this.dataset.company);
		jQuery('#wr_position').val(this.dataset.position);
		jQuery('#wr_relationship').val(this.dataset.relationship);
		jQuery('#wr_telephone').val(this.dataset.telephone);
		jQuery('#wr_cell_phone').val(this.dataset.cell_phone);
		jQuery('#wr_email').val(this.dataset.email);
		jQuery('#modal-personal-reference').modal('show');
		return false;
	});
	/*
	jQuery(document).on('click', '.btn-delete-reference', function(res)
	{
		var btn = this;
		jQuery.post('index.php', 'mod=rrhh&task=delete_reference&id='+this.dataset.id, function(res)
		{
			refreshReferences(btn.dataset.type);
		});
		
		return false;
	});
	*/
	jQuery('#form-work-reference').submit(function()
	{
		var params = jQuery(this).serialize();
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
		});
		return false;
	});
});
</script>