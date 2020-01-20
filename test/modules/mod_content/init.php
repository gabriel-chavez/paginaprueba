<?php
defined('BASEPATH') or die('Dont fuck with me');
define('MOD_CONTENT_DIR', dirname(__FILE__));
define('MOD_CONTENT_URL', MODULES_URL . '/' . basename(MOD_CONTENT_DIR));
define('MOD_CONTENT_BANNERS_DIR', UPLOADS_DIR . SB_DS . 'banners');
define('MOD_CONTENT_BANNERS_URL', UPLOADS_URL . '/banners');
define('MOD_CONTENT_BUTTONS_DIR', UPLOADS_DIR . SB_DS . 'buttons');
define('MOD_CONTENT_BUTTONS_URL', UPLOADS_URL . '/buttons');

require_once dirname(__FILE__) . SB_DS . 'functions.php';
require_once MOD_CONTENT_DIR . SB_DS . 'classes' . SB_DS . 'class.section.php';
require_once MOD_CONTENT_DIR . SB_DS . 'classes' . SB_DS . 'class.category.php';
require_once MOD_CONTENT_DIR . SB_DS . 'classes' . SB_DS . 'class.article.php';
is_dir(MOD_CONTENT_BANNERS_DIR) or mkdir(MOD_CONTENT_BANNERS_DIR);
is_dir(MOD_CONTENT_BUTTONS_DIR) or mkdir(MOD_CONTENT_BUTTONS_DIR);

