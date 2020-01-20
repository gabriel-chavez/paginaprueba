<?php
?>
<table id="table-work-experience" class="table table-condensed" style="border:1px solid #4662B1;">
<thead>
<tr><td colspan="4" style="background:#4662B1;font-size:1px;">&nbsp;</td></tr>
<tr>
	<td colspan="3">
		<table style="width:100%;">
		<tr>
			<td style="width:33.33%;"><b><?php _e('Company:', 'rrhh'); ?></b> <?php print $exp->company; ?></td>
			<td style="width:33.33%;"><b><?php _e('Cargo:', 'rrhh'); ?></b> <?php print $exp->position; ?></td>
			<td style="width:33.33%;"><b><?php _e('Sector:', 'rrhh'); ?></b> <?php print $exp->company_industry; ?></td>
		</tr>
		</table>
	</td>
	<td style="text-align:right;">
		<?php if( isset($we_actions) ): ?>
		<a href="#" class="btn btn-info btn-sm btn-edit-we" title="<?php _e('Edit', 'rrhh'); ?>" data-id="<?php print $exp->id; ?>">
			<span class="glyphicon glyphicon-edit"></span> <?php _e('Edit', 'rrhh'); ?>
		</a>
		<a href="<?php print '#'; ?>" class="btn btn-danger btn-sm btn-delete-we" title="<?php _e('Delete', 'rrhh'); ?>" data-id="<?php print $exp->id; ?>"
			data-message="<?php _e('Are you sure to delete the work experience?', 'rrhh'); ?>">
			<span class="glyphicon glyphicon-trash"></span> <?php _e('Delete', 'rrhh'); ?>
		</a>
		<?php endif; ?>
	</td>
</tr>
<tr>
	<th>Nro. Dependientes</th>
	<th>Nombre Superior</th>
	<th>Cargo Superior</th>
	<th></th>
</tr>
</thead>
<tbody>
<tr>
	<td><?php print $exp->dependent; ?></td>
	<td><?php print $exp->superior_name; ?></td>
	<td><?php print $exp->superior_position; ?></td>
	<td><?php  ?></td>
</tr>
<tr>
	<td>
		<b><?php _e('Main Functions:', 'rrhh'); ?></b><br/>
		<?php print str_replace("\n", "<br/>", $exp->main_functions); ?>
	</td>
	<td>
		<table style="width:100%;">
		<tr>
			<td style="width:50%;"><b><?php _e('Start Date', 'rrhh'); ?></b><br/><?php print sb_format_date($exp->start_date); ?></td>
			<td style="width:50%;"><b><?php _e('End Date', 'rrhh'); ?></b><br/><?php print !((int)$exp->currently_working) ? sb_format_date($exp->end_date) : '---'; ?></td>
		</tr>
		</table>
	</td>
	<td style="text-align:center;">
		<b><?php _e('Total Experiencia', 'rrhh'); ?></b><br/>
		<div >
			<?php 
			if( (int)$exp->currently_working )
			{
				$start_time = strtotime($exp->start_date);
				$current_time = time();
				$diff = $current_time - $start_time;
				print sprintf("%.2f", $diff/31556952);
			}
			else
			{
				print $exp->total_experience;
			} 
			?>
		</div>
	</td>
	<td><b><?php _e('Decouplin Reason', 'rrhh'); ?></b><br/><?php print $exp->decouplin_reason; ?></td>
</tr>
</tbody>
</table> 