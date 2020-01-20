<?php
class SB_Sqlite3 extends SB_Database
{
	protected $_dbh;
	protected $_result;
	protected $_rows = 0;
	
	public function __construct($db_name)	
	{
		$this->dbh = $this->_dbh = new SQLite3($db_name);
	}
	public function Query($query)
	{
		$this->_rows = 0;
		$this->lastQuery = $query;
		if( preg_match('/insert|update|delete/isU', $query) )
		{
			//die('query:'.$query);
			$res = $this->_dbh->exec($query);
			if( stristr($query, 'insert') )
			{
				$this->lastId = $this->_dbh->lastInsertRowID();
				return $this->lastId;
			}
			
			return $res;
		}
		
		$this->_result = $this->_dbh->query($query);
		if( !$this->_result )
			throw new Exception("SQLite3 ERROR: " . $this->_dbh->lastErrorMsg() . " QUERY WAS: " . $query);
		while( $this->_result->fetchArray(SQLITE3_ASSOC) )
			$this->_rows++;
		
		return $this->_rows;
	}
	public function FetchResults($query = null)
	{
		if( $query )
			$this->Query($query);
		$res = array();
		if( !$this->_result )
			return $res;
		while( $row = $this->_result->fetchArray(SQLITE3_ASSOC) )
		{
			$res[] = (object)$row;
		}
		
		return $res;
	}
	public function FetchRow($query = null)
	{
		if( $query )
			$this->Query($query);
		
		$row = $this->_result->fetchArray(SQLITE3_ASSOC);
		
		return !$row ? null : (object)$row;
	}
	public function GetVar($query = null, $varname = null)
	{
		$row = $this->FetchRow($query);
		if( !$row )
			return null;
		
		if( $varname && isset($row->$varname))
			return $row->$varname;
		
		return array_shift($row);
	}
	public function NumRows()
	{
		return $this->_rows;
	}
	public function EscapeString($str)
	{
		return $this->_dbh->escapeString($str);
	}
	public function Close()
	{
		$this->_dbh->close();
	}
}