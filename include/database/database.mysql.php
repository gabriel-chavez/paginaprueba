<?php
class SB_MySQL extends SB_Database 
{
	protected 	$link = false;
	//protected	$dbh;
	protected 	$errorCode;
	protected 	$error;
	protected 	$result;
	protected	$isMySqlI = false;
	
	public function __construct($server, $username, $password, $database = null)
	{
		$this->db_type = 'mysql';
		//$this->link = mysql_pconnect($server, $username, $password);
		//$this->link = mysql_connect($server, $username, $password);
		if( class_exists('mysqli') )
		{
			$this->isMySqlI = true;
			$this->dbh	= new mysqli($server, $username, $password, $database);
		}
		else
		{
			$this->dbh = mysql_connect($server, $username, $password);
			if( $this->dbh && $database )
				$this->selectDB($database);
		}
		if( !$this->dbh )
		{
			throw new Exception("Fatal error: cannot connect to database server");
		}
		// No afectará a $mysqli->real_escape_string();
		//$this->dbh->query("SET NAMES utf8");
		$this->Query("SET NAMES utf8");
		
		// No afectará a $mysqli->real_escape_string();
		//$this->dbh->query("SET CHARACTER SET utf8");
		$this->Query("SET CHARACTER SET utf8");
		
		// Pero esto sí afectará a $mysqli->real_escape_string();
		$this->isMySqlI ? $this->dbh->set_charset('UTF8') : mysql_set_charset('UTF8');
		$this->lcw = '`';
		$this->rcw = '`';
	}
	public function selectDB($database)
	{
		$res = false;
		if( $this->isMySqlI )
		{
			$res = $this->dbh->select_db($database);
		}
		else
		{
			$res = mysql_select_db($database, $this->dbh);
		}
		if($res == false)
		{
			throw new Exception("Fatal error: cannot connect to database '$database' or database 
								does not exists.");
		}
	}
	public function getErrorCode()
	{
		return $this->errorCode;
	}
	public function Query($query)
	{
		$query = !$query ? $this->builtQuery : $query;
		
		$query = trim($query);
		$this->lastQuery = $query;
		//$this->result = mysql_query($query, $this->link);
		if( $this->isMySqlI )
		{
			$this->result	= $this->dbh->query($query);
		}
		else
		{
			$this->result = mysql_query($query, $this->dbh);
		}
		if( !$this->result )
		{
			
			if( $this->isMySqlI )
			{
				$this->errorCode = $this->dbh->errno;
				$this->error = $this->dbh->error;
			}
			else
			{
				$this->errorCode = mysql_errno($this->dbh);
				$this->error	= mysql_error($this->dbh);
				
			}
			if( $this->debug )
				error_log("MySQL Error: $this->error\n Error code: $this->errorCode Query: $query\n", 3, LOG_FILE);
			throw new Exception( 'Error['.$this->errorCode.']: '. $this->error . ' Your query was: ' .$query );
			
		}
		$pattern = '/^[update|delete]/isU';
		$res = preg_match($pattern, $query, $matches);
		if( $res > 0)
			return $this->isMySqlI ? $this->dbh->affected_rows : mysql_affected_rows($this->dbh);
			
		$res = preg_match('/^insert/isU', $query, $matches);
		if( $res > 0 )
		{
			$this->lastId = $this->isMySqlI ? $this->dbh->insert_id : mysql_insert_id($this->dbh); 
			return $this->lastId;
		}
			
		$res = preg_match('/^select/isU', $query, $matches);
		if( $res > 0 )
			return $this->isMySqlI ? $this->result->num_rows : mysql_num_rows($this->result);
			
		return $this->result;
	}
	public function Close()
	{
		$this->isMySqlI ? $this->dbh->close() : mysql_close($this->dbh);
	}
	public function FetchArray( $type = MYSQL_ASSOC)
	{
		return $this->isMySqlI ? $this->result->fetch_array($type) : mysql_fetch_array($this->result, $type);
		//return mysql_fetch_array($this->result, MYSQL_ASSOC);
	}
	public function FetchRow($query = null)
	{
		if( $query != null )
			$this->Query($query);
		return $this->isMySqlI ? $this->result->fetch_object() : mysql_fetch_object($this->result);
	}
	public function GetVar($query = null, $varname = null)
	{
		if( $query != null )
		{
			if( !$this->Query($query))
				return null;
		}
		
		$row = $this->FetchArray(MYSQL_BOTH);
		
		if( $varname && isset($row[$varname]))
			return $row[$varname];
		
		return $row[0];
	}
	public function NumRows()
	{
		return $this->isMySqlI ? $this->result->num_rows : mysql_num_rows($this->result);
	}
	public function getVarFromQuery($query, $varname)
	{
		$this->Query($query);
		
		return $this->GetVar($varname);
	}
	public function FetchObject($class = null)
	{
		if( !$class )
			return $this->isMySqlI ? $this->result->fetch_object() : mysql_fetch_object($this->result);
		
		return $this->isMySqlI ? $this->result->fetch_object($class != null ? $class : null) : mysql_fetch_object($this->result, $class != null ? $class : null);
	}
	public function FetchResults($query = null)
	{
		if( $query != null )
			$this->Query($query);
		
		$results = array();
		while( $row = $this->FetchObject() )
		{
			$results[] = $row;
		}
		return $results;
	}
	/*
	public function fetch_all_into_array_from_query($query)
	{
		return $this->fetch_all_into_array($this->query($query));
	}
	public function fetch_object_from_query($query)
	{
		$this->query($query);
		return mysql_fetch_object($this->result);
	}
	
	public function fetch_all_into_object()
	{
		$results = array();
		while($row = $this->FetchObject() )
		{
			$results[] = $row;
		}
		return $results;
	}
	
	public function fetch_all_into_object_from_query($query)
	{
		return $this->fetch_all_into_object($this->query($query));
	}
	*/
	public function EscapeString($string)
	{
		return $this->isMySqlI ? $this->dbh->real_escape_string($string) : mysql_real_escape_string($string, $this->dbh);
	}
	public function escapeArray(array $array)
	{
		if(is_array($array))
		{
			$escapedArray = array();
			foreach($array as $index => $value)
			{
				$escapedArray[$index] = $this->escapeString($value);
			}
			return $escapedArray;
		}
	}
	public function AffectedRows($in_ResulSet)
	{
		return mysql_affected_rows();
	}
	public function getNextId($table, $columnId)
	{
		$query = "SELECT MAX($columnId) id FROM $table";
		$res = $this->Query($query);
		$rows = $this->NumRows($res);
		if($rows <= 0 )
		{
			return 1;
		}
		$row = $this->FetchArray($res);
		return  $row["id"] + 1;
	}
	public function beginTransaction()
	{
		$this->Query("BEGIN");
	}
	public function commit()
	{
		$this->Query("COMMIT");
	}
	public function rollBack()
	{
		$this->Query("ROLLBACK");
	}
	public function getConnection()
	{
		return $this->link;
	}
	public function setResource($res)
	{
		$this->result = $res;
	}
	public function getResource()
	{
		return $this->result;
	}
	/**
	 * (non-PHPdoc)
	 * @see SB_Database::Select()
	 * @return SB_Database
	 */
	public function Select($columns)
	{
		$sql_cols = $this->SanitizeColumns($columns);
		$this->builtQuery = sprintf("SELECT %s ", implode(',', $sql_cols));
		return $this;
	}
	public function From($tables)
	{
		if( is_array($tables) )
		{
			$this->builtQuery .= "FROM " . implode(',', $tables) . " ";
		}
		else 
		{
			$this->builtQuery .= "FROM $tables ";
		}
		return $this;
	}
	/**
	 *
	 * @param string $column
	 * @return SB_Database
	 */
	public function OrderBy($column, $order = 'desc')
	{
		$this->builtQuery .= "ORDER BY $column $order ";
		return $this;
	}
	public function Limit($limit, $offset)
	{
		$this->builtQuery .= "LIMIT $offset,$limit";
		return $this;
	}
}