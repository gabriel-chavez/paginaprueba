<?php
?>
<div class="wrap">
	<h2>
		<?php _e('Human Resource Announcement', 'rrhh'); ?>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcements.new'); ?>" class="btn btn-primary pull-right"><?php _e('New', 'rrhh'); ?></a>
	</h2>
	<form action="" method="get" class="form-group-sm">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="view" value="announcements.default" />
		<div class="form-group">
			<div class="input-group">
				<input type="text" name="keyword" value="<?php print SB_Request::getString('keyword', ''); ?>" placeholder="<?php _e('Search...', 'rrhh'); ?>" class="form-control" />
				<div class="input-group-btn">
					<select name="search_by" class="form-control" style="width:120px;">
						<option value="name" <?php print SB_Request::getString('search_by') == 'name' ? 'selected' : ''; ?>><?php _e('Name', 'rrhh'); ?></option>
						<option value="code" <?php print SB_Request::getString('search_by') == 'code' ? 'selected' : ''; ?>><?php _e('Code', 'rrhh'); ?></option>
					</select>
				</div>
				<div class="input-group-btn">
					<button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</div>
	</form>
	<?php $table->Show(); ?>
</div>