<?php
defined('BASEPATH') or die('Dont fuck with me buddy.');
SB_Module::RunSQL('statistics');
$dbh = SB_Factory::getDbh();
$permissions = array(
		array('permission' => 'manage_statistics', 'label'	=> SB_Text::_('Gestionar Estadisticas', 'statistics')),
);
$local_permissions = sb_get_permissions(false);
foreach($permissions as $perm)
{
	if( in_array($perm['permission'], $local_permissions) ) continue;
	$dbh->Insert('permissions', $perm);
}
