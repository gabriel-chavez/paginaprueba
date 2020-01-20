<?php
/**
 * Class to add customers important dates
 * 
 * @author marcelo
 *
 */
class LT_ThemeLittleBoysHooksCustomers
{
	public function __construct()
	{
		$this->AddActions();
	}
	protected function AddActions()
	{
		if( lt_is_admin() )
		{
			SB_Module::add_action('customers_tabs', array($this, 'action_customers_tabs'));
			SB_Module::add_action('customers_tab_contents', array($this, 'action_customers_tab_contents'));
			SB_Module::add_action('save_customer', array($this, 'action_save_customer'));
		}
	}
	public function action_customers_tabs()
	{
		?>
		<li><a href="#tab-important-dates" data-toggle="tab"><?php _e('Important Dates', 'lb'); ?></a></li>
		<?php
	}
	public function action_customers_tab_contents($customer)
	{
		$idates = array();
		if( $customer )
		{
			$idates = sb_get_customer_meta($customer->customer_id, '_idate', 1);
		}
		
		?>
		<div id="tab-important-dates" class="tab-pane">
			<p>
				<a href="javascript:;" id="btn-add-idate" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> <?php _e('Add', 'lb'); ?></a>
			</p>
			<table id="idates" class="table">
			<thead>
			<tr>
				<th><?php _e('Num.', 'lb'); ?></th>
				<th><?php _e('Title', 'lb'); ?></th>
				<th><?php _e('Date', 'lb'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php $i = 1; foreach($idates as $date): list($_date, $title) = explode(':', $date->meta_value); ?>
			<tr>
				<td class="text-center"><?php print $i; ?></td>
				<td><input type="text" name="idates[<?php print $i - 1; ?>][title]" value="<?php print $title; ?>" class="form-control" /></td>
				<td><input type="text" name="idates[<?php print $i - 1; ?>][date]" value="<?php print sb_format_date($_date); ?>" class="form-control datepicker" /></td>
			</tr>
			<?php $i++; endforeach; ?>
			</tbody>
			</table>
		</div><!-- end id="tab-important-dates" -->
		<script>
		var idate_tpl = '<tr>'+
							'<td class="text-center">{num}</td>'+
							'<td><input type="text" name="idates[{index}][title]" value="" class="form-control" /></td>'+
							'<td><input type="text" name="idates[{index}][date]" value="" class="form-control datepicker" /></td>'+
						'</tr>';
		jQuery(function()
		{
			jQuery('#btn-add-idate').click(function()
			{
				var rows = jQuery('#idates tbody tr').length;
				var row = idate_tpl.replace(/{index}/g, rows)
									.replace(/{num}/g, rows + 1);
				jQuery('#idates tbody').append(row);
				jQuery('.datepicker').datepicker({
					format: 'dd-mm-yyyy',
					weekStart: 0,
					autoclose: true,
				    todayHighlight: true,
				    language: "es"
				});
				return false;
			});
		});
		</script>
		<?php 
	}
	public function action_save_customer($customer_id)
	{
		//TODO: we need to create a view for idates
		/*
		 * create view mb_customer_idates AS 
			SELECT customer_id, SUBSTRING_INDEX(meta_value, ':', -1) as title, DATE(meta_value) as date
			FROM mb_customer_meta 
			where 1 = 1
			AND meta_key = '_idate';
		 */
		$idates = (array)SB_Request::getVar('idates', array());
		$dbh = SB_Factory::getDbh();
		$dbh->Query("DELETE FROM mb_customer_meta WHERE customer_id = $customer_id AND meta_key = '_idate'");
		foreach($idates as $idate)
		{
			$meta_value = sprintf("%s:%s", sb_format_date($idate['date'], 'Y-m-d'), $idate['title']);
			sb_add_customer_meta($customer_id, '_idate', $meta_value);
		}
	}
}
new LT_ThemeLittleBoysHooksCustomers();