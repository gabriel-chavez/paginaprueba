<?php 
SB_Module::RunSQL('rrhh');
$perms = array(
		array('label' => __('View Human Resource Menu'), 'group' => 'rrhh', 'permission' => 'rrhh_menu'),
		array('label' => __('Manage Human Resources'), 'group' => 'rrhh', 'permission' => 'rrhh_manage'),
);
sb_add_permissions($perms);