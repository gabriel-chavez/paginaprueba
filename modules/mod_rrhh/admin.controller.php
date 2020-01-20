<?php
class LT_AdminControllerRrhh extends SB_Controller
{
	public function task_default()
	{
		//$keyword = SB_Request::getString('keyword');
		$table = new LT_TableList('rrhh_person', 'id', 'rrhh');
		$table->SetColumns(array(
				'id'					=> array('label' => __('ID')),
				'first_name'			=> array('label' => __('Firstname', 'rrhh')),
				'fathers_lastname'		=> array('label' => __('Fathers Lastname', 'rrhh')),
				'mothers_lastname'		=> array('label' => __('Mothers Lastname', 'rrhh')),
				'current_city'			=> array('label' => __('City', 'rrhh')),
				'current_country'		=> array('label' => __('Country', 'rrhh')),
				'email'					=> array('label' => __('Email', 'rrhh')),
				'user_id'				=> array('show' => false),
				'last_activity'			=> array(
													'label' 	=> __('Ultima Actividad', 'rrhh'), 
													'db_col'	=> false,
													'callback' 	=> 'rrhh_show_last_activity'
											),
		));
		$table->SetRowActions(array(
				'view:edit'	=> array('label' => __('Edit', 'rrhh'), 'icon' => 'glyphicon glyphicon-edit'),
				'task:delete'	=> array('label' => __('Delete', 'rrhh'), 
											'icon' => 'glyphicon glyphicon-trash', 
											'class' => 'confirm', 
											'data' => array(
													'message' => __('Are you sure to delete the person?', 'rrhh')
											)),
		));
		$table->Fill();
		$table->showCount = false;
		sb_set_view_var('table', $table);
	}
	public function task_edit()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('The person identifier is invalid', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh'));
		}
		$person = new RRHH_Person($id);
		if( !$person->id )
		{
			SB_MessagesStack::AddMessage(__('The person does not exists', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh'));
		}
		sb_set_view('new');
		$title = __('Edit Human Resource', 'rrhh');
		sb_set_view_var('person', $person);
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_save()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('The person identifier is invalid', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh'));
		}
		$person = new RRHH_Person($id);
		if( !$person->id )
		{
			SB_MessagesStack::AddMessage(__('The person does not exists', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh'));
		}
		
		$countries 				= include INCLUDE_DIR . SB_DS . 'countries.php';
		$user 					= sb_get_current_user();
		$first_name 			= SB_Request::getString('first_name');
		$fathers_lastname		= SB_Request::getString('fathers_lastname');
		$mothers_lastname		= SB_Request::getString('mothers_lastname');
		$birthday				= SB_Request::getDate('birthday');
		$city_birth				= SB_Request::getString('city_birth');
		$country_birth			= SB_Request::getString('country_birth');
		$current_city			= SB_Request::getString('current_city');
		$current_country_code	= SB_Request::getString('current_country');
		$address_1				= SB_Request::getString('address_1');
		$address_zone			= SB_Request::getString('address_zone');
		$telephone				= SB_Request::getString('telephone');
		$mobile					= SB_Request::getString('mobile');
		$email					= SB_Request::getString('email');
		$document_type			= SB_Request::getString('document_type');
		$document				= SB_Request::getString('document');
		$document_from			= SB_Request::getString('document_from');
		$current_country		= isset($countries[$current_country_code]) ? $countries[$current_country_code] : '';
		
		$data = compact('first_name', 'fathers_lastname', 'mothers_lastname', 'birthday', 'city_birth', 'country_birth', 'current_city',
				'current_country', 'address_1', 'address_zone', 'telephone', 'mobile', 'email', 'document_type', 'document',
				'document_from'
		);
		$data['country_country_code'] = $current_country_code;
		$this->dbh->Update('rrhh_person', $data, array('id' => $person->id));
		SB_MessagesStack::AddMessage(__('The person has been updated', 'rrhh'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh'));
	}
	public function task_delete()
	{
		$id = SB_Request::getVar('id');
		if( is_array($id) )
		{
			foreach($id as $_id)
			{
				$person = new RRHH_Person($_id);
				if( !$person->id ) continue;
								
				$this->dbh->Delete('rrhh_academic_records', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_announcement2person', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_experience', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_person_meta', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_references', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_skills', array('person_id' => $_id));
				$this->dbh->Delete('rrhh_person', array('id' => $_id));
				$this->dbh->Delete('users', array('user_id' => $person->user_id));
				$this->dbh->Delete('user_meta', array('user_id' => $person->user_id));
			}
		}
		else
		{
			$person = new RRHH_Person($id);
			if( !$person->id )
			{
				SB_MessagesStack::AddMessage(__('The person does not exists', 'rrhh'), 'error');
				sb_redirect(SB_Route::_('index.php?mod=rrhh'));
			}
			
			$this->dbh->Delete('rrhh_academic_records', array('person_id' => $id));
			$this->dbh->Delete('rrhh_announcement2person', array('person_id' => $id));
			$this->dbh->Delete('rrhh_experience', array('person_id' => $id));
			$this->dbh->Delete('rrhh_person_meta', array('person_id' => $id));
			$this->dbh->Delete('rrhh_references', array('person_id' => $id));
			$this->dbh->Delete('rrhh_skills', array('person_id' => $id));
			$this->dbh->Delete('rrhh_person', array('id' => $id));
			$this->dbh->Delete('users', array('user_id' => $person->user_id));
			$this->dbh->Delete('user_meta', array('user_id' => $person->user_id));
		}
		
		SB_MessagesStack::AddMessage(__('The person has been deleted from database', 'rrhh'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh'));
	}
}