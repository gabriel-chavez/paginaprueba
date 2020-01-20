<?php
class LT_AdminControllerContent extends SB_Controller
{
	public function task_default()
	{
		global $content_types;
		
		if( !sb_get_current_user()->can('manage_content') )
		{
			die('You dont have enough permissions to manage contents');
		}
		$keyword	= SB_Request::getString('keyword');
		$type 		= SB_Request::getString('type', 'page');
		$order_by 	= SB_Request::getString('order_by', 'creation_date');
		$order		= SB_Request::getString('order', 'desc');
		$page		= SB_Request::getInt('page', 1);
		$limit		= SB_Request::getInt('limit', defined('ITEMS_PER_PAGE') ? ITEMS_PER_PAGE : 25);
		
		if( !isset($content_types[$type]) )
		{
			lt_die(sprintf(__('The content type "%s" does not exists', 'content'), $type));
		}
		$dbh = SB_Factory::getDbh();
		$query = "SELECT {columns} FROM content c ";
		$where = "WHERE (c.`type` = '$type' OR c.`type` IS NULL OR c.`type` = '')";
		$order_query = "ORDER BY $order_by $order";
		//##check if there is a search
		if( $keyword )
		{
			$where .= "AND title LIKE '%$keyword%' ";
		}
		//##get total rows
		$dbh->Query(str_replace('{columns}', 'COUNT(*) AS total_rows', "$query $where"));
		$total_rows = $dbh->FetchRow()->total_rows;
		$total_pages = ceil($total_rows / $limit);
		$offset = ($page <= 1) ? 0 : ($page - 1) * $limit;
		$limit_query = "LIMIT $offset, $limit";
		$columns = "c.*, CONCAT(u.first_name, ' ', u.last_name) AS author";
		$left_join = "LEFT JOIN users u ON c.author_id = u.user_id ";
		$query = str_replace('{columns}', $columns, $query) . " $left_join $where $order_query $limit_query";
		//var_dump($query);
		$dbh->Query($query);
		$contents = array();
		foreach($dbh->FetchResults() as $row)
		{
			$a = new LT_Article();
			$a->SetDbData($row);
			$a->GetDbSections();
			$contents[] = $a;
		}
		
		$new_order = $order == 'asc' ? 'desc' : 'asc';
		sb_set_view_var('title', $content_types[$type]['labels']['listing_label']);
		sb_set_view_var('id_order_link', SB_Route::_('index.php?mod=content&order_by=content_id&order='.$new_order));
		sb_set_view_var('title_order_link', SB_Route::_('index.php?mod=content&order_by=title&order='.$new_order));
		sb_set_view_var('author_order_link', SB_Route::_('index.php?mod=content&order_by=author&order='.$new_order));
		sb_set_view_var('date_order_link', SB_Route::_('index.php?mod=content&order_by=creation_date&order='.$new_order));
		sb_set_view_var('order_link', SB_Route::_('index.php?mod=content&order_by=show_order&order='.$new_order));
		sb_set_view_var('contents', $contents);
		sb_set_view_var('total_pages', $total_pages);
		sb_set_view_var('current_page', $page);
		
		$this->GetDocument()->SetTitle(SBText::_("Contenidos", 'content'));
	}
	public function task_new()
	{
		global $content_types;
		
		if( !sb_get_current_user()->can('manage_content') )
		{
			die('You dont have enough permissions');
		}
		if( !sb_get_current_user()->can('create_content') )
		{
			die('You dont have enough permissions');
		}
		$type = SB_Request::getString('type', 'page');
		//$data = parse_url(BASEURL);
		sb_include_module_helper('content');
		sb_add_script(BASEURL . '/js/fineuploader/all.fine-uploader.min.js', 'fineuploader');
		//sb_add_script(BASEURL . '/js/tinymce/tinymce.min.js', 'tinymce');
		lt_add_tinymce();
		sb_set_view_var('title', $content_types[$type]['labels']['new_label']);
		sb_set_view_var('image_url', null);
		sb_set_view_var('remove_banner_link', SB_Route::_('index.php?mod=content&task=remove_banner&id=temp'));
		sb_set_view_var('upload_endpoint', SB_Route::_('index.php?mod=content&task=upload_banner'));
		sb_set_view_var('sections', LT_HelperContent::GetSections());
		sb_set_view_var('type', $type);
		sb_set_view_var('features', $content_types[$type]['features']);
	}
	public function task_edit()
	{
		global $content_types;
		
		if( !sb_get_current_user()->can('manage_content') )
		{
			die('You dont have enough permissions');
		}
		if( !sb_get_current_user()->can('edit_content') )
		{
			die('You dont have enough permissions');
		}
		$article_id = SB_Request::getInt('id');
		if( !$article_id )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('Identificador de articulo no valido.', 'content'), 'error');
			return false;
		}
		$article = new LT_Article($article_id);
		if( !$article->content_id )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('El articulo no existe.', 'content'), 'error');
			return false;
		}
		$image_url = null;
		$remove_banner_link = SB_Route::_('index.php?mod=content&task=remove_banner&id='.$article->content_id);
		if( $article->_banner )
		{
			$image_url = MOD_CONTENT_BANNERS_URL . SB_DS . $article->_banner;
			if( !file_exists(MOD_CONTENT_BANNERS_DIR . SB_DS . $article->_banner) )
			{
				$image_url = null;
			}
		}
		sb_set_view('new');
		//sb_add_script(BASEURL . '/js/tinymce/tinymce.min.js', 'tinymce');
		lt_add_tinymce();
		sb_add_script(BASEURL . '/js/fineuploader/all.fine-uploader.min.js', 'fineuploader');
		sb_set_view_var('upload_endpoint', SB_Route::_('index.php?mod=content&task=upload_banner&id='.$article->content_id));
		sb_set_view_var('title', $content_types[$article->type]['labels']['edit_label']);
		sb_set_view_var('image_url', $image_url);
		sb_set_view_var('remove_banner_link', $remove_banner_link);
		sb_set_view_var('content', $article);
		sb_set_view_var('type', $article->type);
		sb_set_view_var('features', $content_types[$article->type]['features']);
		$this->document->SetTitle(SBText::_('Editar contenido', 'content'));
		
	}
	public function task_save()
	{
		if( !sb_get_current_user()->can('manage_content') )
		{
			die('You dont have enough permissions');
		}
		$article_id 	= SB_Request::getInt('article_id');
		$title 			= SB_Request::getString('title');
		$content 		= SB_Request::getString('content');
		$sections 		= (array)SB_Request::getVar('section', array());
		$status			= SB_Request::getString('status', 'publish');
		$type			= SB_Request::getString('type', 'page');
		$lang			= SB_Request::getVar('lang', LANGUAGE);
		//var_dump($lang);die(LANGUAGE);
		if( !$article_id && !sb_get_current_user()->can('create_content') )
		{
			die('You dont have enough permissions');
		}
		if( $article_id && !sb_get_current_user()->can('edit_content') )
		{
			die('You dont have enough permissions');
		}
		
		if( empty($title) )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('Debe ingresar un titulo para el contenido.', 'content'), 'error');
			if( $article_id )
				$this->task_edit();
			else 
				$this->task_new();
			return false;
		}
		$cdate 			= date('Y-m-d H:i:s');
		$publish_date 	= SB_Request::getString('publish_date', '1982-01-01 00:00:00');
		$end_date 		= SB_Request::getString('end_date', '1982-01-01 00:00:00');
		$publish_time 	= strtotime($publish_date);
		$end_time 		= strtotime($end_date);
		if( $end_time <= $publish_time )
		{
			$end_date = date(DATE_FORMAT, strtotime(date('Y')+35 . '-01-01'));
			$end_time = strtotime($end_date);
		}
		$data = array(
				'title'						=> $title,
				'content'					=> $content,
				'slug'						=> sb_build_slug($title),
				'status'					=> $status,
				'type'						=> SB_Request::getString('type', 'page'),//contablex1$
				'publish_date'				=> date('Y-m-d H:i:s', $publish_time),
				'end_date'					=> date('Y-m-d H:i:s', $end_time),
				'lang_code'					=> $lang,
				'last_modification_date'	=> $cdate
		);
		$msg = SB_Text::_('Nuevo contenido creado.', 'content');
		$link = SB_Route::_('index.php?mod=content&type='.$data['type']);
		$dbh = SB_Factory::getDbh();
		//##check if the article is new
		if( !$article_id )
		{
			$data['author_id'] 		= sb_get_current_user()->user_id;
			$data['creation_date'] 	= $cdate;
			$article_id 			= $dbh->Insert('content', $data);
			//##check for banners
			if( $banner = SB_Session::getVar('new_article_banner') )
			{
				sb_add_content_meta($article_id, '_banner', $banner);
			}
		}
		else
		{
			$dbh->Update('content', $data, array('content_id' => $article_id));
			$msg = SB_Text::_('Contenido actualizado.', 'content');
			$link = SB_Route::_('index.php?mod=content&view=edit&id='.$article_id);
		}
		$calculated_date 		= SB_Request::getint('calculated_date', 0);
		$end_calculated_date 	= SB_Request::getInt('end_calculated_date', 0);
		$calculated_date		= ($calculated_date < 0) ? 0 : $calculated_date;
		$end_calculated_date	= ($end_calculated_date < 0) ? 0 : $end_calculated_date;
		/*
		if( $end_calculated_date <= $calculated_date )
		{
			$end_calculated_date = $calculated_date + 1;
		}
		*/
		sb_update_content_meta($article_id, '_use_calculated', SB_Request::getint('use_calculated'));
		sb_update_content_meta($article_id, '_calculated_date', $calculated_date);
		sb_update_content_meta($article_id, '_end_calculated_date', $end_calculated_date);
		sb_update_content_meta($article_id, '_btn_bg_color', SB_Request::getString('btn_bg_color', '#000'));
		sb_update_content_meta($article_id, '_btn_fg_color', SB_Request::getString('btn_fg_color', '#000'));
		sb_update_content_meta($article_id, '_user_button_instead', SB_Request::getInt('user_button_instead', 0));
		sb_update_content_meta($article_id, '_in_frontpage', SB_Request::getInt('in_frontpage', 0));
		
		foreach((array)SB_Request::getVar('meta') as $key => $value)
		{
			sb_update_content_meta($article_id, trim($key), trim($value));
		}
		if( $img = SB_Session::getVar('new_article_button_image') )
		{
			sb_update_content_meta($article_id, '_button_image', $img);
		}
		if( is_array($sections) && count($sections) )
		{
			if( $type == 'page' ):
				$dbh->Query("DELETE FROM section2content WHERE content_id = $article_id");
				//##add article sections
				$insert = "INSERT INTO section2content(section_id,content_id) VALUES";
				foreach($sections as $sid)
				{
					$insert .= "($sid, $article_id),";
				}
				//print_r($insert);die();
				$dbh->Query(rtrim($insert, ','));
			else:
				$dbh->Query("DELETE FROM category2content WHERE content_id = $article_id");
				//##add article sections
				$insert = "INSERT INTO category2content(category_id,content_id) VALUES";
				foreach($sections as $sid)
				{
					$insert .= "($sid, $article_id),";
				}
				$dbh->Query(rtrim($insert, ','));
			endif;
		}
		
		SB_Module::do_action('save_article', $article_id);
		SB_MessagesStack::AddMessage($msg, 'success');
		sb_redirect($link);
	}
	public function task_delete()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('Identificador de contenido no valido.'), 'error');
			sb_redirect(sb_redirect('index.php?mod=content'));
		}
		$dbh = SB_Factory::getDbh();
		$query = "DELETE FROM content_meta WHERE content_id = $id";
		$dbh->Query($query);
		$query = "DELETE FROM content WHERE content_id = $id LIMIT 1";
		$dbh->Query($query);
		SB_MessagesStack::AddMessage(SB_Text::_('Contenido borrado.'), 'success');
		sb_redirect(sb_redirect('index.php?mod=content'));
	}
	public function task_upload_banner()
	{
		$id = SB_Request::getInt('id');
		sb_include('qqFileUploader.php', 'file');
		$uh = new qqFileUploader();
		$uh->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
		// Specify max file size in bytes.
		//$uh->sizeLimit = 10 * 1024 * 1024; //10MB
		// Specify the input name set in the javascript.
		$uh->inputName = 'qqfile';
		// If you want to use resume feature for uploader, specify the folder to save parts.
		$uh->chunksFolder = 'chunks';
		$res = $uh->handleUpload(MOD_CONTENT_BANNERS_DIR);
		$file_path = MOD_CONTENT_BANNERS_DIR. SB_DS . $uh->getUploadName();
		/*
		sb_include('class.image.php');
		$img = new SB_Image($file_path);
		//if( $img->getWidth() > 150 || $img->getHeight() > 150)
		{
			$img->resizeImage(150, 150);
			$img->save($file_path);
		}
		*/
		$res['uploadName'] = $uh->getUploadName();
		$res['image_url'] = MOD_CONTENT_BANNERS_URL. '/' . $res['uploadName'];
		if( $id )
		{
			$banner = sb_get_content_meta($id, '_banner');
			if( $banner && file_exists(MOD_CONTENT_BANNERS_DIR . SB_DS . $banner) )
			{
				unlink(MOD_CONTENT_BANNERS_DIR . SB_DS . $banner);
			}
			sb_update_content_meta($id, '_banner', $res['uploadName']);
		}
		else
		{
			SB_Session::setVar('new_article_banner', $res['uploadName']);
		}
		die(json_encode($res));
	}
	public function task_remove_banner()
	{
		$id = SB_Request::getString('id');
		
		if( is_numeric($id) )
		{
			var_dump($id);
			$banner_file = MOD_CONTENT_BANNERS_DIR . SB_DS . sb_get_content_meta($id, '_banner');
			file_exists($banner_file) && unlink($banner_file);
			sb_update_content_meta($id, '_banner', '');
		}
		elseif( $id == 'temp' )
		{
			$banner_file = MOD_CONTENT_BANNERS_DIR . SB_DS . SB_Session::getVar('new_article_banner');
			file_exists($banner_file) && unlink($banner_file);
			SB_Session::unsetVar('new_article_banner');
		}
		die();
	}
	public function task_upload_button_image()
	{
		ini_set('display_errors', 1);error_reporting(E_ALL);
		$id = SB_Request::getInt('id');
		sb_include('qqFileUploader.php', 'file');
		$uh = new qqFileUploader();
		$uh->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
		// Specify max file size in bytes.
		//$uh->sizeLimit = 10 * 1024 * 1024; //10MB
		// Specify the input name set in the javascript.
		$uh->inputName = 'qqfile';
		// If you want to use resume feature for uploader, specify the folder to save parts.
		$uh->chunksFolder = 'chunks';
		$res = $uh->handleUpload(MOD_CONTENT_BUTTONS_DIR);
		if( isset($res['error']) )
		{
			sb_response_json($res);
		}
		$file_path = MOD_CONTENT_BUTTONS_DIR . SB_DS . $uh->getUploadName();
		//##resize image
		sb_include('class.image.php');
		$img = new SB_Image($file_path);
		if( $img->getWidth() > 300 || $img->getHeight() > 200)
		{
			$img->resizeImage(300, 200);
			$img->save($file_path);
		}
		
		$res['uploadName'] = $uh->getUploadName();
		$res['image_url'] = MOD_CONTENT_BUTTONS_URL . '/' . $res['uploadName'];
		if( $id )
		{
			$img = sb_get_content_meta($id, '_button_image');
			if( $img && file_exists(MOD_CONTENT_BUTTONS_DIR . SB_DS . $img) )
			{
				@unlink(MOD_CONTENT_BUTTONS_DIR . SB_DS . $img);
			}
			sb_update_content_meta($id, '_button_image', $res['uploadName']);
		}
		else
		{
			if( $img = SB_Session::getVar('new_article_button_image') )
			{
				@unlink(MOD_CONTENT_BUTTONS_DIR . SB_DS . $img);
			}
			SB_Session::setVar('new_article_button_image', $res['uploadName']);
		}
		sb_response_json($res);
	}
	public function task_remove_button_image()
	{
		$id = SB_Request::getString('id');
		
		if( (int)$id )
		{
			$file = MOD_CONTENT_BUTTONS_DIR . SB_DS . sb_get_content_meta($id, '_button_image');
			if( file_exists($file) ) 
				unlink($file);
			sb_update_content_meta($id, '_button_image', null);
		}
		elseif( $id == 'temp' )
		{
			$file = MOD_CONTENT_BUTTONS_DIR . SB_DS . SB_Session::getVar('new_article_button_image');
			file_exists($banner_file) && unlink($banner_file);
			SB_Session::unsetVar('new_article_button_image');
		}
		die();
	}
	public function task_change_order()
	{
		$id = SB_Request::getInt('id');
		$order = SB_Request::getInt('order');
		$dbh = SB_Factory::getDbh();
		$dbh->Update('content', array('show_order' => $order), array('content_id' => $id));
		SB_MessagesStack::AddMessage(SBText::_('El orden se cambio correctamente.', 'content'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=content'));
	}
	public function task_wpimport()
	{
		if( !sb_is_user_logged_in() )
		{
			lt_die(__('You cant do this', 'content'));
		}
		if( !sb_get_current_user()->can('import') )
		{
			lt_die(__('You cant do this', 'content'));
		}
		set_time_limit(0);
		sb_include('class.wp-importer.php');
		$wpi = new LT_WordpressImporter(BASEPATH . SB_DS . 'sinticbolivia.xml'); 
		$wpi->ImportPosts();
		die();
	}
	public function task_upload_featured_image()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			sb_response_json(array('success' => false, 'error' => __('Identificador de contenido invalido', 'content')));
		}
		
		sb_include('qqFileUploader.php', 'file');
		$uh = new qqFileUploader();
		$uh->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
		// Specify the input name set in the javascript.
		$uh->inputName = 'qqfile';
		// If you want to use resume feature for uploader, specify the folder to save parts.
		$uh->chunksFolder = 'chunks';
		$res = $uh->handleUpload(UPLOADS_DIR);
		if( isset($res['error']) )
		{
			sb_response_json($res);
		}
		$file_path = UPLOADS_DIR . SB_DS . $uh->getUploadName();
		//##resize image
		sb_include('class.image.php');
		$img = new SB_Image($file_path);
		//##save source image
		$img->save($file_path);
		//##resize the image
		if( $img->getWidth() > 300 || $img->getHeight() > 300)
		{
			$ext 	= sb_get_file_extension(basename($file_path));
			$medium = str_replace('.' . $ext, '', $file_path) . "-300x300.$ext";
			$img->resizeImage(300, 300);
			$img->save($medium);
			$res['thumbnail_url']	= UPLOADS_URL . '/' . basename($medium);
		}
		else
		{
			$res['thumbnail_url']	= UPLOADS_URL . '/' . $uh->getUploadName();
		}
		$res['uploadName'] = $uh->getUploadName();
		$res['image_url'] = UPLOADS_URL . '/' . $res['uploadName'];
		
		$img = sb_get_content_meta($id, '_featured_image');
		if( $img && file_exists(UPLOADS_DIR . SB_DS . $img) )
		{
			@unlink(UPLOADS_DIR . SB_DS . $img);
			@unlink(UPLOADS_DIR . SB_DS . sb_get_content_meta($id, '_featured_image_full'));
		}
		sb_update_content_meta($id, '_featured_image', basename($res['thumbnail_url']));
		sb_update_content_meta($id, '_featured_image_full', basename($res['uploadName']));
		
		sb_response_json($res);
	}
	public function task_delete_featured_image()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			sb_response_json(array('status' => 'error', 'error' => __('Identificador de contenido invalido', 'content')));
		}
		@unlink(UPLOADS_DIR . SB_DS . sb_get_content_meta($id, '_featured_image'));
		@unlink(UPLOADS_DIR . SB_DS . sb_get_content_meta($id, '_featured_image_full'));
		
		sb_update_content_meta($id, '_featured_image', null);
		sb_update_content_meta($id, '_featured_image_full', null);
		
		sb_response_json(array('status' => 'ok', 'message' => __('Imagen destacada borrada', 'content')));
	}
}