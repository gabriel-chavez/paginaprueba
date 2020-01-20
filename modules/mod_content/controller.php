<?php
class LT_ControllerContent extends SB_Controller
{
	public function task_default()
	{
		sb_include_module_helper('content');
		$dbh = SB_Factory::getDbh();
		$args = array();
		$args = SB_Module::do_action('default_content_query_args', $args);
		$data = LT_HelperContent::GetArticles($args);
		sb_set_view_var('articles', $data['articles']);
	}
	public function task_blog()
	{
		sb_include_module_helper('content');
		$dbh = SB_Factory::getDbh();
		$args = array(
				'type'	=> 'post'
		);
		$args = SB_Module::do_action('default_content_query_args', $args);
		$data = LT_HelperContent::GetArticles($args);
		sb_set_view_var('posts', $data['articles']);
	}
	public function task_article()
	{
		$id 	= 	SB_Request::getInt('id');
		$slug 	= SB_Request::getString('slug');
		
		if( !$id && !$slug )
		{
			sb_set_view('article-not-found');
			return false;
		}
		$article = new LT_Article($id ? $id : $slug);
		if( !$article->content_id )
		{
			SB_Module::do_action('before_article_not_found');
			sb_set_view('article-not-found');
			return false;
		}
		if( !$article->IsVisible() )
		{
			SB_Module::do_action('before_article_not_found');
			sb_set_view('article-not-found');
			return false;
		}
		if( file_exists(TEMPLATE_DIR . SB_DS . 'page.php') )
		{
			$this->document->templateFile = 'page.php';
		}
		//##check if page has assigned a template file
		if( $article->_template && strstr($article->_template, '.php') )
		{
			$this->document->templateFile = $article->_template;
		}
		sb_set_view_var('article', $article);
		$this->document->SetTitle($article->title);
		SB_Module::do_action('before_show_content', $article);
	}
	public function task_section()
	{
		$id 	= SB_Request::getInt('id');
		$slug	= SB_Request::getString('slug');
		if( !$id && !$slug )
		{
			sb_set_view('article-not-found');
			return false;
		}
		$section = new LT_Section($id ? $id : $slug);
		if( !$section->section_id )
		{
			sb_set_view('article-not-found');
			return false;
		}
		if( !$section->IsVisible() )
		{
			sb_set_view('article-not-found');
			return false;
		}
		sb_set_view_var('section', $section);
		sb_set_view_var('articles', $section->GetArticles());
		SB_Module::do_action('before_show_section', $section);
		$this->document->SetTitle($section->name);
	}
}