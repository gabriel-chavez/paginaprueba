<h4>Experiencia Laboral</h4>
<span>(Empezando de la actual o de su &uacute;ltimo trabajo)</span>
<div>
	<a href="#" id="btn-add-work-experience" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add Work Experience', 'rrhh'); ?></a>
</div>
<div id="we-messages"></div>
<div id="we-container"><?php $we_actions = true; foreach($person->GetWorkExperience() as $exp) include 'we-row.php'; ?></div>
<div id="modal-work-experience" class="modal fade">
	<form action="" method="post" id="form-work-experience" class="modal-dialog form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_work_experience" />
		<input type="hidden" name="ajax" value="1" />
		<input type="hidden" id="we_id" name="id" value="0" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Experiencia Laboral', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Empresa Institucion', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="company" name="company" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Sector', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="company_industry" name="company_industry" value="" class="form-control required" />
				</div>
				<label class="control-label col-sm-3 required"><?php _e('Company Phone', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="company_phone" name="company_phone" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Cargo', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="position" name="position" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Principales Funciones', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<textarea id="main_functions" name="main_functions" class="form-control"></textarea><br/>
					<span>Maximo 255 caracteres</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Nro. de Dependientes', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="dependent" name="dependent" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Fecha Inicio', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="start_date" name="start_date" value="" class="form-control required datepicker" />
				</div>
				<label class="control-label col-sm-3 required"><?php _e('Fecha Conclusion', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="end_date" name="end_date" value="" class="form-control required datepicker" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Superior Name', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="superior_name" name="superior_name" value="" class="form-control required" />
				</div>
				<label class="control-label col-sm-3 required"><?php _e('Superior Position', 'rrhh'); ?></label>
				<div class="col-sm-3">
					<input type="text" id="superior_position" name="superior_position" value="" class="form-control required" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Actualmente Trabajando', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="checkbox" id="currently_working" name="currently_working" value="1" class="" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 required"><?php _e('Motivo Desvinculacion', 'rrhh'); ?></label>
				<div class="col-sm-9">
					<input type="text" id="decouplin_reason" name="decouplin_reason" value="" class="form-control required" />
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'rrhh');?></button>
        	<button type="submit" id="btn-save-we" class="btn btn-green"><?php _e('Save', 'rrhh'); ?></button>
		</div>
	</form>
</div>
<script>
function refreshWorkExperience()
{
	jQuery.post('index.php','mod=rrhh&task=ajax&action=get_workexperience', function(res)
	{
		if( res.status == 'ok' )
		{
			jQuery('#we-container').html(res.html);
		}
		else
		{
			jQuery('#fa-messages').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.error+'</div>');
		}
	});
	rrhh_profile.RefreshCV();
}
jQuery(function()
{
	jQuery('#btn-add-work-experience').click(function()
	{
		jQuery('#we_id').val('0');
		jQuery('#company').val('');
		jQuery('#company_industry').val('');
		jQuery('#position').val('');
		jQuery('#main_functions').val('');
		jQuery('#dependent').val('');
		jQuery('#start_date, #end_date').val('');
		jQuery('#superior_name, #superior_position').val('');
		jQuery('#decouplin_reason').val('');
		jQuery('#currently_working').prop('checked', false);
		jQuery('#end_date,#decouplin_reason').prop('disabled', false);
		jQuery('#modal-work-experience').modal('show');
		jQuery('#btn-save-we').prop('disabled', false);
		return false;
	});
	jQuery('#currently_working').click(function(e)
	{
		jQuery('#end_date,#decouplin_reason').prop('disabled', jQuery(this).is(':checked'));
	});
	jQuery(document).on('click', '.btn-edit-we', function()
	{
		jQuery.get('index.php?mod=rrhh&task=ajax&action=get_workexperience&id=' + this.dataset.id, function(res)
		{
			if( res.status == 'ok' )
			{
				jQuery('#we_id').val(res.obj.id);
				jQuery('#company').val(res.obj.company);
				jQuery('#company_phone').val(res.obj.company_phone);
				jQuery('#company_industry').val(res.obj.company_industry);
				jQuery('#position').val(res.obj.position);
				jQuery('#main_functions').val(res.obj.main_functions);
				jQuery('#dependent').val(res.obj.dependent);
				jQuery('#start_date').val(res.obj.start_date);
				jQuery('#end_date').val(res.obj.end_date);
				jQuery('#superior_name').val(res.obj.superior_name);
				jQuery('#superior_position').val(res.obj.superior_position);
				jQuery('#currently_working').prop('checked', parseInt(res.obj.currently_working) ? true : false);
				jQuery('#decouplin_reason').val(res.obj.decouplin_reason);
				jQuery('#modal-work-experience').modal('show');
				jQuery('#end_date,#decouplin_reason').prop('disabled', jQuery('#currently_working').is(':checked'));
			}
			else
			{
				alert(res.error);
			}
		});
		return false;
	});
	jQuery(document).on('click', '.btn-delete-we', function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=delete_workexperience&id='+this.dataset.id, function(res)
		{
			refreshWorkExperience();
		});
		return false;
	});
	jQuery('#form-work-experience').submit(function()
	{
		if( this.company.value.trim().length <= 0 )
		{
			alert('Debe ingresar el nombre de la empresa o institución');
			return false;
		}
		if( this.company_industry.value.trim().length <= 0 )
		{
			alert('Debe ingresar el sector de la empresa o institución');
			return false;
		}
		if( this.company_phone.value.trim().length <= 0 )
		{
			alert('Debe ingresar el teléfono de la empresa o institución');
			return false;
		}
		if( this.position.value.trim().length <= 0 )
		{
			alert('Debe ingresar el cargo');
			return false;
		}
		if( this.main_functions.value.trim().length <= 0 )
		{
			alert('Debe ingresar las principales funciones');
			return false;
		}
		if( this.dependent.value.trim().length <= 0 || isNaN(parseInt(this.dependent.value.trim())) )
		{
			alert('El numero de dependientes es invalido');
			return false;
		}
		if( this.start_date.value.trim().length <= 0 )
		{
			alert('Debe ingresar la fecha de inicio');
			return false;
		}
		if( !this.currently_working.checked && this.end_date.value.trim().length <= 0 )
		{
			alert('Debe ingresar la fecha de conclusion');
			return false;
		}
		if( this.superior_name.value.trim().length <= 0 )
		{
			alert('Debe ingresar el nombre del superior');
			return false;
		}
		if( this.superior_position.value.trim().length <= 0 )
		{
			alert('Debe ingresar el cargo del superior');
			return false;
		}
		if( !this.currently_working.checked && this.decouplin_reason.value.trim().length <= 0 )
		{
			alert('Debe ingresar el motivo de la desvinculacioón');
			return false;
		}
		jQuery('#btn-save-we').prop('disabled', true);
		var params = jQuery(this).serialize();
		jQuery.post('index.php', params, function(res)
		{
			jQuery('#btn-save-we').prop('disabled', false);
			jQuery('#modal-work-experience').modal('hide');
			if( res.status == 'ok' )
			{
				jQuery('#we-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
			}
			else
			{
				jQuery('#we-messages').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.error+'</div>');
			}
			refreshWorkExperience();
		});
		return false;
	});
});
</script>
