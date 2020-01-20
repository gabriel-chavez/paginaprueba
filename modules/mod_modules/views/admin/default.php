<?php
?>
<div class="wrap">
	<h1 id="page-title"><?php print $page_title; ?></h1>
	<table class="table">
	<thead>
	<tr>
		<th width="40">&nbsp;</th>
		<th><?php print SB_Text::_('Name'); ?></th>
		<th><?php print SB_Text::_('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php if( count($available_modules) ): foreach($available_modules as $mod): ?>
	<tr>
		<td width="80">
			<img src="<?php printf("%s/images/modules_icon.gif", BASEURL);?>" alt="<?php print $mod->Name; ?>" width="40" /></td>
		<td>
			<div><b><?php print $mod->Name; ?></b></div>
			<p><?php print $mod->Description; ?></p>
			<p>
				<?php print SB_Text::_('Author:') ?> <a href="<?php print !empty($mod->Website) ? $mod->Website : '#'; ?>" target="_blank">
				<?php print $mod->Author; ?></a></p>
		</td>
		<td>
			<?php if( in_array($mod->Id, $enabled_modules) ): ?>
			<a href="<?php print SB_Route::_('index.php?mod=modules&task=disable_module&the_mod='.$mod->Id) ?>" class="btn btn-danger btn-xs">
				<?php print SB_Text::_('Disable'); ?>
			</a>
			<?php else: ?>
			<a href="<?php print SB_Route::_('index.php?mod=modules&task=enable_module&the_mod='.$mod->Id) ?>" class="btn btn-primary btn-xs">
				<?php print SB_Text::_('Enable'); ?>
			</a>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; else: ?>
	<tr><td colspan="2"><?php print SB_Text::_('There are no modules installed'); ?></td></tr>
	<?php endif; ?>
	</tbody>
	</table>
</div><!-- end class="container" -->