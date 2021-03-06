<?php
class LT_AdminControllerUsers extends SB_Controller
{
	public function task_default()
	{
		if (!sb_get_current_user()->can('manage_users')) {
			die('You dont have enough permissions');
		}
		$keyword = SB_Request::getString('keyword');

		$dbh = SB_Factory::getDbh();
		$columns = array(
			'u.*, CONCAT(u.first_name, \' \', u.last_name) AS name',
			'r.role_name',
			'r.role_key'
		);
		$tables = array(
			'users u LEFT JOIN user_roles r ON u.role_id = r.role_id',
			//'user_roles r'
		);
		$where = array(
			"(username <> 'root' OR username is null)",
			//'u.role_id = r.role_id'
		);
		if ($keyword) {
			$where[] = "u.username LIKE '%$keyword%'";
		}
		//##if user is different than root, just get their users
		if (sb_get_current_user()->role_id !== 0) {
			$tables[] = 'user_meta um';
			$where[] = 'u.user_id = um.user_id';
			$where[] = 'um.meta_key = "_owner_id"';
			$where[] = 'um.meta_value = "' . sb_get_current_user()->user_id . '"';
		}
		$order = SB_Request::getString('order', 'desc');
		$order_by = SB_Request::getString('order_by', 'creation_date');
		$query = sprintf(
			"SELECT %s FROM %s WHERE %s ORDER BY %s $order",
			implode(',', $columns),
			implode(',', $tables),
			implode(' AND ', $where),
			$order_by
		);
		$res = $dbh->Query($query);
		$users = $dbh->FetchResults();

		$new_order = $order == 'desc' ? 'asc' : 'desc';
		$username_order_link 	= 'index.php?mod=users&order_by=username&order=' . $new_order;
		$name_order_link 		= 'index.php?mod=users&order_by=name&order=' . $new_order;
		$email_order_link		= 'index.php?mod=users&order_by=email&order=' . $new_order;
		$rol_order_link		= 'index.php?mod=users&order_by=role_name&order=' . $new_order;
		sb_set_view_var('questions', sb_get_security_questions());
		sb_set_view_var('username_order_link', SB_Route::_($username_order_link));
		sb_set_view_var('name_order_link', SB_Route::_($name_order_link));
		sb_set_view_var('email_order_link', SB_Route::_($email_order_link));
		sb_set_view_var('rol_order_link', SB_Route::_($rol_order_link));
		sb_set_view_var('users', $users);
	}
	public function task_do_login()
	{
		$captcha = '';
		if (isset($_POST['g-recaptcha-response']))
			$captcha = $_POST['g-recaptcha-response'];
		// echo 'captcha: '.$captcha;

		// if (!$captcha)
		//     echo 'The captcha has not been checked.';
		// handling the captcha and checking if it's ok
	//	$secret = '6Ldn6MYUAAAAALTqLrJmYi3d4UW-oLvJNKuX0YG3';
		$secret = '6Lf8YMgUAAAAAFasWagBbAjJnSKcXl8Fls3lY0I-';

		$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);

		//var_dump($response);

