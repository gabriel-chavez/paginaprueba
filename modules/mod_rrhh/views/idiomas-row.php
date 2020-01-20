<?php
?>
<tr>
	<td><?php print $item->idioma; ?></td>
	<td><?php print $item->nivel_lectura; ?></td>
	<td><?php print $item->nivel_escritura; ?></td>
	<td><?php print $item->nivel_conversacion; ?></td>
	<?php if( isset($key) ): ?>
	<td>
		<a href="javascript:;" class="btn btn-info btn-sm btn-edit-idioma"
			data-id="<?php print $key; ?>"
			data-idioma="<?php print $item->idioma; ?>"
			data-nivel_lectura="<?php print $item->nivel_lectura; ?>"
			data-nivel_escritura="<?php print $item->nivel_escritura; ?>"
			data-nivel_conversacion="<?php print $item->nivel_conversacion; ?>">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<a href="javascript:;" class="btn btn-info btn-danger btn-delete-idioma" data-id="<?php print $key; ?>">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</td>
	<?php endif; ?>
</tr>