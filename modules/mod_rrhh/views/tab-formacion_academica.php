<h4>Informacion Sobre Formacion Academica</h4>
<div id="fa-messages"></div>
<div>
	<a href="#" id="btn-add-record" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add New', 'rrhh'); ?></a>
</div>
<table id="table-academic-records" class="table table-condensed">
<thead>
<tr>
	<th><?php _e('Nivel de Formacion', 'rrhh'); ?></th>
	<th><?php _e('Centro Educativo', 'rrhh'); ?></th>
	<th><?php _e('Titulo Obtenido', 'rrhh'); ?></th>
	<th><?php _e('Fecha Titulo', 'rrhh'); ?></th>
	<th><?php _e('Ciudad', 'rrhh'); ?></th>
	<th><?php _e('Pais', 'rrhh'); ?></th>
	<th></th>
</tr>
</thead>
<tbody>
<?php 
foreach($person->GetAcademicRecords() as $rec)
{
	include 'ar-row.php';
}
?>
</tbody>
</table>
<div id="modal-formacion" class="modal fade">
	<form id="form-formacion" action="" method="post" class="modal-dialog form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_record" />
		<input type="hidden" id="ar_id" name="id" value="0" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Informacion Academica', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body form-horizontal">
			<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Nivel de Formacion', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<select id="study_level_id" name="study_level_id" class="form-control required">
        				<option value="">-- nivel de estudio --</option>
        				<?php foreach($study_levels as $sl): ?>
        				<option value="<?php print $sl->id; ?>"><?php print $sl->name; ?></option>
        				<?php endforeach;?>
        			</select>
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Centro de Estudios', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<input type="text" id="center_name" name="center_name" value="" class="form-control required">
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Titulo Obtenido', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<input type="text" id="degree" name="degree" value="" class="form-control required">
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Fecha de Emision', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<input type="text" id="degree_date" name="degree_date" value="" class="form-control datepicker required" 
						data-date-end-date="0d" />
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Ciudad de Obtencion de Titulo', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<input type="text" id="degree_city" name="degree_city" value="" class="form-control required">
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-sm-4 required"><?php _e('Pais de Obtencion de Titulo', 'rrhh'); ?></label>
        		<div class="col-sm-8">
        			<?php sb_dropdown_countries(array('id' => 'degree_country', 
														'class' => 'form-control required',
														'selected'	=> 'BO',
														'text' => __('-- pais --', 'rrhh'))); ?>
        		</div>
        	</div>
			<div class="clearfix"></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'rrhh');?></button>
        	<button type="submit" id="btn-save-formacion" class="btn btn-green"><?php _e('Save', 'rrhh'); ?></button>
		</div>
	</form>
</div>
