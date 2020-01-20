<?php
?>
<div class="wrap">
	<h2>
		<?php print $title; ?>
		<span class="pull-right text-right">
			<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcements.default'); ?>" class="btn btn-danger"><?php _e('Back to Announcements', 'rrhh'); ?></a>
			<?php if( $obj->status == 'active' ): ?>
			<a href="javascript:;" id="btn-close-announcement" class="btn btn-warning"><?php _e('Close Announcement', 'rrhh'); ?></a>
			<?php endif; ?>
		</span>
	</h2>
	<table class="table table-condensed">
	<tr>
		<th><?php _e('Code', 'rrhh'); ?></th><td><?php print $obj->code; ?></td>
		<th><?php _e('Announcement', 'rrhh'); ?></th><td><?php print $obj->name; ?></td>
	</tr>
	<tr>
		<th><?php _e('Minimum Score', 'rrhh'); ?></th><td><?php print $obj->min_points; ?></td>
		<th><?php _e('Total Score', 'rrhh'); ?></th><td><?php print $obj->total_score; ?></td>
	</tr>
	</table>
	<p>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh&task=announcements.export2excel&id='.$obj->id); ?>" class="btn btn-info btn-sm">
			<?php _e('Export Score to Excel', 'rrhh'); ?>
		</a>
		<a href="javascript:;" id="btn-export-curricular-filter" class="btn btn-success btn-sm">
			<?php _e('Export Curricular Filter', 'rrhh'); ?>
		</a>
	</p>
	<form action="" method="get" class="form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="view" value="announcements.applicants" />
		<input type="hidden" name="id" value="<?php print $obj->id; ?>" />
		<div class="form-group">
			<div class="input-group">
				<input type="text" name="keyword" value="<?php print SB_Request::getString('keyword', ''); ?>" placeholder="<?php _e('Search...', 'rrhh'); ?>" class="form-control" />
				<div class="input-group-btn">
					<select name="search_by" class="form-control" style="width:120px;">
						<option value="name" <?php print SB_Request::getString('search_by') == 'name' ? 'selected' : ''; ?>><?php _e('Name', 'rrhh'); ?></option>
						<option value="fathers_lastname" <?php print SB_Request::getString('search_by') == 'fathers_lastname' ? 'selected' : ''; ?>><?php _e('Fathers Lastname', 'rrhh'); ?></option>
						<option value="mothers_lastname" <?php print SB_Request::getString('search_by') == 'mothers_lastname' ? 'selected' : ''; ?>><?php _e('Mothers Lastname', 'rrhh'); ?></option>
					</select>
				</div>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</div>
	</form>
	<table class="table table-condensed">
	<thead>
	<tr>
		<th><input type="checkbox" name="selector" value="1" class="tcb-select-all" /></th>
		<th><?php _e('Num', 'rrhh'); ?></th>
		<th><?php _e('Firstname', 'rrhh'); ?></th>
		<th><?php _e('Fathers Name', 'rrhh'); ?></th>
		<th><?php _e('Mothers Name', 'rrhh'); ?></th>
		<th><?php _e('City', 'rrhh'); ?></th>
		<th><?php _e('Country', 'rrhh'); ?></th>
		<th><?php _e('Telephone', 'rrhh'); ?></th>
		<th><?php _e('Cell phone', 'rrhh'); ?></th>
		<th><?php _e('Score', 'rrhh'); ?></th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1; foreach($obj->GetApplicants() as $a): ?>
	<tr>
		<td><input type="checkbox" name="ids[]" value="<?php print $a->id; ?>" class="tcb-select" /></td>
		<td><?php print $i; ?></td>
		<td><?php print $a->first_name; ?></td>
		<td><?php print $a->fathers_lastname; ?></td>
		<td><?php print $a->mothers_lastname; ?></td>
		<td><?php print $a->current_city; ?></td>
		<td><?php print $a->current_country; ?></td>
		<td><?php print $a->telephone; ?></td>
		<td><?php print $a->mobile; ?></td>
		<td><?php print $a->score; ?></td>
		<td>
			<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcements.view_profile&id='.$a->id); ?>" class="btn btn-default btn-sm" 
				target="_blank" title="<?php _e('View Profile', 'rrhh'); ?>">
				<span class="glyphicon glyphicon-eye-open"></span>
			</a>
			<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcements.see_curricular_filter&id='.$obj->id . '&person_id[]='.$a->id); ?>" class="btn btn-default btn-sm"
				title="<?php _e('See Curricular Filter', 'rrhh'); ?>">
				<span class="glyphicon glyphicon-list-alt"></span>
			</a>
		</td>
	</tr>
	<?php $i++; endforeach; ?>
	</tbody>
	</table>
</div>
<div id="modal-close-announcement" class="modal fade">
	<form id="form-close-announcement" action="" method="post" class="modal-dialog form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="announcements.close" />
		<input type="hidden" name="id" value="<?php print $obj->id; ?>" />
		
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel"><?php _e('Close Announcement', 'rrhh'); ?></h4>
			      </div>
			</div>
			<div class="modal-body">
				<label><?php _e('Message', 'rrhh'); ?></label>
				<textarea name="message" class="form-control" style="height:150px;"></textarea>
				<span>Esriba el mensaje a enviar a los que no fueron seleccionados.</span>
			</div>
			<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'rrhh'); ?></button>
	        	<button type="submit" class="btn btn-primary"><?php _e('Close Announcement', 'rrhh'); ?></button>
	      	</div>
		</div>
	</form>
</div>
<script>
jQuery(function()
{
	jQuery('#btn-close-announcement').click(function()
	{
		var ids = jQuery('[name=ids\\[\\]]:checked');
		if( ids.length <= 0 )
		{
			alert('Debe seleccionar al menos un postulante para que sean marcados como seleccionados');
			return false;
		}
		jQuery('#form-close-announcement [name=person_id\\[\\]]').remove();
		jQuery.each(ids, function(i, input)
		{
			var _input = '<input type="hidden" name="person_id[]" value="'+input.value + '" />';
			jQuery('#form-close-announcement').append(_input);
			
		});
		jQuery('#modal-close-announcement').modal('show');
		return false;
	});
	jQuery('#form-close-announcement').submit(function()
	{
		if( this.message.value.trim().length <= 0 )
		{
			alert('Debe escribir un mensaje');
			return false;
		}
		return true;
	});
	jQuery('#btn-export-curricular-filter').click(function()
	{
		var url = '<?php print SB_Route::_('index.php?mod=rrhh&task=announcements.see_curricular_filter&id='.$obj->id); ?>';
		var ids = jQuery('[name=ids\\[\\]]:checked');
		if( ids.length <= 0 )
		{
			alert('Debe seleccionar al menos un postulante para ver el filtro curricular');
			return false;
		}
		jQuery.each(ids, function(i, input)
		{
			url += '&person_id[]='+input.value;
		});
		window.location = url;
	});
});
</script>