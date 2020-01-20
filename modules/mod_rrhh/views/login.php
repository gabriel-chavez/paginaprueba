<?php
?>
<div class="container">
	<div class="row form-group-sm">
		<div class="col-xs-12 text-center">
			<a class="btn btn-warning" href="index.php?mod=rrhh&view=announcementspublic">Ver Convocatorias</a>
			<hr />
		</div>
		<div class="col-xs-12 col-md-5 registro">		
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
					<input type="password" name="pwd" value="" class="form-control" required="required" id="inputPassword"/>
					<span id="novalido" class="small" style="color:red;display:none">La contraseña debe contener mínimamente 8 caracteres, una letra mayúscula, minúscula y un caracter especial.</span>
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
					<button type="submit" class="btn btn-default btn-green" onclick="javascript:return validarComplejidadPass();"><?php _e('Register', 'rrhh'); ?></button>
				</div>
			</form>
		</div>
		<div class="col-xs-12 col-md-2 registro"></div>
		<div class="col-xs-12 col-md-5 registro2">
			<h4><?php _e('Access Form', 'rrhh'); ?></h4>
			<form action="" method="post">
				<input type="hidden" name="mod" value="rrhh" />
				<input type="hidden" name="task" value="do_login" />
				<div class="form-group">
					<label><?php _e('Docuemnt Identity', 'rrhh'); ?></label>
					<input type="text" id="log_document" name="document" value="" class="form-control" />
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

$("#inputPassword").on("keypress",function(){
	$("#novalido").hide();
});
function validarComplejidadPass(){
	var constrasena=$("#inputPassword").val();
	var regex=/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)(?=\S*[^\w\s])\S{8,}$/;
	if(regex.test(constrasena))
	{
		$("#novalido").hide();
		return true;
	}else{
		$("#novalido").show();
		return false;
	}	
}
</script>
