<?php
/**
 * 
 * @author marcelo
 *
 * @property int attachment_id
 * @property string title
 * @property string description
 * @property string mime
 * @property string file
 * @property int size
 * @property int parent
 * @property datetime last_modification_date
 * @property datetime creation_date
 */
class SB_Attachment extends SB_ORMObject
{
	public function __construct($id = null)
	{
		parent::__construct();
		if( $id )
			$this->GetDbData($id);
	}
	public function GetDbData($id)
	{
		$query = "SELECT * FROM attachments WHERE attachment_id = $id";
		if( !$this->dbh->Query($query) )
		{
			return null;
		}
		$this->_dbData = $this->dbh->FetchRow();
	}
	public function SetDbData($data)
	{
		$this->_dbData = $data;
	}
}