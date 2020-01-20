<?php
class LT_TableList extends SB_Object
{
	protected	$table;
	/**
	 * The table primary key column name
	 * @var string
	 */
	protected	$column_id;
	protected	$module			= '';
	protected	$itemsPerPage 	= 25;
	protected	$columns 		= array();
	protected	$rowActions		= array(
										'edit' 		=> array(
												'link' 	=> '', 
												'label' => 'Edit', 
												'icon' 	=> 'glyphicon glyphicon-edit'
										),
										'delete' 	=> array(
												'link' => '', 
												'label' => 'Delete', 
												'icon' => 'glyphicon glyphicon-trash'
										)
	);
	protected	$items			= array();
	protected	$showSelector	= true;
	protected	$showCount		= true;
	protected	$dbh;
	protected	$dbColumns		= array();
	protected	$query			= null;
	protected	$order			= 'desc';
	protected	$order_by		= null;
	
	public function __construct($table, $column_id, $mod = 'unknow')
	{
		$this->table 		= $table;
		$this->column_id	= $column_id;
		$this->module		= $mod;
		$this->dbh			= SB_Factory::getDbh();
	}
	public function SetColumns($columns)
	{
		$this->columns = (array)$columns;
	}
	public function SetRowActions($actions)
	{
		$this->rowActions = $actions;
	}
	public function SetQuery($query)
	{
		$this->query = $query;
	}
	public function Fill()
	{
		$page		= SB_Request::getInt('page', 1);
		$search_by 	= SB_Request::getString('search_by');
		$keyword 	= SB_Request::getString('keyword');
		if( $page <= 0 )
			$page = 1;
		$this->currentPage	= $page;
		
		foreach($this->columns as $db_col => $data)
		{
			if( isset($data['db_col']) && !$data['db_col'] ) continue;
			if( isset($data['subquery']) && !empty($data['subquery']) )
			{
				$this->dbColumns[] = "({$data['subquery']}) AS $db_col";
			}
			else
			{
				$this->dbColumns[] = $db_col;
			}
		}
		$this->dbh->Select('COUNT(*)')
					->From($this->table);
		//##check if there is a search request
		if( $keyword && $search_by && $search_by != '-1' )
		{
			if( $search_by )
			{
				$this->dbh->Where(null);
				$this->dbh->SqlAND(array($search_by => $keyword), 'LIKE', '%', '%');
			}
			
		}
		$this->dbh->Query(null);
		$total_rows	= (int)$this->dbh->GetVar(null);
		if( !$total_rows )
			return true;
		$this->totalPages 	= ceil($total_rows / $this->itemsPerPage);
		$offset				= $page == 1 ? 0 : ($page - 1) * $this->itemsPerPage;
		
		if( $this->query )
		{
			$query = str_replace(array('{columns}', '{limit}', '{offset}'), 
								array(implode(',', $this->dbColumns), $this->itemsPerPage, $offset), 
								$this->query);
			die($query);
		}
		else
		{
			$this->dbh->Select($this->dbColumns)
						->From($this->table)
						->Where(null);
			//##check if there is a search request
			if( $keyword && $search_by && $search_by != '-1' )
			{
				$this->dbh->SqlAND(array($search_by => $keyword), 'LIKE', '%', '%');
			}
			$this->dbh->OrderBy($this->order_by ? $this->order_by : $this->column_id, $this->order)
						->Limit($this->itemsPerPage, $offset);
			$this->dbh->Query(null);
			$this->items	= $this->dbh->FetchResults();
			
		}
		
		
		
	}
	public function Show()
	{
		$current_view = SB_Request::getString('view', 'default');
		?>
		<table class="table table-condensed">
		<thead>
		<tr>
			<?php if( $this->showSelector ): ?>
			<th class="col-selector text-center"><input type="checkbox" name="cb_selector" value="1" class="tcb-select-all" /></th>
			<?php endif; ?>
			<?php if( $this->showCount ): ?>
			<th class="col-count text-center"><?php _e('Num', 'lt'); ?></th>
			<?php endif; ?>
			<?php foreach($this->columns as $db_col => $col): if( isset($col['show']) && !$col['show'] ) continue; ?>
			<th class="db-col-<?php print $db_col; ?>"><?php print $col['label']; ?></th>
			<?php endforeach; ?>
			<th class="col-actions"><?php _e('Actions', 'lt'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if( is_array($this->items) && count($this->items) ): $i = 1; foreach($this->items as $item): SB_Module::do_action('table_list_before_show_item', $item); ?>
		<tr <?php foreach($item as $prop => $value){print "data-$prop=\"$value\" ";}?>>
			<?php if( $this->showSelector ): ?>
			<td class="col-selector text-center"><input type="checkbox" name="ids[]" value="<?php print $item->{$this->column_id}?>" class="tcb-select" /></td>
			<?php endif; ?>
			<?php if( $this->showCount ): ?>
			<td class="col-count text-center"><?php print $i; ?></td>
			<?php endif; ?>
			<?php foreach($this->columns as $db_col => $col): if( isset($col['show']) && !$col['show'] ) continue; ?>
			<td class="db-col-<?php print $db_col; ?> <?php print isset($col['class']) ? $col['class'] : ''; ?>">
				<?php 
				$res = '';
				if( isset($col['callback']) )
				{
					if( isset($item->$db_col) )
						$res = call_user_func($col['callback'], $item->$db_col);
					else
						$res = call_user_func($col['callback'], $item);
				}
				elseif( isset($item->$db_col) )
					$res = $item->$db_col;
				else 
					$res = '';
				print $res;
				?>
			</td>
			<?php endforeach; ?>
			<td class="col-actions">
				<?php foreach($this->rowActions as $_action => $data): ?>
				<?php
				$action = $_action;
				$link = "mod=$this->module&";
				if( strstr($_action, ':') )
				{
					list($arg, $value) = explode(':', $_action);
					$link .= "$arg=$value&";
					$action = $value;
				}
				else
				{
					$link .= "view=$action&";
				} 
				$link .= "id=" . $item->{$this->column_id};
				$link = SB_Route::_('index.php?'.$link);
				?>
				<a href="<?php print $link; ?>" class="btn btn-default btn-sm btn-action-<?php print $action; ?> <?php print @$data['class']; ?>" 
					<?php print isset($data['icon']) ? 'title="'.$data['label'].'"' : ''; ?>
					<?php if( isset($data['data']) ) foreach((array)$data['data'] as $key => $d) print "data-$key=\"$d\" "; ?>>
					<?php if( isset($data['icon']) ): ?>
					<span class="<?php print $data['icon']; ?>"></span>
					<?php else: ?>
					<span><?php print $data['label']; ?></span>
					<?php endif; ?>
				</a>
				<?php endforeach; ?>
			</td>
		</tr>
		<?php $i++; endforeach;else: ?>
		<tr>
			<td colspan="<?php print count($this->columns); ?>"><?php _e('There are no records found yet', 'lt'); ?></td>
		</tr>
		<?php endif; ?>
		</tbody>
		</table>
		<p>
			<?php print lt_pagination($_SERVER['REQUEST_URI'], $this->totalPages, $this->currentPage); ?>
		</p>
		<?php 
	}
}