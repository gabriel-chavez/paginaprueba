<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="mod" value="rrhh" />
	<input type="hidden" name="task" value="save_profile" />
	<h4>Datos Generales Del Postulante</h4>
	<div class="row">
		<div class="col-xs-12 col-md-6 form-horizontal">
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Firstname', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="first_name" value="<?php print isset($person) ? $person->first_name : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Fathers Name', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="fathers_lastname" value="<?php print isset($person) ? $person->fathers_lastname : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Mothers Name', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="mothers_lastname" value="<?php print isset($person) ? $person->mothers_lastname : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Birth Date', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="birthday" value="<?php print isset($person) ? sb_format_date($person->birthday) : ''; ?>" class="form-control datepicker" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Place of birth', 'rrhh'); ?></label>
				<label class="col-sm-2 control-label"><?php _e('City', 'rrhh'); ?></label>
				<div class="col-sm-2"><input type="text" name="city_birth" value="<?php print isset($person) ? $person->city_birth : ''; ?>" class="form-control" /></div>
				<label class="col-sm-2 control-label"><?php _e('Country', 'rrhh'); ?></label>
				<div class="col-sm-3"><?php sb_dropdown_countries(array('id' => 'country_birth', 'selected' => isset($person) ? $person->country_birth : '-1')); ?></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Place of residence', 'rrhh'); ?></label>
				<label class="col-sm-2 control-label"><?php _e('City', 'rrhh'); ?></label>
				<div class="col-sm-2"><input type="text" name="current_city" value="<?php print isset($person) ? $person->current_city : ''; ?>" class="form-control" /></div>
				<label class="col-sm-2 control-label"><?php _e('Country', 'rrhh'); ?></label>
				<div class="col-sm-3"><?php sb_dropdown_countries(array('id' => 'current_country', 'selected' => isset($person) ? $person->country_country_code : '-1')); ?></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Address', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="address_1" value="<?php print isset($person) ? $person->address_1 : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Zone', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="address_zone" value="<?php print isset($person) ? $person->address_zone : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Telephone', 'rrhh'); ?></label>
				<div class="col-sm-3"><input type="text" name="telephone" value="<?php print isset($person) ? $person->telephone : ''; ?>" class="form-control" /></div>
				<label class="col-sm-3 control-label"><?php _e('Mobile Telephone', 'rrhh'); ?></label>
				<div class="col-sm-3"><input type="text" name="mobile" value="<?php print isset($person) ? $person->mobile : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Email', 'rrhh'); ?></label>
				<div class="col-sm-9"><input type="text" name="email" value="<?php print isset($person) ? $person->email : ''; ?>" class="form-control" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Document Type', 'rrhh'); ?></label>
				<label class="col-sm-4 control-label">
					<?php _e('Identity Document', 'rrhh'); ?>
					<input type="radio" name="document_type" value="ci" class="" <?php print isset($person) && $person->document_type == 'ci' ? 'checked' : ''; ?> />
				</label>
				<label class="col-sm-3 control-label">
					<?php _e('Passport', 'rrhh'); ?>
					<input type="radio" name="document_type" value="passport" class="" <?php print isset($person) && $person->document_type == 'passport' ? 'checked' : ''; ?> />
				</label>
				<label class="col-sm-2 control-label">
					<?php _e('RUN', 'rrhh'); ?>
					<input type="radio" name="document_type" value="run" class="" <?php print isset($person) && $person->document_type == 'run' ? 'checked' : ''; ?> />
				</label>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Document Number', 'rrhh'); ?></label>
				<div class="col-sm-4"><input type="text" name="document" value="<?php print isset($person) ? $person->document : ''; ?>" class="form-control" /></div>
				<label class="col-sm-2 control-label"><?php _e('Issued in', 'rrhh'); ?></label>
				<div class="col-sm-3"><input type="text" name="document_from" value="<?php print isset($person) ? $person->document_from : ''; ?>" class="form-control" /></div>
			</div>
			<p class="text-center"><button type="submit" class="btn btn-green"><?php _e('Save', 'rrhh'); ?></button></p>
		</div>
		<div class="col-xs-12 col-md-6">
			<div class="form-group">
				<label><?php _e('Fotografia', 'rrhh'); ?></label>
				<div class="row">
					<div class="col-xs-12 col-md-3">
						<?php if( $person->_image && file_exists(MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image) ):?>
						<img src="<?php print MOD_RRHH_IMAGES_URL . '/' . $person->_image; ?>" alt="<?php print $person->first_name; ?>" class="thumbnail" style="width:128px;" />
						<?php else: ?>
						<img src="<?php print BASEURL; ?>/images/nobody.png" class="thumbnail" />
						<?php endif;?>
					</div>
					<div class="col-xs-12 col-md-1">
						<?php if( $person->_image && file_exists(MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image) ):?>
						<a href="<?php print SB_Route::_('index.php?mod=rrhh&task=delete_image'); ?>" class="btn btn-primary btn-sm"><?php _e('Delete', 'rrhh'); ?></a>
						<?php endif; ?>
					</div>
				</div>
				
				<input type="file" name="image" value="" class="" />
			</div>
		</div>
	</div>
</form>