<?php
?>
<div class="container">
	<div class="row form-group-sm">
		<div class="col-xs-12 col-md-4 col-md-offset-4 registro">
			<h4><?php _e('Register Form', 'rrhh'); ?></h4>
			<form id="form-register" action="" method="post">
				<input type="hidden" name="mod" value="rrhh" />
				<input type="hidden" name="task" value="do_register" />
				<div class="form-group">
					<label><?php _e('Documento de Identidad', 'rrhh'); ?></label>
					<input type="text" id="reg_document" name="document" value="" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label><?php _e('Email', 'rrhh'); ?></label>
					<input type="email" name="email" value="" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label><?php _e('Password', 'rrhh'); ?></label>
					<input type="password" name="pwd" value="" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label><?php _e('Confirm your password', 'rrhh'); ?></label>
					<input type="password" name="rpwd" value="" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label><?php _e('Secutiry Text', 'rrhh'); ?></label>
						<div class="row">
							<div class="col-md-5"><img src="<?php print SB_Route::_('captcha.php?var=reg_captcha'); ?>" alt="" /></div>
							<div class="col-md-4"><input type="text" name="captcha" value="" class="form-control" /></div>
						</div>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-default btn-green"><?php _e('Register', 'rrhh'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
jQuery(function()
{
	jQuery('#log_document,#reg_document').keydown(function(e)
	{
		if(e.keyCode == 32)
			return false;
	});
});
</script>
