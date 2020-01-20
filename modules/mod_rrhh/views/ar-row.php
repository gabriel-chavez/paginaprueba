<?php
?>
<tr>
	<td><?php print $rec->study_level; ?></td>
	<td><?php print $rec->center_name; ?></td>
	<td><?php print $rec->degree; ?></td>
	<td><?php print sb_format_date($rec->degree_date); ?></td>
	<td><?php print $rec->degree_city; ?></td>
	<td><?php print $rec->degree_country; ?></td>
	<td>
		<a href="#" class="btn btn-info btn-sm btn-edit-ar" title="<?php _e('Edit', 'rrhh'); ?>"
			<?php foreach($rec as $prop => $val): ?>
			data-<?php print $prop; ?>="<?php print $prop == 'degree_date' ? sb_format_date($val) : $val; ?>"
			<?php endforeach; ?>>
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<a href="#" class="btn btn-danger btn-sm btn-delete-ar confirm" title="<?php _e('Delete', 'rrhh'); ?>"
			data-id="<?php print $rec->id; ?>"
			data-message="<?php _e('Are you sure to delete the acedemic record?', 'rrhh'); ?>">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</td>
</tr>