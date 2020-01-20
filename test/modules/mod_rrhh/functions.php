<?php
function rrhh_get_announcement_statuses()
{
	return array(
			'active'	=> __('Active', 'rrhh'),
			'inactive'	=> __('Inactive', 'rrhh'),
			'closed'	=> __('Closed', 'rrhh'),
	);
}
function rrhh_show_announcement_status($status)
{
	$statuses = rrhh_get_announcement_statuses();
	$class = '';
	if( $status == 'active' )
		$class = 'success';
	if( $status == 'inactive' )
		$class = 'default';
	if( $status == 'closed' )
		$class = 'danger';
	return '<span class="label label-'.$class.'">'.$statuses[$status] . '</span>';
}
