<?php
class SB_Meta
{
	public static function addMeta($table, $meta_key, $meta_value, $key_field, $key_field_id)
	{
		$date = date('Y-m-d H:i:s');
		$dbh = SB_Factory::getDbh();
		if( is_object($meta_value) || is_array($meta_value) )
			$meta_value = json_encode($meta_value);
		else
			$meta_value = trim($meta_value);//$dbh->EscapeString($meta_value);
		
		return $dbh->Insert($table, array($key_field => $key_field_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value, 'creation_date' => $date));
	}
	public static function getMeta($table, $meta_key, $key_field, $key_field_id, $default = null, $multiple = false)
	{
		$dbh = SB_Factory::getDbh();
		$key_field_id = is_numeric($key_field_id) ? $key_field_id :"'$key_field_id'"; 
		$query = "SELECT meta_key, meta_value FROM $table WHERE meta_key = '$meta_key' AND $key_field = $key_field_id";
		$count = $dbh->Query($query);
		if( !$count )
			return $default;
		if( !$multiple )
		{
			$row = $dbh->FetchRow();
			$res = json_decode($row->meta_value);
			if( is_array($res) || is_object($res) )
				return $res;
			return $row->meta_value;
		}
		
		return $dbh->FetchResults();
		
	}
	public static function updateMeta($table, $meta_key, $meta_value, $key_field, $key_field_id)
	{
		if( $meta_value === null )
		{
			self::deleteMeta($table, $meta_key, $key_field, $key_field_id);
			return true;
		}
		if( self::getMeta($table, $meta_key, $key_field, $key_field_id, null) === null )
		{
			return self::addMeta($table, $meta_key, $meta_value, $key_field, $key_field_id);
		}
		else 
		{
			$dbh = SB_Factory::getDbh();
			if( is_object($meta_value) || is_array($meta_value) )
				$meta_value = json_encode($meta_value);
			else 
				$meta_value	= trim($meta_value);
			
			$dbh->Update($table, array('meta_value' => $meta_value), array('meta_key' => $meta_key, $key_field => $key_field_id));
		}
	}
	public static function deleteMeta($table, $meta_key, $key_field, $key_field_id)
	{
		$dbh = SB_Factory::getDbh();
		$dbh->Query("DELETE FROM $table WHERE $key_field = '$key_field_id' AND meta_key = '$meta_key'");
		return true;
	}
}