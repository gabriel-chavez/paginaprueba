<?php
class LT_AdminControllerRrhhStudylevels extends SB_Controller
{
	public function task_default()
	{
		$table = new LT_TableList('rrhh_study_levels', 'id', 'rrhh');
		$table->SetColumns(array(
				'id'		=> array('label' => __('ID')),
				'name'		=> array('label' => __('Name', 'rrhh'))
		));
		$table->SetRowActions(array(
				'studylevels.edit'			=> array('label' => __('Edit', 'rrhh'), 'icon' => 'glyphicon glyphicon-edit'),
				'task:studylevels.delete'	=> array('label' => __('Edit', 'rrhh'), 'icon' => 'glyphicon glyphicon-trash', 'class' => 'confirm')
		));
		$table->showCount 		= false;
		$table->showSelector 	= false;
		$table->Fill();
		$title = __('Study Levels', 'rrhh');
		sb_set_view_var('table', $table);
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_new()
	{
		$title = __('Create New Study Level', 'rrhh');
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_edit()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('The study level identifier is invalid', 'rrhh'), 'success');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=studylevels.default'));
		}
		$obj = $this->dbh->FetchRow("SELECT * FROM rrhh_study_levels WHERE id = $id LIMIT 1");
		sb_set_view('studylevels.new');
		$title = __('Edit Study Level', 'rrhh');
		sb_set_view_var('title', $title);
		sb_set_view_var('obj', $obj);
		$this->document->SetTitle($title);
	}
	public function task_delete()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('The study level identifier is invalid', 'rrhh'), 'success');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=studylevels.default'));
		}
	}
	public function task_save()
	{
		$id 	= SB_Request::getInt('id');
		$name 	= SB_Request::getString('name');
		$data = array(
				'name'	=> $name
		);
		$link = $msg = '';
		$link 	= SB_Route::_('index.php?mod=rrhh&view=studylevels.default');
		if( !$id )
		{
			$id 	= $this->dbh->Insert('rrhh_study_levels', $data);
			$msg 	= __('The study level has been created', 'rrhh');
		}
		else
		{
			$this->dbh->Update('rrhh_study_levels', $data, array('id' => $id));
			$msg 	= __('The study level has been updated', 'rrhh');
		}
		SB_MessagesStack::AddMessage($msg, 'success');
		sb_redirect($link);
	}
	public function task_insert_default()
	{
		$levels = array(
				array('name' => 'Secundaria', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Bachiller', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Estudiante Universitario', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Universitario', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Tecnico Medio', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Tecnico Superior', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Egresado', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Licenciatura', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Diplomado', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Maestria', 'creation_date' => date('Y-m-d H:i:s')),
				array('name' => 'Doctorado', 'creation_date' => date('Y-m-d H:i:s')),
		);
		$this->dbh->InsertBulk('rrhh_study_levels', $levels);
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=studylevels.default'));
	}
}