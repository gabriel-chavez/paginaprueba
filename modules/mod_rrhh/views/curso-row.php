<?php
?>
<tr>
	<td><?php print $item->tipo_curso; ?></td>
	<td><?php print $item->nombre; ?></td>
	<td><?php print $item->centro_estudio; ?></td>
	<td><?php print $item->pais; ?></td>
	<td><?php print $item->horas; ?></td>
	<td><?php print $item->modalidad; ?></td>
	<td><?php print sb_format_date($item->fecha_inicio); ?></td>
	<td><?php print sb_format_date($item->fecha_fin); ?></td>
	<?php if( isset($key) ): ?>
	<td>
		<a href="javascript:;" class="btn btn-info btn-sm btn-edit-curso" title="<?php _e('Editar', 'rrhh'); ?>"
			data-id="<?php print $key; ?>"
			data-tipo_curso="<?php print $item->tipo_curso; ?>"
			data-nombre="<?php print $item->nombre; ?>"
			data-centro_estudio="<?php print $item->centro_estudio; ?>"
			data-pais="<?php print $item->pais; ?>"
			data-horas="<?php print $item->horas; ?>"
			data-modalidad="<?php print $item->modalidad; ?>"
			data-fecha_inicio="<?php print sb_format_date($item->fecha_inicio); ?>"
			data-fecha_fin="<?php print sb_format_date($item->fecha_fin); ?>">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<a href="javascript:;" class="btn btn-danger btn-sm btn-delete-curso" title="<?php _e('Borrar', 'rrhh'); ?>"
			data-id="<?php print $key; ?>">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</td>
	<?php endif; ?>
</tr>