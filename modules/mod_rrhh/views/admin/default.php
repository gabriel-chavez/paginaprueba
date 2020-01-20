<?php
$search_by = SB_Request::getString('search_by');
?>
<div class="wrap">
	<h2><?php _e('Human Resource Management', 'rrhh'); ?></h2>
	<form action="" method="get">
		<input type="hidden" name="mod" value="rrhh" />
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<input type="text" name="keyword" value="<?php print SB_Request::getString('keyword'); ?>" placeholder="Buscar..." class="form-control" />
				</div>
			</div>
			<div class="col-md-2">
				<select name="search_by" class="form-control">
					<option value="first_name" <?php print $search_by == 'first_name' ? 'selected' : ''; ?>>Nombres</option>
					<option value="fathers_lastname" <?php print $search_by == 'fathers_lastname' ? 'selected' : ''; ?>>Apellido Paterno</option>
					<option value="mothers_lastname" <?php print $search_by == 'mothers_lastname' ? 'selected' : ''; ?>>Apellido Materno</option>
				</select>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary"><?php _e('Buscar', 'rrhh'); ?></button>
			</div>
		</div>
	</form>
	<p>
		<a href="javascript:;" id="btn-delete-selected" class="btn btn-default"><?php _e('Borrar Seleccion', 'rrhh'); ?></a>
	</p>
	<?php print $table->Show(); ?>
</div>
<script>
jQuery(function()
{
	jQuery('#btn-delete-selected').click(function()
	{
		var url = 'index.php?mod=rrhh&task=delete';
		jQuery('.tcb-select:checked').each(function(i, cb)
		{
			url += '&id[]='+cb.value;
		});
		window.location = url;
		return false;
	});
});
</script>