		// if the captcha is cleared with google, send the mail and echo ok.
		if ($response['success'] != false) {
			// send the actual mail

			$this->_login();
			// the echo goes back to the ajax, so the user can know if everything is ok        
		} else {
			$msg = SBText::_('debe seleccionar el recaptcha.', 'users');			
				sb_response_json(array('status' => 'error', 'error' => $msg));
		}
	}
	public function _login()
	{

		$captcha 		= SB_Session::getVar('login_captcha');
		$user_captcha	= SB_Request::getString('captcha', null);
		$username 		= SB_Request::getString('username');
		$pwd			= SB_Request::getString('pwd');
		$ajax			= SB_Request::getInt('ajax');
		$redirect		= SB_Request::getString('redirect');
		$dbh 			= SB_Factory::getDbh();
		$username 		= $dbh->EscapeString($username);

		$query 			= "SELECT u.*,r.role_key " .
			"FROM users u " .
			"LEFT JOIN user_roles r ON r.role_id = u.role_id " .
			"WHERE u.username = '$username' LIMIT 1";
		$rows 			= $dbh->Query($query);

		$captcha		= substr($captcha, 3) . substr($captcha, 0, 3);
		$error_link 	= SB_Route::_('index.php');
		if ($ajax)
			sleep(1);
		//var_dump("if( $captcha && $user_captcha != $captcha  )");die(__FILE__);

		if ($captcha && $user_captcha != $captcha) {
			$msg = SBText::_('Texto de seguridad invalido.', 'users');
			if ($ajax)
				sb_response_json(array('status' => 'error', 'error' => $msg));
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		if ($rows <= 0) {
			$msg = SBText::_('Usuario o contrase&ntilde;a invalida', 'users');
			if ($ajax)
				sb_response_json(array('status' => 'error', 'error' => $msg));
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		$row = $dbh->FetchRow();

		if ($row->pwd != md5($pwd)) {
			$msg = SBText::_('Usuario o contrase&ntilde;a invalida', 'users');
			if ($ajax)
				sb_response_json(array('status' => 'error', 'error' => $msg));
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		if ($row->role_id !== 0) {
			if ($row->role_key == 'possible' || $row->role_key == 'bloqued') {
				$msg = SBText::_('El usuario no puede iniciar sesion.', 'users');
				if ($ajax)
					sb_response_json(array('status' => 'error', 'error' => $msg));
				SB_MessagesStack::AddMessage($msg, 'error');
				return false;
			}
		}
		$session = SB_Module::do_action('authenticate_session', true);
		if (!$session) {
			if ($ajax)
				sb_response_json(array('status' => 'error', 'error' => __('Authentication failed', 'users')));
			sb_redirect($error_link);
		}
		//var_dump(defined('LT_ADMIN'));print_r($row);die();
		$cookie_name = '';
		if (defined('LT_ADMIN')) {
			SB_Session::setVar('admin_user', $row);
			$cookie_name = 'lt_session_admin';
		} else {
			SB_Session::setVar('user', $row);
			$cookie_name = 'lt_session';
		}
		$cookie_value = md5(serialize($row) . ':' . session_id());
		/*
		if( isset($_COOKIE[$cookie_name]) )
		{
			unset($_COOKIE[$cookie_name]);
			setcookie($cookie_name, '', time() - 3600);
		}
		*/
		SB_Session::setVar($cookie_name, $cookie_value);
		SB_Session::setVar('admin_timeout', time());
		//setcookie($cookie_name, $cookie_value, time() + (15 * 60), '/');
		$redirect = empty($redirect) ? SB_Route::_('index.php') : $redirect;
		$res = array('status' => 'ok', 'redirect' => $redirect);
		//var_dump($res);
		if ($ajax)
			sb_response_json($res);
		sb_redirect($redirect);
	}
	public function task_logout()
	{
		$cookie_name = null;
		if (defined('LT_ADMIN')) {
			SB_Session::unsetVar('admin_user');
			$cookie_name = 'lt_session_admin';
		} else {
			SB_Session::unsetVar('user');
			$cookie_name = 'lt_session';
		}
		SB_Session::unsetVar($cookie_name);
		//unset($_COOKIE[$cookie_name]);
		//setcookie($cookie_name, '', time() - 3600);
		sb_redirect(SB_Route::_('login.php'));
	}
	public function task_new_user()
	{
		if (!sb_get_current_user()->can('create_user')) {
			die('You dont have enough permissions');
		}
		sb_include_module_helper('users');
		$user = sb_get_current_user();
		$roles = array();
		foreach (LT_HelperUsers::GetUserRoles() as $r) {
			if (!$user->can('create_role_' . $r->role_key)) continue;
			$roles[] = $r;
		}
		$this->document->SetTitle(__('Crear Nuevo Usuario', 'users'));
		sb_set_view('edit_user');
		sb_add_script(BASEURL . '/js/fineuploader/all.fine-uploader.min.js', 'fineuploader');
		sb_set_view_var('upload_endpoint', SB_Route::_('index.php?mod=users&task=upload_image'));
		sb_set_view_var('roles', $roles);
		sb_set_view_var('title', SB_Text::_('Crear Nuevo Usuario', 'users'));
		SB_Module::do_action('on_create_new_user');
	}
	public function task_edit_user()
	{
		$user = sb_get_current_user();
		$user_id = SB_Request::getInt('id');
		if (!$user_id) {
			SB_MessagesStack::AddMessage(SB_Text::_('Identificador de usuario no valido'), 'users');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		if ($user->user_id != $user_id && !$user->can('edit_user')) {
			lt_die(__('You dont have enough permissions', 'users'));
		}


		sb_include_module_helper('users');
		$user 	= new SB_User($user_id);
		if (!$user->user_id) {
			SB_MessagesStack::AddMessage(SB_Text::_('El usuario no existe'), 'users');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$c_user = sb_get_current_user();
		if ($c_user->user_id != $user_id && $c_user->role_id !== 0 && $c_user->user_id != $user->_owner_id) {
			SB_MessagesStack::AddMessage(SB_Text::_('No puede editar el usuario solicitado.', 'users'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$roles = array();
		foreach (LT_HelperUsers::GetUserRoles() as $r) {
			if (!$c_user->can('create_role_' . $r->role_key)) continue;
			$roles[] = $r;
		}
		//##add just the current user role
		if (empty($roles)) {
			$roles[] = new SB_Role($c_user->role_id);
		}
		$this->document->SetTitle(__('Editar Usuario', 'users'));
		sb_add_script(BASEURL . '/js/fineuploader/all.fine-uploader.min.js', 'fineuploader');
		sb_set_view_var('user_id', $user_id);
		sb_set_view_var('user', $user);
		sb_set_view_var('roles', $roles);
		sb_set_view_var('user_dir', UPLOADS_DIR . SB_DS . sb_build_slug($user->username));
		sb_set_view_var('user_url', UPLOADS_URL . '/' . sb_build_slug($user->username));
		sb_set_view_var('title', SB_Text::_('Editar Usuario', 'users'));
		sb_set_view_var('upload_endpoint', SB_Route::_('index.php?mod=users&task=upload_image&user_id=' . $user_id));
	}
	public function task_save_user()
	{
		$user_id 		= SB_Request::getInt('user_id');
		$role_id 		= SB_Request::getInt('role_id');
		$first_name		= SB_Request::getString('first_name');
		$last_name 		= SB_Request::getString('last_name');
		$username		= SB_Request::getString('username');
		$email			= SB_Request::getString('email');
		$pwd			= SB_Request::getString('pwd');
		$notes			= SB_Request::getString('notes');
		$observations	= SB_Request::getString('observations');
		$image_file		= SB_Request::getString('imagefile');
		$user_dir		= UPLOADS_DIR . SB_DS . sb_build_slug($email);

		if (!sb_is_user_logged_in()) {
			sb_redirect(SB_Route::_('index.php'));
		}
		$current_user = sb_get_current_user();
		//##check if current user is updated its profile
		if ((int) $current_user->user_id !== (int) $user_id && !$current_user->can('manage_users')) {
			lt_die(__('You dont have enough permissions', 'users'));
		}

		sb_set_view('edit_user');
		sb_set_view_var('title', $user_id ? SB_Text::_('Editar Usuario', 'users') : SB_Text::_('Crear Nuevo Usuario', 'users'));
		if (empty($first_name)) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage(SBText::_('Debe ingresar los nombres.', 'users'), 'error');
			return false;
		}
		if (empty($last_name)) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage(SBText::_('Debe ingresar los apellidos.', 'users'), 'error');
			return false;
		}
		if (empty($username)) {
			if (!$user_id) {
				SB_MessagesStack::AddMessage('Debe ingresar un nombre de usuario.', 'error');
				return false;
			}
		}
		/*
		if( empty($email) )
		{
			if( $user_id )
			{
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage('Debe ingresar el email.', 'error');
			return false;
		}
		*/
		if (sb_get_current_user()->role_id > 0 && (!$role_id || $role_id <= 0)) {
			SB_MessagesStack::AddMessage(SBText::_('Debe seleccionar un rol para el usuario.', 'users'), 'error');
			if ($user_id) {
				$this->task_edit_user();
			} else {
				$this->task_new_user();
			}
			return false;
		}
		if ((int) $current_user->user_id !== (int) $user_id) {
			if (!$user_id && !sb_get_current_user()->can('create_user')) {
				lt_die(__('You dont have enough permissions to create an user', 'users'));
			}
			if ($user_id && !sb_get_current_user()->can('edit_user')) {
				lt_die(__('You dont have enough permissions to update an user', 'users'));
			}
		}

		$role = new SB_Role($role_id);
		if (sb_get_current_user()->role_id > 0 && !$role->role_id) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage(__('El rol de usuario no existe', 'users'), 'error');
			return false;
		}
		if ((int) $current_user->user_id !== (int) $user_id && !$current_user->can('create_role_' . $role->role_key)) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage(SB_Text::_('No esta autorizado para crear este rol de usuario', 'users'), 'error');
			return false;
		}
		//##check if current user is root
		if ($user_id) {
			$_user = new SB_User($user_id);
			if ($_user->username == 'root') {
				$role_id = 0;
			}
		}

		$dbh = SB_Factory::getDbh();
		$query = "SELECT user_id FROM users WHERE username = '$username' LIMIT 1";
		if (!$user_id && $dbh->Query($query)) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage('El nombre de usuario ya existe, elija uno diferente.', 'error');
			return false;
		}
		if (!$user_id && empty($pwd)) {
			if ($user_id) {
				$this->task_edit_user();
			}
			SB_MessagesStack::AddMessage(SBText::_('Debe ingresar una contrase&ntilde;a.', 'users'), 'error');
			return false;
		}
		$user = null;
		if ($user_id) {
			$user = new SB_User($user_id);
			$user_dir = UPLOADS_DIR . SB_DS . sb_build_slug($user->username);
		}
		$cdate = date('Y-m-d H:i:s');
		$data = array(
			'first_name'				=> $first_name,
			'last_name'					=> $last_name,
			'email'						=> $email,
			'pwd'						=> md5($pwd),
			'role_id'					=> $role_id,
			'status'					=> 'enabled',
			'last_modification_date'	=> $cdate
		);

		SB_Module::do_action('before_save_user', $user_id);
		if (!is_dir($user_dir))
			mkdir($user_dir);

		if (file_exists(TEMP_DIR . SB_DS . $image_file)) {
			@rename(TEMP_DIR . SB_DS . $image_file, $user_dir . SB_DS . $image_file);
		}

		if (!$user_id) {
			$data['username'] 		= $username;
			$data['creation_date'] 	= SB_Request::getString('creation_date') ?
				sb_format_datetime(SB_Request::getString('creation_date'), 'Y-m-d H:i:s') : $cdate;
			//##create a new user
			$user_id = $dbh->Insert('users', $data);
			SB_Meta::addMeta('user_meta', '_observations', $observations, 'user_id', $user_id);
			SB_Meta::addMeta('user_meta', '_notes', $notes, 'user_id', $user_id);
			sb_add_user_meta($user_id, '_owner_id', sb_get_current_user()->user_id);
			sb_add_user_meta($user_id, '_birthday', SB_Request::getString('birthday'));
			sb_add_user_meta($user_id, '_address', SB_Request::getString('address'));
			sb_add_user_meta($user_id, '_city', SB_Request::getString('city'));
			sb_add_user_meta($user_id, '_state', SB_Request::getString('state'));
			sb_add_user_meta($user_id, '_country', SB_Request::getString('country'));
			sb_add_user_meta($user_id, '_image', $image_file);
			sb_add_user_meta($user_id, '_no_login', SB_Request::getInt('no_login'));
			SB_Module::do_action('save_user', $user_id);
			SB_MessagesStack::AddMessage('El usuario se creo correctamente', 'success');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		} else {
			if (empty($pwd)) {
				unset($data['pwd']);
			}
			if (!$user->user_id) {
				SB_MessagesStack::AddMessage(SB_Text::_('El identificador de usuario no existe.', 'users'), 'error');
				return false;
			}
			if (sb_get_current_user()->user_id != $user_id && sb_get_current_user()->role_id !== 0 && sb_get_current_user()->user_id != $user->_owner_id) {
				SB_MessagesStack::AddMessage(SB_Text::_('No puede editar el usuario solicitado.', 'users'), 'error');
				sb_redirect(SB_Route::_('index.php?mod=users'));
			}
			$data['creation_date'] = sb_format_datetime(SB_Request::getString('creation_date'), 'Y-m-d H:i:s');
			$dbh->Update('users', $data, array('user_id' => $user_id));
			sb_update_user_meta($user_id, '_image', $image_file);
			sb_update_user_meta($user_id, '_observations', $observations);
			sb_update_user_meta($user_id, '_notes', $notes);
			sb_update_user_meta($user_id, '_birthday', SB_Request::getString('birthday'));
			sb_update_user_meta($user_id, '_address', SB_Request::getString('address'));
			sb_update_user_meta($user_id, '_city', SB_Request::getString('city'));
			sb_update_user_meta($user_id, '_state', SB_Request::getString('state'));
			sb_update_user_meta($user_id, '_country', SB_Request::getString('country'));
			sb_update_user_meta($user_id, '_image', $image_file);
			sb_update_user_meta($user_id, '_no_login', SB_Request::getInt('no_login'));
			SB_Module::do_action('save_user', $user_id);
			//##update user
			SB_MessagesStack::AddMessage('El usuario se actualizo correctamente', 'success');
			sb_redirect(SB_Route::_('index.php?mod=users&view=edit_user&id=' . $user_id));
		}
	}
	public function task_delete_user()
	{
		if (!sb_get_current_user()->can('manage_users')) {
			die('You dont have enough permissions');
		}
		if (!sb_get_current_user()->can('delete_user')) {
			die('You dont have enough permissions');
		}
		$user_id = SB_Request::getInt('id');
		if (!$user_id) {
			SB_MessagesStack::AddMessage(SB_Text::_('Identificador de usuario no valido', 'users'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$user = new SB_User($user_id);
		if (!$user->user_id) {
			SB_MessagesStack::AddMessage(SB_Text::_('El usuario no existe', 'users'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$dbh = SB_Factory::getDbh();
		$query = "DELETE FROM user_meta WHERE user_id = {$user->user_id}";
		$dbh->Query($query);
		$dbh->Query("DELETE FROM users WHERE user_id = {$user->user_id} LIMIT 1");
		//##delete user folder
		SB_MessagesStack::AddMessage(SB_Text::_('El usuario se borro correctamente.', 'users'), 'error');
		sb_redirect(SB_Route::_('index.php?mod=users'));
	}
	public function task_upload_image()
	{
		require_once INCLUDE_DIR . SB_DS . 'qqFileUploader.php';
		$uh = new qqFileUploader();
		$uh->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
		// Specify max file size in bytes.
		//$uh->sizeLimit = 10 * 1024 * 1024; //10MB
		// Specify the input name set in the javascript.
		$uh->inputName = 'qqfile';
		// If you want to use resume feature for uploader, specify the folder to save parts.
		$uh->chunksFolder = 'chunks';
		$res = $uh->handleUpload(TEMP_DIR);
		$file_path = TEMP_DIR . SB_DS . $uh->getUploadName();
		sb_include('class.image.php');
		$img = new SB_Image($file_path);
		try {
			//if( $img->getWidth() > 150 || $img->getHeight() > 150)
			//{
			$img->resizeImage(150, 150);
			$img->save($file_path);
			//}
			$res['uploadName'] = $uh->getUploadName();
			$res['image_url'] = BASEURL . '/temp/' . $res['uploadName'];

			if ($user_id = SB_Request::getInt('user_id')) {
				//sb_update_user_meta($user_id, '', $meta_value);
			}
		} catch (Exception $e) {
			$res['status']	= 'error';
			$res['error'] = $e->getMessage();
		}


		die(json_encode($res));
	}
	public function task_roles()
	{
		if (!sb_get_current_user()->can('manage_roles')) {
			die('You dont have enough permissions');
		}
		$page 		= SB_Request::getInt('page', 1);
		$order_by 	= SB_Request::getString('order_by', 'creation_date');
		$order 		= SB_Request::getString('order', 'desc');
		$dbh 		= SB_Factory::getDbh();
		$limit		= SB_Request::getInt('limit', 25);
		if (defined('ITEMS_PER_PAGE')) {
			$limit = ITEMS_PER_PAGE;
		}

		$query = "SELECT {columns} FROM user_roles WHERE role_key <> 'possible' AND role_key <> 'bloqued' ORDER BY $order_by $order";
		$res = $dbh->Query(str_replace('{columns}', 'COUNT(*) AS total_rows', $query));
		$total_rows = $dbh->FetchRow()->total_rows;
		$pages = ceil($total_rows / $limit);
		$offset = $page <= 1 ? 0 : ($page - 1) * $limit;
		$roles = array();

		$dbh->Query(str_replace('{columns}', '*', $query . " LIMIT $offset, $limit"));
		foreach ($dbh->FetchResults() as $row) {
			$roles[] = $row;
		}
		$new_order = ($order == 'desc') ? 'asc' : 'desc';
		$role_order_link		= 'index.php?mod=users&view=roles&order_by=role_name&order=' . $new_order;
		sb_set_view_var('role_order_link', $role_order_link);
		sb_set_view_var('roles', $roles);
	}
	public function task_online_users()
	{
		$page 		= SB_Request::getInt('page', 1);
		$order_by 	= SB_Request::getString('order_by', 'last_login');
		$order 		= SB_Request::getString('order', 'desc');
		$dbh 		= SB_Factory::getDbh();
		$limit		= SB_Request::getInt('limit', defined('ITEMS_PER_PAGE') ? ITEMS_PER_PAGE : 25);

		$query = "SELECT {columns} " .
			"FROM users u, user_meta um, user_meta umt " .
			"WHERE 1 = 1 " .
			"AND u.user_id = um.user_id " .
			"AND um.meta_key = '_logged_in' " .
			"AND um.meta_value = 'yes' " .
			"AND u.user_id = umt.user_id " .
			"AND umt.meta_key = '_timeout' " .
			sprintf("AND ((%d - CAST(umt.meta_value AS UNSIGNED)) < %d) ", time(), SESSION_EXPIRE);

		$dbh = SB_Factory::getDbh();
		$dbh->Query(str_replace('{columns}', 'COUNT(u.user_id) AS total_rows', $query));
		$total_rows 	= $dbh->FetchRow()->total_rows;
		$total_pages 	= ceil($total_rows / $limit);
		$offset 		= $page <= 1 ? 0 : ($page - 1) * $limit;
		$sub_query0		= "SELECT um0.meta_value FROM user_meta um0 WHERE um0.meta_key = '_logged_in_time' AND um0.user_id = u.user_id";
		//$columns		= "u.*, ($sub_query0) AS last_login";
		$columns		= "u.*, umt.meta_value AS last_login";
		$query 			= str_replace('{columns}', $columns, $query);
		$query_order 	= "ORDER BY $order_by $order";
		$query_limit	= "LIMIT $offset, $limit";
		//print $query;
		$dbh->Query(str_replace('{columns}', $columns, $query) . "$query_order $query_limit");
		$users = $dbh->FetchResults();
		$new_order = $order == 'desc' ? 'asc' : 'desc';
		sb_set_view_var('id_order_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=user_id&order=' . $new_order));
		sb_set_view_var('username_order_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=username&order=' . $new_order));
		sb_set_view_var('order_email_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=email&order=' . $new_order));
		sb_set_view_var('order_first_name_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=first_name&order=' . $new_order));
		sb_set_view_var('order_last_name_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=last_name&order=' . $new_order));
		sb_set_view_var('order_last_login_link', SB_Route::_('index.php?mod=users&view=online_users&order_by=last_login&order=' . $new_order));
		sb_set_view_var('users', $users);
	}
}
