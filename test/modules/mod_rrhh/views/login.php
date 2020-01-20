<?php
?>
<div class="container">
	<div class="row form-group-sm">
		<div class="col-xs-12 col-md-5">
			<h4><?php _e('Access Form', 'uv'); ?></h4>
			<form action="" method="post">
				<input type="hidden" name="mod" value="rrhh" />
				<input type="hidden" name="task" value="do_login" />
				<div class="form-group">
					<label><?php _e('Docuemnt Identity', 'rrhh'); ?></label>
					<input type="text" name="document" value="" class="form-control" />
				</div>
				<div class="form-group">
					<label><?php _e('Password', 'rrhh'); ?></label>
					<input type="password" name="pwd" value="" class="form-control" />
				</div>
				<div class="form-group">
					<label><?php _e('Secutiry Text', 'rrhh'); ?></label>
					<div class="row">
						<div class="col-md-5"><img src="<?php print SB_Route::_('captcha.php?var=rrhh_captcha'); ?>" alt="" /></div>
						<div class="col-md-4"><input type="text" name="captcha" value="" class="form-control" /></div>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-default btn-green" type="submit"><?php _e('Login', 'uv'); ?></button>
				</div>
				<div class="form-group">
					<a href="<?php print SB_Route::_('index.php?mod=users&view=recover_pwd'); ?>">
						<?php _e('No recuerdas tu contrase&ntilde;a', 'uv'); ?>
					</a>
				</div> 
			</form>
		</div>
		<div class="col-xs-12 col-md-2"></div>
		<div class="col-xs-12 col-md-5">
			<h4><?php _e('Register Form', 'rrhh'); ?></h4>
			<form id="form-register" action="" method="post">
				<input type="hidden" name="mod" value="rrhh" />
				<input type="hidden" name="task" value="do_register" />
				<div class="form-group">
					<label><?php _e('Documento de Identidad', 'rrhh'); ?></label>
					<input type="text" name="document" value="" class="form-control" required="required" />
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
	/*
	jQuery('#form-register').submit(function()
	{
		var form = this;
		jQuery(form).find('button').prop('disabled', true);
		if( jQuery('#reg-msg').length > 0 )
		{
			jQuery('#reg-msg').remove();
		} 
		var params = jQuery(form).serialize();
		jQuery.post('index.php', params, function(res)
		{
			jQuery(form).find('button').prop('disabled', false);
			if( res.status == 'ok' )
			{
				jQuery(form).append("<div id=\"reg-msg\" class=\"alert alert-success\">"+res.message+"</div>");
			}
			else
			{
				jQuery(form).append("<div id=\"reg-msg\" class=\"alert alert-danger\">"+res.error+"</div>");
			}
		});
		return false;
	});
	*/
});
</script>