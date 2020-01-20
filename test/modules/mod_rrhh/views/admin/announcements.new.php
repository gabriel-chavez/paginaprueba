<?php
?>
<div class="wrap">
	<h2><?php _e('Announcements'); ?></h2>
	<form action="" method="post" class="form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="announcements.save" />
		<?php if( isset($obj) ): ?>
		<input type="hidden" name="id" value="<?php print $obj->id; ?>" />
		<?php endif; ?>
		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
					<label><?php _e('Code', 'rrhh'); ?></label>
					<div class="input-group">
						<input type="text" name="code" value="<?php print isset($obj) ? $obj->code : SB_Request::getString('code', ''); ?>" class="form-control" />
						<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcement&id='.$obj->id, 'frontend'); ?>" target="_blank"
							class="btn btn-default btn-sm input-group-addon">
							<?php _e('View', 'rrhh'); ?>
						</a>
					</div>
					
				</div>
				<div class="form-group">
					<label><?php _e('Name', 'rrhh'); ?></label>
					<input type="text" name="name" value="<?php print isset($obj) ? $obj->name : SB_Request::getString('name', ''); ?>" class="form-control" />
				</div>
				<div class="form-group">
					<label><?php _e('Description', 'rrhh'); ?></label>
					<div class="form-group">
						<a href="#" id="btn-add-media" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-hdd"></span> <?php _e('Add Media', 'rrhh'); ?>
						</a>
					</div>
					<textarea name="description" class="form-control"><?php print isset($obj) ? $obj->description : SB_Request::getString('description', ''); ?></textarea>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
							<label><?php _e('Study Levels', 'rrhh'); ?></label>
							<table class="table table-condensed">
							<thead>
							<tr>
								<th><?php _e('Name', 'rrhh'); ?></th>
								<th><?php _e('Points', 'rrhh'); ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($study_levels as $sl): ?>
							<tr>
								<td><?php print $sl->name; ?><input type="hidden" name="data[study_levels][id_<?php print $sl->id?>][name]" value="<?php print $sl->name; ?>" /></td>
								<td>
									<input type="number" min="0" name="data[study_levels][id_<?php print $sl->id?>][points]" 
										value="<?php print isset($obj) && isset($data->study_levels->{"id_$sl->id"}) ? (int)$data->study_levels->{"id_$sl->id"}->points : '0'; ?>" class="form-control" />
								</td>
							</tr>
							<?php endforeach; ?>
							</tbody>
							</table>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
							<label><?php _e('Specific Experience', 'rrhh'); ?></label>
							<table class="table table-condensed">
							<thead>
							<tr>
								<th><?php _e('Desde', 'rrhh');?></th>
								<th><?php _e('A', 'rrhh');?></th>
								<th><?php _e('Puntos', 'rrhh');?></th>
							</tr>
							</thead>
							<tbody>
							<?php for($i = 0; $i < 8; $i++): ?>
							<tr>
								<td>
									<input type="number" name="data[specific_experience][<?php print $i; ?>][from]" 
										value="<?php print isset($obj) ? (int)$data->specific_experience[$i]->from : ''; ?>" class="form-control" /></td>
								<td>
									<input type="number" name="data[specific_experience][<?php print $i; ?>][to]" 
										value="<?php print isset($obj) ? (int)$data->specific_experience[$i]->to : ''; ?>" class="form-control" /></td>
								<td>
									<input type="number" name="data[specific_experience][<?php print $i; ?>][points]" 
										value="<?php print isset($obj) ? (int)$data->specific_experience[$i]->points : ''; ?>" class="form-control" /></td>
							</tr>
							<?php endfor; ?>
							</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="form-group">
							<label><?php _e('General Experience', 'rrhh'); ?></label>
							<table class="table table-condensed">
							<thead>
							<tr>
								<th><?php _e('Desde', 'rrhh');?></th>
								<th><?php _e('A', 'rrhh');?></th>
								<th><?php _e('Puntos', 'rrhh');?></th>
							</tr>
							</thead>
							<tbody>
							<?php for($i = 0; $i < 8; $i++): ?>
							<tr>
								<td>
									<input type="number" name="data[general_experience][<?php print $i; ?>][from]" 
										value="<?php print isset($obj) ? (int)$data->general_experience[$i]->from : ''; ?>" class="form-control" /></td>
								<td>
									<input type="number" name="data[general_experience][<?php print $i; ?>][to]" 
										value="<?php print isset($obj) ? (int)$data->general_experience[$i]->to : ''; ?>" class="form-control" /></td>
								<td>
									<input type="number" name="data[general_experience][<?php print $i; ?>][points]" 
										value="<?php print isset($obj) ? (int)$data->general_experience[$i]->points : ''; ?>" class="form-control" /></td>
							</tr>
							<?php endfor; ?>
							</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><h4 class="panel-title"><?php _e('Options', 'rrhh'); ?></h4></div>
					<div class="panel-body">
						<div class="form-group">
							<label><?php _e('Status', 'rrhh'); ?></label>
							<select name="status" class="form-control">
								<?php foreach(rrhh_get_announcement_statuses() as $status => $label): ?>
								<option value="active" <?php print isset($obj) && $obj->status == $status ? 'selected' : ''; ?>><?php print $label; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label><?php _e('Start Date', 'rrhh'); ?></label>
							<input type="text" name="start_date" value="<?php print isset($obj) ? sb_format_date($obj->start_date) : sb_format_date(SB_Request::getDate('start_date', date('Y-m-d'))); ?>" class="form-control datepicker" />
						</div>
						<div class="form-group">
							<label><?php _e('End Date', 'rrhh'); ?></label>
							<input type="text" name="end_date" value="<?php print isset($obj) ? sb_format_date($obj->end_date) : sb_format_date(SB_Request::getDate('end_date', date('Y-m-d'))); ?>" class="form-control datepicker" />
						</div>
						<div class="form-group">
							<label><?php _e('Vacancies', 'rrhh'); ?></label>
							<input type="number" min="1" name="vacancies" value="<?php print isset($obj) ? (int)$obj->vacancies : '1'; ?>" class="form-control" />
						</div>
						<div class="form-group">
							<label><?php _e('Minimum Score', 'rrhh'); ?></label>
							<input type="number" min="1" name="min_points" value="<?php print isset($obj) ? (int)$obj->min_points : '1'; ?>" class="form-control" />
						</div>
						<div class="form-group">
							<label><?php _e('Total Score', 'rrhh'); ?></label>
							<input type="number" min="1" name="total_score" value="<?php print isset($obj) ? (int)$obj->total_score : '100'; ?>" class="form-control" />
						</div>
						<div class="form-group">
							<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcements.default'); ?>" class="btn btn-primary"><?php _e('Cancel', 'rrhh'); ?></a>
							<button type="submit" class="btn btn-primary"><?php _e('Save', 'rrhh'); ?></button>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</form>
</div>
<div id="modal-media" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title"><?php _e('Upload Files', 'rrhh'); ?></h4>
			</div>
			<div class="modal-body">
				<iframe id="iframe-upload-media" src="" data-src="<?php print SB_Route::_('index.php?mod=storage&view=uploader&tpl_file=module'); ?>" 
					style="width:100%;height:350px;" frameborder="0"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close'); ?></button>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(function()
{
	jQuery('#btn-add-media').click(function(e)
	{
		var iframe	= jQuery('#iframe-upload-media');
		var modal 	= jQuery('#modal-media');
		iframe.prop('src', iframe.data('src'));
		modal.modal('show');
	});
	jQuery(document).on('media_selected', function(e, data)
	{
		jQuery('#modal-media').modal('hide');
		var img = '<img src="<?php print UPLOADS_URL; ?>/'+data.file+'" alt="" />';
		tinymce.activeEditor.execCommand(
			    'mceInsertContent',
			    false,
			    img
			);
	});
});
</script>