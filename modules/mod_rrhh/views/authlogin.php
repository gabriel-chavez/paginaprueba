<?php
?>
<div class="container">
	<div class="row form-group-sm">
		<div class="col-xs-12 col-md-4 col-md-offset-4 registro2">
			<h4><?php _e('Access Form', 'rrhh'); ?></h4>
			<form action="" method="post" on>				
				<input type="hidden" name="mod" value="rrhh" />
				<input type="hidden" name="task" value="do_login" />
				<div class="form-group">
					<label><?php _e('Docuemnt Identity', 'rrhh'); ?></label>
					<input type="text" id="log_document" name="document" value="" class="form-control" />
				</div>
				<div class="form-group">
					<label><?php _e('Password', 'rrhh'); ?></label>
					<input type="password" name="pwd" value="" class="form-control"  />
					
				</div>
				<div class="form-group">
					<label><?php _e('Secutiry Text', 'rrhh'); ?></label>
					<div class="row">
						<div class="col-md-5"><img src="<?php print SB_Route::_('captcha.php?var=rrhh_captcha'); ?>" alt="" /></div>
						<div class="col-md-4"><input type="text" name="captcha" value="" class="form-control" /></div>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-default btn-green" type="submit" ><?php _e('Login', 'uv'); ?></button>
				</div>
				<div class="form-group">
					<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=recover_pwd'); ?>">
						<?php _e('No recuerdas tu contrase&ntilde;a', 'uv'); ?>
					</a>
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
