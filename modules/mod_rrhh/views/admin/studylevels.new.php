<?php
?>
<div class="wrap">
	<h2><?php print $title; ?></h2>
	<form action="" method="post">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="studylevels.save" />
		<?php if( isset($obj) ): ?>
		<input type="hidden" name="id" value="<?php print $obj->id; ?>" />
		<?php endif; ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label><?php _e('Name'); ?></label>
					<input type="text" name="name" value="<?php print isset($obj) ? $obj->name : ''; ?>" class="form-control" />
				</div>
			</div>
			<div class="col-md-6"></div>
		</div>
		<div class="form-group">
			<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=studylevels.default'); ?>" class="btn btn-danger"><?php _e('Back', 'rrhh'); ?></a>
			<button type="submit" class="btn btn-primary"><?php _e('Save', 'rrhh'); ?></button>
		</div>
	</form>
</div>