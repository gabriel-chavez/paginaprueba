<?php
?>
<div class="wrap">
	<h2>
		<?php print $title; ?>
		<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=studylevels.new'); ?>" class="btn btn-primary pull-right">
			<?php _e('New', 'rrhh'); ?>
		</a>
	</h2>
	<?php $table->Show(); ?>
</div>