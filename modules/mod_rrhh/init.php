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

class LT_ModuleRRHH
{
	public function __construct()
	{
		SB_Language::loadLanguage(LANGUAGE, 'rrhh', MOD_RRHH_DIR . SB_DS . 'locale');
		$this->AddActions();
	}
	protected function AddActions()
	{
		SB_Module::add_action('init', array($this, 'action_init'));
		if( lt_is_admin() )
		{
			SB_Module::add_action('admin_menu', array($this, 'action_admin_menu'));
			SB_Module::add_action('settings_tabs', array($this, 'action_settings_tabs'));
			SB_Module::add_action('settings_tabs_content', array($this, 'action_settings_tabs_content'));
		}
		else
		{
			sb_add_style('rrhh-css', MOD_RRHH_URL . '/css/styles.css');
			SB_Module::add_action('users_password_updated', array($this, 'action_user_password_updated'));
		}
	}
	public function action_user_password_updated($row, $pwd)
	{
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));die();
	}
	public function action_init()
	{
		if( SB_Request::getTask() == 'rrhh_test_email' )
		{
			define('SMTP_DEBUG', 1);
			//##send user email
			$url = parse_url(BASEURL);
			$body = sprintf(__("Hello %s<br/><br/>", 'users'), 'sinticbolivia') .
			sprintf(__('Thanks for register into our website, you account details are below.<br/><br/>', 'users')).
			sprintf(__('Username: %s<br/>', 'users'), 'sinticbolivia').
			sprintf(__('Password: %s<br/>', 'users'), 'sinticbolivia').
			'<br/>'.
			__('Follow the next link in order to start a session.<br/><br/>', 'users').
			sprintf(__('<a href="%s">Login</a><br/><br/>'), SB_Route::_('index.php?mod=users')).
			sprintf(__('Greetings<br/><br/>%s', 'users'), SITE_TITLE);
			$body = SB_Module::do_action('register_user_email_body', $body, 'sinticbolivia', 'sinticbolivia');
			$subject = SB_Module::do_action('register_user_email_subject', sprintf(__('%s - User Registration', 'users'), SITE_TITLE));
			$headers = array(
					'Content-Type: text/html; charset=utf-8',
					sprintf("From: %s <no-reply@%s>", SITE_TITLE, $url['host'])
			);
			$res = lt_mail('marce_nickya@yahoo.es', $subject, $body, $headers);
			var_dump($res);
		}
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuPage(__('HHRR Management', 'rrhh'), '#', 'rrhh-menu', 'rrhh_menu');
		SB_Menu::addMenuChild('rrhh-menu', __('Human Resource', 'rrhh'), SB_Route::_('index.php?mod=rrhh'), 'menu-rrhh-list', 'rrhh_menu');
		SB_Menu::addMenuChild('rrhh-menu', __('Announcements', 'rrhh'), SB_Route::_('index.php?mod=rrhh&view=announcements.default'), 'menu-rrhh-announcements', 'rrhh_menu');
		SB_Menu::addMenuChild('rrhh-menu', __('Study Levels', 'rrhh'), SB_Route::_('index.php?mod=rrhh&view=studylevels.default'), 'menu-rrhh-studylevels', 'rrhh_menu');
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