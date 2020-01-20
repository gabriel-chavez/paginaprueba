<?php
?>
<tr>
	<td><?php print $ref->name; ?></td>
	<td><?php print $ref->company; ?></td>
	<td><?php print $ref->position; ?></td>
	<td><?php print $ref->relationship; ?></td>
	<td><?php print $ref->telephone; ?></td>
	<td><?php print $ref->cell_phone; ?></td>
	<td><?php print $ref->email; ?></td>
	<td>
		<a href="#" class="btn btn-info btn-sm btn-edit-reference"
			<?php foreach($ref as $prop => $value): ?>
			data-<?php print $prop; ?>="<?php print trim($value); ?>"
			<?php endforeach; ?>
			title="<?php _e('Edit', 'rrhh'); ?>">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<a href="#" class="btn btn-danger btn-sm btn-delete-reference" data-id="<?php print $ref->id; ?>" data-type="<?php print $ref->type; ?>"
			title="<?php _e('Delete', 'rrhh'); ?>">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</td>
</tr>