SB_Module::add_action('before_init', array('SB_ContentHooks', 'action_before_init'));
SB_Module::add_action('init', array('SB_ContentHooks', 'action_init'));
SB_Module::add_action('admin_menu', array('SB_ContentHooks', 'action_admin_menu'));
SB_Module::add_action('admin_dashboard', array('SB_ContentHooks', 'action_admin_dashboard'));
if( !defined('LT_ADMIN') )
{
	//SB_Module::add_action('user_tabs', array('SB_ContentHooks', 'action_user_tabs'));
	//SB_Module::add_action('user_tabs_content', array('SB_ContentHooks', 'action_user_tabs_content'));
	SB_Module::add_action('rewrite_routes', array('SB_ContentHooks', 'Routes'));
}
class SB_ContentHooks
{
	public static function action_before_init()
	{
		
	}
	public static function action_init()
	{
		SB_Language::loadLanguage(LANGUAGE, 'content', MOD_CONTENT_DIR . SB_DS . 'locale');
		lt_content_register_content_types();
		self::RegisterShortcodes();
	}
	public static function action_admin_menu()
	{
		SB_Menu::addMenuPage(SB_Text::_('Contents', 'content'), __('index.php?mod=content'), 'menu-content', 'manage_content', 1);
		SB_Menu::addMenuChild('menu-content',
				'<span class="glyphicon glyphicon-pencil"></span>'.__('Pages', 'content'), SB_Route::_('index.php?mod=content'), 'menu-articles', 'manage_content');
		SB_Menu::addMenuChild('menu-content',
				'<span class="glyphicon glyphicon-folder-open"></span>'.SB_Text::_('Sections', 'content'), SB_Route::_('index.php?mod=content&view=section.default'), 'menu-sections', 'manage_content');
		
		//##add menu for blog entries (posts)
		SB_Menu::addMenuPage(__('Blog', 'content'), SB_Route::_('index.php?mod=content&view=posts.default'), 'menu-posts', 'manage_posts');
		SB_Menu::addMenuChild('menu-posts', __('Posts', 'content'), SB_Route::_('index.php?mod=content&view=default&type=post'), 'submenu-posts', 'manage_posts');
		SB_Menu::addMenuChild('menu-posts', __('Categories', 'content'), SB_Route::_('index.php?mod=content&view=categories.default'), 'submenu-categories', 'manage_post_categories');
	}
	public static function action_admin_dashboard()
	{
		$dbh = SB_Factory::getDbh();
		$query = "SELECT COUNT(*) AS total FROM section";
		$dbh->Query($query);
		$sections = (int)$dbh->FetchRow()->total; 
		$query = "SELECT COUNT(*) AS total FROM content";
		$dbh->Query($query);
		$articles = (int)$dbh->FetchRow()->total;
		?>
		<div class="span6 col-md-6">
			<div class="widget">
				<div class="widget-header">
					<i class="icon-list-alt"></i>
					<h3><?php print SB_Text::_('Estadisticas de Contenido', 'content')?></h3>
				</div>
				<div class="widget-content">
					<div id="big_stats">
						<div class="stat">
							<span class="value"><?php print $sections; ?></span>
							<span class="text"><?php print SB_Text::_('Secciones', 'content'); ?></span>
							<div class="text-center">
								<a href="<?php print SB_Route::_('index.php?mod=content&view=section.default'); ?>" class="btn btn-default">
									<?php print SBText::_('Ver listado', 'content'); ?>
								</a>
							</div>
						</div>
						<div class="stat">
							<span class="value"><?php print $articles; ?></span>
							<span class="text"><?php print SB_Text::_('Contenidos', 'content'); ?></span>
							<div class="text-center">
								<a href="<?php print SB_Route::_('index.php?mod=content'); ?>" class="btn btn-default">
									<?php print SBText::_('Ver listado', 'content'); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php 
	}
	public static function action_user_tabs($user)
	{
		?>
		<li><a href="#my-content"><?php print SB_Text::_('Mi Contenido', 'content'); ?></a></li>
		<?php
	}
	public static function action_user_tabs_content($user)
	{
		require_once MOD_CONTENT_DIR . SB_DS . 'html' . SB_DS . 'my-content.php';
	}
	public static function RegisterShortcodes()
	{
		SB_Shortcode::AddShortcode('article_btn', 'SB_ContentHooks::shortcode_article_btn');
		SB_Shortcode::AddShortcode('section_btn', 'SB_ContentHooks::shortcode_section_btn');
	}
	public static function shortcode_section_btn($args)
	{
		if( !isset($args['id']) )
			return null;
		$section = new LT_Section((int)$args['id']);
		$style = 'style="';
		
		if( isset($args['bg_color']) )
		{
			$style .= "background-color:{$args['bg_color']};";
		}
		elseif( $section->_btn_bg_color )
		{
			$style .= "background-color:{$section->_btn_bg_color};";
		}
		
		if( isset($args['color']) )
		{
			$style .= "color:{$args['color']};";
		}
		elseif( $section->_btn_fg_color )
		{
			$style .= "color:{$section->_btn_fg_color};";
		}
		$style .= '"';
		if( $style == 'style=""' ) $style = '';
		
		$attrs = sprintf("%s %s", '', !empty($style) ? $style : '');
		return '<a href="'.SB_Route::_('index.php?mod=content&view=section&id='.$section->section_id).'" class="btn btn-default" '.$attrs.'>'.
				$section->name.'</a>';
	}
	public static function shortcode_article_btn($args)
	{
		if( !isset($args['id']) )
			return null;
		$article = new LT_Article($args['id']);
		$style = 'style="';
	
		if( isset($args['bg_color']) )
		{
			$style .= "background-color:{$args['bg_color']};";
		}
		elseif( $article->_btn_bg_color )
		{
			$style .= "background-color:{$article->_btn_bg_color};";
		}
	
		if( isset($args['color']) )
		{
			$style .= "color:{$args['color']};";
		}
		elseif( $article->_btn_fg_color )
		{
			$style .= "color:{$article->_btn_fg_color};";
		}
		$style .= '"';
		if( $style == 'style=""' ) $style = '';
	
		$attrs = sprintf("%s %s", '', !empty($style) ? $style : '');
		return '<a href="'.SB_Route::_('index.php?mod=content&view=article&id='.$article->content_id).'" class="btn btn-default" '.$attrs.'>'.
				$article->title.'</a>';
	}
	public static function Routes($routes)
	{
		//$routes['/^\/(.*)\/?/'] = 'mod=content&view=article&slug=$1';
		$routes['/^\/([0-9a-zA-Z-_]+)\/?$/'] = 'mod=content&view=article&slug=$1';
		$routes['/^\/'.__('section', 'content').'\/([a-zA-Z-_]+)\/?$/'] = 'mod=content&view=section&slug=$1';
		return $routes;
	}
}
