<?php
/**
 * 
 * @author marcelo
 *
 *@property int $user_id
 *@property	string $first_name
 *@property string $last_name
 *@property string $username
 *@property string $email
 *@property string $status
 *@property int role_id
 *@property string role_name
 *@property string role_key
 *@property string $creation_date
 */
class SB_User extends SB_ORMObject
{
	protected $_dbData = null;
	protected $_permissions = array();
	protected $_meta = array();
	
	public function __construct($user_id = null)
	{
		if( $user_id )
			$this->getData($user_id);
	}
	public function getData($user_id){$this->GetDbData($user_id);}
	public function GetDbData($user_id)
	{
		$dbh = SB_Factory::getDbh();
		//$query = "SELECT * FROM users u, user_roles r WHERE u.user_id = $user_id AND u.role_id = r.role_id";
		$query = "SELECT u.*, r.role_name, r.role_description, r.role_key FROM users u LEFT JOIN user_roles r ON u.role_id = r.role_id WHERE u.user_id = $user_id";
		$res = $dbh->Query($query);
		if( !$res )
			return false; 
		$this->_dbData = $dbh->FetchRow();
		//check for root
		if( (int)$this->_dbData->role_id === 0 )
		{
			$this->role_id = 0;
			$this->role_name = 'root';
			$this->role_description = 'root';
		}
		$this->GetDbMeta();
		$this->GetDbPermissions();
		
	}
	public function GetDbMeta()
	{
		$dbh = SB_Factory::getDbh();
		//get user meta
		$query = "SELECT meta_id, meta_key, meta_value, creation_date FROM user_meta WHERE user_id = $this->user_id";
		if( $dbh->Query($query) )
		{
			foreach($dbh->FetchResults() as $row)
			{
				$this->_meta[$row->meta_key] = trim($row->meta_value);
			}
		}
	}
	public function GetDbPermissions()
	{
		if( !$this->role_id )
			return false;
		$dbh = SB_Factory::getDbh();
		//get user permissions based on role
		$query = "SELECT p.* FROM role2permission r2p, permissions p WHERE r2p.role_id = $this->role_id AND r2p.permission_id = p.permission_id";
		$res = $dbh->Query($query);
		$permissions = $dbh->FetchResults();
		foreach($permissions as $cap)
		{
			$this->_permissions[] = $cap->permission;
		}
	}
	public function SetDbData($data)
	{
		if( !is_object($data) )
			return false;
		$this->_dbData = $data;
		if( (int)$this->_dbData->role_id === 0 )
		{
			$this->role_id = 0;
			$this->role_name = 'root';
			$this->role_description = 'root';
		}
		if( empty($this->_meta) )
			$this->GetDbMeta();
	}
	/**
	 * Check if user has a permission
	 * 
	 * @param string $permission
	 * @return boolean
	 */
	public function can($permission)
	{
		//check for root user
		if( (int)$this->role_id === 0 || $this->role_key == 'superadmin')
		{
			return true;
		}
		return in_array($permission, $this->_permissions);
	}
	public function __get($var)
	{
		if( is_object($this->_dbData) && property_exists($this->_dbData, $var) )
		{
			return $this->_dbData->$var;
		}
		if( isset($this->_meta[$var]) )
		{
			return $this->_meta[$var];
		}
		if( isset($this->$var) )
			return $this->$var;
	}
	public function __set($var, $value)
	{
		if( is_object($this->_dbData) && property_exists($this->_dbData, $var) )
		{
			$this->_dbData->$var = $value;
			return true;
		}
		return parent::__set($var, $value);
	}
	public static function updateMeta($user_id, $meta_key, $meta_value)
	{
		SB_Meta::updateMeta('user_meta', $meta_key, $meta_value, 'user_id', $user_id);
	}
	public function IsRoot()
	{
		return $this->role_id === 0 && $this->username === 'root';
	}
}
