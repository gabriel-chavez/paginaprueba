<?php
class LT_HelperContent
{
	public static function GetSections($parent_id = null)
	{
		$parent_id = (int)$parent_id;
		$dbh = SB_Factory::getDbh();
		$query = "SELECT * FROM section WHERE 1 = 1 ";
		if( $parent_id !== null )
		{
			$query .= "AND parent_id = $parent_id ";
		}
		$query .= "ORDER BY show_order ASC";
		$dbh->Query($query);
		
		$sections = array();
		foreach($dbh->FetchResults() as $row)
		{
			$s = new LT_Section();
			$s->SetDbData($row);
			$sections[] = $s;
		}
		return $sections;
	}
	public static function GetArticles($args = array())
	{
		$def_args = array(
				'status'		=> 'publish',
				'section_id' 	=> null,
				'publish_date'	=> true,
				'end_date'		=> true,
				'order_by'		=> 'creation_date',
				'order'			=> 'DESC', 
				'page' 			=> 1, 
				'type'			=> 'page',
				'lang'			=> LANGUAGE,
				'rows_per_page' => 20,
				'meta'			=> array()
		);
		$we_need_meta = false;
		$args = array_merge($def_args, $args);
		extract($args);
		
		$columns = array(
				'c.*'
		);
		$tables = array(
				'content c',
				//'content_meta cm'
		);
		
		$where = array(
				"c.status = '$status'",
				"c.type = '{$args['type']}'",
				"c.lang_code = '{$args['lang']}'"
		);
		if( $publish_date != null )
		{
			if( $publish_date === true )
			{
				//TODO: fix this sql statement to be complatible with other engines
				//$where[] = "DATE(IF(c.publish_date IS NULL, NOW(), c.publish_date)) <= DATE(NOW())";
				$where[] = "DATE(c.publish_date) <= DATE(NOW())";
			}
			else 
			{
				$where[] = "c.publish_date = DATE($publish_date)";
			}
		}
		if( $end_date != null )
		{
			if( $end_date === true )
			{
				//TODO: fix this sql statement to be complatible with other engines
				//$where[] = "DATE(IF(c.end_date IS NULL,NOW(),c.end_date)) >= DATE(NOW())";
				$where[] = "DATE(c.end_date) >= DATE(NOW())";
			}
			else
			{
				$where[] = "c.end_date = DATE($end_date)";
			}
		}
		//##check for metas
		if( isset($args['meta']) && is_array($args['meta']) )
		{
			$we_need_meta = true;
			$mi = 1;
			foreach($args['meta'] as $mquery)
			{
				$tables[] = "content_meta cm{$mi}";
				$where[] = "c.content_id = cm{$mi}.content_id";
				$where[] = "(cm{$mi}.meta_key = '{$mquery['meta_key']}' AND cm{$mi}.meta_value = '{$mquery['meta_value']}')";
				$mi++;
			}
		}
		$columns 	= SB_Module::do_action('query_columns_articles', $columns);
		$tables 	= SB_Module::do_action('query_tables_articles', $tables);
		$where 		= SB_Module::do_action('query_where_articles', $where);
		$dbh 		= SB_Factory::getDbh();
		
		if( (int)$section_id > 0 && $type == 'page')
		{
			$tables[] 	= "section2content s2c";
			$where[]	= "c.content_id = s2c.content_id";
			$where[] 	= "s2c.section_id = $section_id";
		}
		if( isset($category_id) && (int)$category_id > 0 && $type == 'post')
		{
			$tables[] 	= "category2content c2c";
			$where[]	= "c.content_id = c2c.content_id";
			$where[] 	= "c2c.category_id = $category_id";
		}
		$query = "SELECT ".implode(',', $columns)." FROM ". implode(',', $tables) . 
					" WHERE 1 = 1 AND " . implode(' AND ', $where);
		$total_rows 	= $dbh->Query($query);
		$total_pages = 0;
		$offset = 0;
		if( $rows_per_page > 0 )
		{
			$total_pages 	= ceil($total_rows / $rows_per_page);
			$offset 		= ($page == 1) ? 0 : ($page - 1) * $rows_per_page;
		}
		$query 			= SB_Module::do_action('query_articles', $query);
		$query .= " ORDER BY c.$order_by $order ";
		$dbh->builtQuery = $query;
		if( $rows_per_page > 0 )
		{
			$dbh->Limit($rows_per_page, $offset);
		}
		//var_dump($dbh->builtQuery);
		$dbh->Query(null);
		$articles = array();
		foreach($dbh->FetchResults() as $row)
		{
			$a = new LT_Article();
			$a->SetDbData($row);
			$a->GetDbSections();
			$articles[] = $a;
		}
		return array('articles' => $articles, 'total_rows' => $total_rows, 'total_pages' => $total_pages);
	}
	public static function GetArticle($by, $key)
	{
		if( $by == 'id' )
		{
			return new LT_Article((int)$key);
		}
		elseif( $by == 'slug' )
		{
			$dbh = SB_Factory::getDbh();
			$query = "SELECT * FROM content WHERE slug = '$key' LIMIT 1";
			if( $dbh->Query($query) )
			{
				$article = new LT_Article();
				$article->SetDbData($dbh->FetchRow());
				return $article;
			}
		}
		return null;
	}
	/**
	 * 
	 * @param unknown $slug
	 * @return NULL|LT_Article
	 */
	public static function GetPageBySlug($slug)
	{
		$query = "SELECT * FROM content WHERE slug = '$slug' AND type = 'page' AND status = 'publish' LIMIT 1";
		$row = SB_Factory::getDbh()->FetchRow($query);
		
		if( !$row )
			return null;
		
		$page = new LT_Article();
		$page->SetDbData($row);
		return $page;
	}
}