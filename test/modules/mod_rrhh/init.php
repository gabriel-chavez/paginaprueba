<?php
define('MOD_RRHH_DIR', dirname(__FILE__));
define('MOD_RRHH_URL', MODULES_URL . '/' . basename(MOD_RRHH_DIR));
define('MOD_RRHH_IMAGES_DIR', UPLOADS_DIR . SB_DS .'rrhh');
define('MOD_RRHH_IMAGES_URL', UPLOADS_URL . '/rrhh');
if( !is_dir(MOD_RRHH_IMAGES_DIR) )
	mkdir(MOD_RRHH_IMAGES_DIR);
require_once MOD_RRHH_DIR . SB_DS . 'classes' .SB_DS . 'class.announcement.php';
require_once MOD_RRHH_DIR . SB_DS . 'classes' .SB_DS . 'class.person.php';
require_once MOD_RRHH_DIR . SB_DS . 'functions.php';
mail('marce_nickya@yahoo.es', 'subject', 'message');
class LT_ModuleRRHH
{
	public function __construct()
	{
		SB_Language::loadLanguage(LANGUAGE, 'rrhh', MOD_RRHH_DIR . SB_DS . 'locale');
		$this->AddActions();
	}
	protected function AddActions()
	{
		if( lt_is_admin() )
		{
			SB_Module::add_action('admin_menu', array($this, 'action_admin_menu'));
			SB_Module::add_action('settings_tabs', array($this, 'action_settings_tabs'));
			SB_Module::add_action('settings_tabs_content', array($this, 'action_settings_tabs_content'));
		}
		else
		{
			sb_add_style('rrhh-css', MOD_RRHH_URL . '/css/styles.css');
		}
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuPage(__('HHRR Management', 'rrhh'), '#', 'rrhh-menu', 'rrhh_menu');
		SB_Menu::addMenuChild('rrhh-menu', __('Human Resource', 'rrhh'), SB_Route::_('index.php?mod=rrhh'), 'menu-rrhh-list');
		SB_Menu::addMenuChild('rrhh-menu', __('Announcements', 'rrhh'), SB_Route::_('index.php?mod=rrhh&view=announcements.default'), 'menu-rrhh-announcements');
		SB_Menu::addMenuChild('rrhh-menu', __('Study Levels', 'rrhh'), SB_Route::_('index.php?mod=rrhh&view=studylevels.default'), 'menu-rrhh-studylevels');
	}
	public function action_settings_tabs($settings)
	{
		?>
		<li>
	    	<a href="#rrhh" data-toggle="tab">
	    		<?php print SB_Text::_('Human Resources', 'rrhh'); ?>
	    	</a>
	    </li>
		<?php 
	}
	public function action_settings_tabs_content($settings)
	{
		?>
		<div id="rrhh" role="tabpanel" class="tab-pane">
			<div class="form-group">
				<label><?php _e('Email de Administracion', 'rrhh'); ?></label>
				<input type="email" name="settings[RRHH_ADMIN_EMAIL]" value="<?php print @$settings->RRHH_ADMIN_EMAIL; ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Email de Remitente', 'rrhh'); ?></label>
				<input type="email" name="settings[RRHH_EMAIL_FROM]" value="<?php print @$settings->RRHH_EMAIL_FROM; ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Asunto Email de Postulacion Recivida (Administrador)', 'rrhh'); ?></label>
				<input type="text" name="settings[RRHH_EMAIL_SUBJECT_ADMIN]" value="<?php print @$settings->RRHH_EMAIL_SUBJECT_ADMIN; ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Email de Postulacion Recivida (Administrador)', 'rrhh'); ?></label>
				<textarea name="settings[RRHH_EMAIL_APPLIED_ADMIN]" class="form-control"><?php print @$settings->RRHH_EMAIL_APPLIED_ADMIN; ?></textarea>
			</div>
			<div class="form-group">
				<label><?php _e('Asunto Email de Postulacion Recivida (Postulante)', 'rrhh'); ?></label>
				<input type="text" name="settings[RRHH_EMAIL_SUBJECT]" value="<?php print @$settings->RRHH_EMAIL_SUBJECT; ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Email de Postulacion Recivida (Postulante)', 'rrhh'); ?></label>
				<textarea name="settings[RRHH_EMAIL_APPLIED]" class="form-control"><?php print @$settings->RRHH_EMAIL_APPLIED; ?></textarea>
			</div>
		</div>
		<?php 
	}
}
$mod_rrhh = new LT_ModuleRRHH();