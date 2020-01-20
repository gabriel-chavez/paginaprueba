<?php
function __lt_show_menu_items($items, $class)
{
	foreach($items as $item):
	$link = @$item->link;
	if( @$item->type == 'page' )
	{
		$link = SB_Route::_('index.php?mod=content&view=article&id='.$item->id);
	}
	if( @$item->type == 'section' )
	{
		$link = SB_Route::_('index.php?mod=content&view=section&id='.$item->id);
	}
	?>
		<li>
			<a href="<?php print $link; ?>">
				<?php _e($item->title); ?>
			</a>
			<?php if( isset($item->items) && is_array($item->items)  ): ?>
			<ul class="<?php print $class; ?>"><?php __lt_show_menu_items($item->items, $class); ?></ul>
			<?php endif;?>
		</li>
		<?php endforeach;
}
function lt_show_content_menu($key, $args = array())
{
	$def_args = array(
			'id' 				=> 'navigation-menu',
			'class' 			=> '',
			'menu_item_class' 	=> '',
			'sub_menu_class'	=> 'submenu',
			'print'				=> 1
	);
	$args = array_merge($def_args, $args);
	$menus = (array)sb_get_parameter('menus', array());
	
	if( !isset($menus[$key]) )
		return false;
	
	$menu = $menus[$key];
	ob_start();?>
	<ul id="<?php print $args['id']; ?>" class="<?php print $args['class']; ?>">
		<?php foreach($menu->items as $item): ?>
		<?php
		$link = @$item->link;
		if( @$item->type == 'page' )
		{
			$link = SB_Route::_('index.php?mod=content&view=article&id='.$item->id);
		}
		if( @$item->type == 'section' )
		{
			$link = SB_Route::_('index.php?mod=content&view=section&id='.$item->id);
		} 
		?>
		<li>
			<a href="<?php print $link; ?>" <?php print ( isset($item->items) && is_array($item->items) ) ? 'data-toggle="dropdown"' : ''; ?>>
				<span data-hover="<?php _e($item->title); ?>"><?php _e($item->title); ?></span>
				<?php if( isset($item->items) && is_array($item->items) ): ?>
				<b class="caret"></b>
				<?php endif; ?>
			</a>
			<?php if( isset($item->items) && is_array($item->items)  ): ?>
			<ul class="<?php print $args['sub_menu_class']; ?>"><?php __lt_show_menu_items($item->items, $args['sub_menu_class']); ?></ul>
			<?php endif;?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php 
	$menu = ob_get_clean();
	
	return $args['print'] == 1 ? print $menu : $menu;
}