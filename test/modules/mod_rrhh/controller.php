<?php
class LT_ControllerRrhh extends SB_Controller
{
	public function task_default()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		$user = sb_get_current_user();
		
		$table = new LT_TableList('rrhh_announcements', 'id', 'rrhh');
		$table->SetColumns(array(
				'id'					=> array('label' => __('ID'), 'show' => false),
				'code'					=> array('label' => __('Code', 'rrhh')),
				'name'					=> array('label' => __('Name', 'rrhh')),
				'status'				=> array('label' => __('Status', 'rrhh'), 'show' => true, 'callback' => 'rrhh_show_announcement_status'),
				'start_date'			=> array('label' => __('Start Date', 'rrhh'), 'show' => false),
				'end_date'				=> array('label' => __('End Date', 'rrhh')),
				'creation_date'			=> array('label' => __('Creation Date', 'rrhh'), 'show' => false),
		));
		$table->SetRowActions(array(
				'view:announcement'		=> array('label' => '<span class="glyphicon glyphicon-eye-open"></span> ' . __('View', 'rrhh')/*, 'icon' => 'glyphicon glyphicon-edit'*/),
		));
		$table->showSelector = false;
		$table->Fill();
		$title = __('Announcements', 'rrhh');
		$this->document->SetTitle($title);
		sb_set_view_var('title', $title);
		sb_set_view_var('table', $table);
	}
	public function task_announcement()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$user = sb_get_current_user();
		
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			sb_set_view('item-not-found');
			return false;
		}
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$obj = new RRHH_Announcement($id);
		if( !$obj->id )
		{
			sb_set_view('item-not-found');
			return false;
		}
		$already_applied = $this->dbh->FetchRow("SELECT id FROM rrhh_announcement2person WHERE announcement_id = $id AND person_id = {$person->id} LIMIT 1");
		$this->document->templateFile = 'page.php';
		$title = sprintf(__('Announcement - %s - %s', 'rrhh'), $obj->code, $obj->name);
		$this->document->SetTitle($title);
		sb_set_view_var('obj', $obj);
		sb_Set_view_var('person', $person);
		sb_set_view_var('title', $title);
		sb_set_view_var('already_applied', $already_applied);
	}
	public function task_profile()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=users'));
		}
		$user = sb_get_current_user();
		$title = __('User Profile', 'rrhh');
		//$user = sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		//print_r($person);
		//##if person does not have a RRHH profile create it
		if( !$person->id )
		{
			@list($fln, $mln) = explode(' ', $user->last_name);
			$data = array(
					'user_id'			=> $user->user_id,
					'first_name'		=> $user->first_name,
					'fathers_lastname'	=> $fln,
					'mothers_lastname'	=> $mln,
					'email'				=> $user->email,
					'birthday'			=> $user->_birthday ? sb_format_date($user->_birthday, 'Y-m-d') : '',
					'creation_date'		=> date('Y-m-d H:i:s') 
			);
			$id = $this->dbh->Insert('rrhh_person', $data);
			$person = new RRHH_Person($id);
		}
		sb_set_view_var('person', $person);
		sb_set_view_var('study_levels', $this->dbh->FetchResults("SELECT * FROM rrhh_study_levels ORDER BY id ASC"));
		$this->document->SetTitle($title);
		lt_add_datepicker();
		
	}
	public function task_save_profile()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		$countries 			= include INCLUDE_DIR . SB_DS . 'countries.php';
		$user 				= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		
		$first_name 		= SB_Request::getString('first_name');
		$fathers_lastname	= SB_Request::getString('fathers_lastname');
		$mothers_lastname	= SB_Request::getString('mothers_lastname');
		$birthday			= SB_Request::getDate('birthday');
		$city_birth			= SB_Request::getString('city_birth');
		$country_birth		= SB_Request::getString('country_birth');
		$current_city			= SB_Request::getString('current_city');
		$current_country_code	= SB_Request::getString('current_country');
		$address_1			= SB_Request::getString('address_1');
		$address_zone		= SB_Request::getString('address_zone');
		$telephone			= SB_Request::getString('telephone');
		$mobile				= SB_Request::getString('mobile');
		$email				= SB_Request::getString('email');
		$document_type		= SB_Request::getString('document_type');
		$document			= SB_Request::getString('document');
		$document_from		= SB_Request::getString('document_from');
		$current_country	= isset($countries[$current_country_code]) ? $countries[$current_country_code] : '';
		
		$data = compact('first_name', 'fathers_lastname', 'mothers_lastname', 'birthday', 'city_birth', 'country_birth', 'current_city',
						'current_country', 'address_1', 'address_zone', 'telephone', 'mobile', 'email', 'document_type', 'document',
						'document_from'
				);
		$data['country_country_code'] = $current_country_code;
		$this->dbh->Update('rrhh_person', $data, array('user_id' => $user->user_id));
		//##check for image
		if( isset($_FILES['image']) && $_FILES['image']['size'] > 0 )
		{
			sb_include('class.image.php');
			$ih = new SB_Image($_FILES['image']['tmp_name']);
			if( $ih->getWidth() > 128 )
			{
				$ih->resizeImage(128, 128);
				$destination = sb_get_unique_filename($_FILES['image']['name'], MOD_RRHH_IMAGES_DIR);
				$ih->save($destination);
				SB_Meta::updateMeta('rrhh_person_meta', '_image', basename($destination), 'person_id', $person->id);
			}
			else 
			{
				$destination = sb_get_unique_filename($_FILES['image']['name'], MOD_RRHH_IMAGES_DIR);
				move_uploaded_file($_FILES['image']['tmp_name'], $destination);
				SB_Meta::updateMeta('rrhh_person_meta', '_image', basename($destination), 'person_id', $person->id);
			}
		}
		SB_MessagesStack::AddMessage(__('Your profile has been updated', 'rrhh'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
	public function task_save_record()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		$countries = include  INCLUDE_DIR . SB_DS . 'countries.php';
		$user = sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$person_id				= $person->id;
		$id						= SB_Request::getInt('id');
		$ajax					= SB_Request::getInt('ajax');
		$study_level_id			= SB_Request::getInt('study_level_id');
		$center_name			= SB_Request::getString('center_name');
		$degree					= SB_Request::getString('degree');
		$degree_date			= SB_Request::getDate('degree_date');
		$degree_city			= SB_Request::getString('degree_city');
		$degree_country_code	= SB_Request::getString('degree_country');
		$degree_country = $countries[$degree_country_code];
		$data = compact('person_id', 'study_level_id', 'center_name', 'degree', 'degree_date', 'degree_city', 'degree_country_code', 'degree_country');
		if( !$id )
		{
			$data['creation_date'] = date('Y-m-d H:i:s');
			$id = $this->dbh->Insert('rrhh_academic_records', $data);
		}
		else
		{
			$id = $this->dbh->Update('rrhh_academic_records', $data, array('id' => $id, 'person_id' => $person_id));
		}
		$msg = __('The academic record has been registered', 'rrhh');
		if( $ajax )
		{
			$res = array(
					'status' 	=> 'ok',
					'id'		=> $id,
					'message'	=> $msg
			);
			sb_response_json($res);
		}
		SB_MessagesStack::AddMessage($msg, 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
	public function task_save_work_experience()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		$countries = include  INCLUDE_DIR . SB_DS . 'countries.php';
		$user = sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$person_id				= $person->id;
		$data					= SB_Request::getVars(array(
				'int:id', 
				'company', 
				'company_industry', 
				'company_phone',
				'position', 
				'main_functions', 
				'int:dependent', 
				'date:start_date', 
				'date:end_date',
				'superior_name',
				'superior_position',
				'int:currently_working',
				'decouplin_reason'
		));
		if( strlen($data['main_functions']) > 255 )
		{
			$data['main_functions'] = substr($data['main_functions']);
		}
		if( $data['currently_working'] )
		{
			$data['decouplin_reason'] = __('Currently Working', 'rrhh');
		}
		if( !$data['id'] )
		{
			$data['person_id']		= $person_id;
			$data['creation_date'] = date('Y-m-d H:i:s');
			$data['id'] = $this->dbh->Insert('rrhh_experience', $data);
			$msg = __('The work experience has been added', 'rrhh');
		}
		else
		{
			$this->dbh->Update('rrhh_experience', $data, array('id' => $data['id'], 'person_id' => $person_id));
			$msg = __('The work experience has been updated', 'rrhh');
		}
		if( SB_Request::getInt('ajax') )
		{
			$res = array('status' => 'ok', 'message' => $msg); 
			sb_response_json($res);
		}
		SB_MessagesStack::AddMessage($msg, 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
	public function task_profile2pdf()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		$user 				= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		if( !$person->id )
		{
			lt_die(__('The profile does not exists', 'rrhh'));
		}
		ob_start();
		include MOD_RRHH_DIR . SB_DS . 'views' . SB_DS . 'tab-my_cv.php';
		$html = ob_get_clean();
		//##convert html quote to pdf
		sb_include_lib('dompdf/dompdf.php');
		
		$pdf = new Dompdf\Dompdf();
		$pdf->set_option('defaultFont', 'Helvetica');
		$pdf->set_option('isRemoteEnabled', true);
		$pdf->set_option('isPhpEnabled', true);
		$pdf->setPaper('A4'/*, 'landscape'*/);
		$pdf->loadHtml($html);
		$pdf->render();
		$pdf->stream(sprintf(__('%s-%s-%s-cv.pdf', 'mb'), $person->first_name, $person->fathers_lastname, $person->mothers_lastname),
				array('Attachment' => 0, 'Accept-Ranges' => 1));
		die();
	}
	public function ajax_academic_records()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$user 				= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		ob_start();
		foreach($person->GetAcademicRecords() as $rec)
		{
			include MOD_RRHH_DIR . SB_DS . 'views' . SB_DS . 'ar-row.php';
		}
		$html = ob_get_clean();
		sb_response_json(array('status' => 'ok', 'html' => $html));
	}
	public function ajax_delete_academic_record()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$user 				= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$id = SB_Request::getInt('id');
		$this->dbh->Delete('rrhh_academic_records', array('id' => $id, 'person_id' => $person->id));
		sb_response_json(array('status' => 'ok', 'message' => __('The academic record has been deleted', 'rrhh')));
	}
	public function ajax_get_workexperience()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$id 	= SB_Request::getInt('id');
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		if( $id )
		{
			$obj = $this->dbh->FetchRow("SELECT * FROM rrhh_experience WHERE id = $id AND person_id = $person->id LIMIT 1");
			sb_response_json(array('status' => 'ok', 'obj' => $obj));
		}
		ob_start();
		$we_actions = true;
		foreach($person->GetWorkExperience() as $exp)
		{
			include 'views/we-row.php';
		}
		$html = ob_get_clean();
		sb_response_json(array('status' => 'ok', 'html' => $html));
	}
	public function ajax_delete_workexperience()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$id 	= SB_Request::getInt('id');
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		
		$this->dbh->Delete('rrhh_experience', array('id' => $id, 'person_id' => $person->id));
		sb_response_json(array('status' => 'ok', 'message' => __('The work experience has been deleted', 'rrhh')));
	}
	public function task_save_reference()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$id 	= SB_Request::getInt('id');
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		
		$data = SB_Request::getVars(array(
				'int:id',
				'name',
				'company',
				'position',
				'relationship',
				'telephone',
				'cell_phone',
				'email',	
				'type'			
		));
		$msg = '';
		if( !$data['id'] )
		{
			$data['person_id']		= $person->id;
			$data['creation_date'] 	= date('Y-m-d H:i:s');
			$data['id'] = $this->dbh->Insert('rrhh_references', $data);
			$msg = __('The reference has been registered', 'rrhh');
		}
		else
		{
			$this->dbh->Update('rrhh_references', $data, array('id' => $data['id'], 'person_id' => $person->id));
			$msg = __('The reference has been updated', 'rrhh');
		}
		if( SB_Request::getInt('ajax') )
		{
			sb_response_json(array('status' => 'ok', 'message' => $msg));
		}
		SB_MessagesStack::AddMessage($msg, 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
	public function ajax_get_references()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$id 	= SB_Request::getInt('id');
		$type	= SB_Request::getString('type', 'personal');
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		ob_start();
		$references = $type == 'personal' ? $person->GetPersonalReferences() : $person->GetWorkReferences();
		$tpl = $type == 'personal' ? 'views/pr-row.php' : 'views/emp-ref-row.php';
		foreach($references as $ref)
		{
			include $tpl;
		}
		$html = ob_get_clean();
		sb_response_json(array('status' => 'ok', 'html' => $html));
	}
	public function task_delete_reference()
	{
		if( !sb_is_user_logged_in() )
		{
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$id 	= SB_Request::getInt('id');
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$this->dbh->Delete('rrhh_references', array('id' => $id, 'person_id' => $person->id));
	}
	public function task_apply()
	{
		$ajax 	= SB_Request::getInt('ajax');
		$id 	= SB_Request::getInt('id');
		if( !sb_is_user_logged_in() )
		{
			if( !$ajax )
			{
				sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
			}
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		//##check if the person already applied to the announcement
		if( $this->dbh->Query("SELECT id FROM rrhh_announcement2person WHERE announcement_id = $id AND person_id = {$person->id} LIMIT 1") )
		{
			$msg = __('You already applied to this announcement', 'rrhh');
			if( !$ajax )
			{
				SB_MessagesStack::AddMessage($msg, 'error');
				sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcement&id='.$id));
			}
			sb_response_json(array('status' => 'error', 'error' => $msg));
		}
		
		$specific_experience 	= json_encode((array)array_map('intval', SB_Request::getVar('specific_experience', array())));
		$general_experience 	= json_encode((array)array_map('intval', SB_Request::getVar('general_experience', array())));
		$announcement_id		= $id;
		$person_id				= $person->id;
		$salary_pretension		= SB_Request::getFloat('salary_pretension');
		$days					= SB_Request::getInt('days');
		$inmediate_availability	= SB_Request::getString('inmediate_availability','no');
		$data = compact('announcement_id', 'person_id', 'salary_pretension', 'inmediate_availability', 'days', 'specific_experience', 'general_experience');
		$data['creation_date'] = date('Y-m-d H:i:s');
		$new_id = $this->dbh->Insert('rrhh_announcement2person', $data);
		//$msg = __('We have received your application to the announcement successfully.', 'rrhh');
		//##send email notifications
		$email_from = defined('RRHH_EMAIL_FROM') ? RRHH_EMAIL_FROM : 'no-reply@littlecms.com';
		$msg =  str_replace(array('{nombre}'), 
							array(sprintf("%s %s %s", $person->first_name, $person->fathers_lastname, $person->mothers_lastname)), 
							@RRHH_EMAIL_APPLIED);
		lt_mail($person->email, RRHH_EMAIL_SUBJECT, $msg, array('From:' . $email_from));
		//##send email to admin
		$msg =  @RRHH_EMAIL_APPLIED_ADMIN;
		lt_mail(RRHH_ADMIN_EMAIL, RRHH_EMAIL_SUBJECT_ADMIN, $msg, array('From:' . $email_from));
		if( !$ajax )
		{
			SB_MessagesStack::AddMessage($msg, 'success');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcement&id='.$id));
		}
		
		sb_response_json(array('status' => 'ok', 'message' => $msg));
	}
	public function task_do_register()
	{
		$username 		= SB_Request::getString('document');
		$email			= SB_Request::getString('email');
		$pwd			= SB_Request::getString('pwd');
		$rpwd			= SB_Request::getString('rpwd');
		if( empty($username) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The document is empty', 'rrhh'), 'error');
			sb_redirect($redirect ? $redirect : SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		if( empty($email) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The email is empty', 'users'), 'error');
			sb_redirect($redirect ? $redirect : SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		if( empty($pwd) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The password is empty', 'users'), 'error');
			sb_redirect($redirect ? $redirect : SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		if( empty($rpwd) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('You must to retype your password', 'users'), 'error');
			sb_redirect($redirect ? $redirect : SB_Route::_('index.php?mod=rrhh&view=login'));
		}
		//##check if username exists
		if( sb_get_user_by('username', $username) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The username already exists, choose a new one', 'users'), 'error');
			return false;
		}
		//##check if email exists
		if( sb_get_user_by('email', $email) )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The user email already exists, choose a new one', 'users'), 'error');
			return false;
		}
		if( $pwd != $rpwd )
		{
			sb_set_view('register');
			SB_MessagesStack::AddMessage(__('The passwords does not match', 'users'), 'error');
			return false;
		}
		$role = sb_get_user_role_by_key('user');
		$data = array(
				'username'					=> $username,
				'pwd'						=> md5($pwd),
				'email'						=> $email,
				'status'					=> 'enabled',
				'role_id'					=> $role->role_id,
				'last_modification_date'	=> date('Y-m-d H:i:s'),
				'creation_date'				=> date('Y-m-d H:i:s')
		);
		
		$id = sb_insert_user($data);
		SB_MessagesStack::AddMessage(__('Your user was registered correctly, please review your email for details', 'users'), 'success');
		sb_redirect($redirect ? $redirect : SB_Route::_('index.php?mod=rrhh&view=login'));
	}
	public function task_do_login()
	{
		$username 	= SB_Request::getString('document');
		$pwd		= SB_Request::getString('pwd');
		$captcha	= SB_Request::getString('captcha');
		$dbh 		= SB_Factory::getDbh();
		$query 		= "SELECT u.*,r.role_key ".
						"FROM users u ".
						"LEFT JOIN user_roles r ON r.role_id = u.role_id ".
						"WHERE u.username = '$username' LIMIT 1";
		//sb_get_user_by('username', $username);
		$row = $dbh->FetchRow($query);
		$error_link = SB_Route::_('index.php?mod=rrhh&view=login');
		if( !$row )
		{
			SB_Module::do_action('authenticate_error', null, $username, $pwd);
			SB_MessagesStack::AddMessage('Usuario o contrase&ntilde;a invalida', 'error');
			sb_redirect($error_link);
		}
		if( $row->pwd != md5($pwd) )
		{
			SB_Module::do_action('authenticate_error', $row, $username, $pwd);
			SB_MessagesStack::AddMessage('Usuario o contrase&ntilde;a invalida', 'error');
			sb_redirect($error_link);
		}
		$form_captcha 	= SB_Session::getVar('rrhh_captcha');
		if( $captcha != $form_captcha )
		{
			SB_Module::do_action('authenticate_error', $row, $username, $pwd);
			SB_MessagesStack::AddMessage(SB_Text::_('El texto de seguridad es invalido'), 'error');
			sb_redirect($error_link);
		}
		//print_r($row);die();
		if( $row->role_id !== 0 )
		{
			if( $row->role_key == 'possible' || $row->role_key == 'bloqued' )
			{
				SB_MessagesStack::AddMessage('El usuario no puede iniciar sesion.', 'error');
				sb_redirect($error_link);
				return false;
			}
			if( (int)sb_get_user_meta($row->user_id, '_no_login') == 1 )
			{
				sb_redirect(SB_Route::_('login-error.html'));
			}
		}
		$session = SB_Module::do_action('authenticate_session', true);
		if( !$session )
		{
			sb_redirect($error_link);
		}
		SB_Session::setVar('user', $row);
		$cookie_value = md5(serialize($row) . ':' . session_id());
		SB_Session::setVar('lt_session', $cookie_value);
		SB_Session::setVar('timeout', time());
		SB_Session::unsetVar('rrhh_captcha');
		//##mark user as logged in
		sb_update_user_meta($row->user_id, '_logged_in', 'yes');
		sb_update_user_meta($row->user_id, '_logged_in_time', time());
		SB_Module::do_action('authenticated', $row, $username, $pwd);
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
	public function task_delete_image()
	{
		$ajax = SB_Request::getInt('ajax');
		if( !sb_is_user_logged_in() )
		{
			if( !$ajax )
			{
				sb_redirect(SB_Route::_('index.php?mod=rrhh&view=login'));
			}
			sb_response_json(array('status' => 'error', 'error' => __('You are not logged in', 'rrhh')));
		}
		$user 	= sb_get_current_user();
		$person	= new RRHH_Person();
		$person->GetDbDataByUserId($user->user_id);
		$image = MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image;
		@unlink($image);
		SB_Meta::deleteMeta('rrhh_person_meta', '_image', 'person_id', $person->id);
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=profile'));
	}
}