<?php
class LT_AdminControllerRrhh extends SB_Controller
{
	public function task_default()
	{
		$table = new LT_TableList('rrhh_person', 'id', 'rrhh');
		$table->SetColumns(array(
				'id'					=> array('label' => __('ID')),
				'first_name'			=> array('label' => __('Firstname', 'rrhh')),
				'fathers_lastname'		=> array('label' => __('Fathers Lastname', 'rrhh')),
				'mothers_lastname'		=> array('label' => __('Mothers Lastname', 'rrhh')),
				'current_city'			=> array('label' => __('City', 'rrhh')),
				'current_country'		=> array('label' => __('Country', 'rrhh')),
				'email'					=> array('label' => __('Email', 'rrhh')),
		));
		$table->SetRowActions(array(
				'view:edit'	=> array('label' => __('Edit', 'rrhh'), 'icon' => 'glyphicon glyphicon-edit'),
				'task:delete'	=> array('label' => __('Delete', 'rrhh'), 'icon' => 'glyphicon glyphicon-trash', 'class' => 'confirm'),
		));
		$table->Fill();
		$table->showCount = false;
		sb_set_view_var('table', $table);
	}
}