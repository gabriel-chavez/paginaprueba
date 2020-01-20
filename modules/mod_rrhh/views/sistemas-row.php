<?php
?>
<tr>
	<td><?php print strtolower($item->sistema) == 'otro' ? $item->otro_sistema : $item->sistema; ?></td>
	<td><?php print $item->nivel; ?></td>
	<?php if( !isset($is_pdf) || !$is_pdf ): ?>
	<td>
		<a href="javascript:;" class="btn btn-info btn-sm btn-edit-sistema"
			data-id="<?php print $key; ?>"
			data-sistema="<?php print $item->sistema; ?>"
			data-otro="<?php print $item->otro_sistema; ?>"
			data-nivel="<?php print $item->nivel; ?>">
			<span class="glyphicon glyphicon-edit"></span>
		</a>
		<a href="javascript:;" class="btn btn-info btn-danger btn-delete-sistema" data-id="<?php print $key; ?>">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</td>
	<?php endif; ?>
</tr>