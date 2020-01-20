<?php
class RRHH_Person extends SB_ORMObject
{
	protected	$Skills;
	protected	$AcademicRecords;
	protected	$WorkExperience;
	protected	$Experience;
	protected	$PersonalReferences;
	protected 	$WorkReferences;
	protected	$EmploymentReferences;
	protected	$user;
	
	public function __construct($id = null)
	{
		parent::__construct();
		if( $id )
			$this->GetDbData($id);
	}
	public function GetDbData($id)
	{
		$query = "SELECT * FROM rrhh_person WHERE id = $id LIMIT 1";
		$row = $this->dbh->FetchRow($query);
		if( !$row )
			return false;
		$this->_dbData 	= $row;
		$this->user		= new SB_User($this->user_id);
		$this->GetDbMeta();
		$this->GetDbSkills();
		$this->GetDbAcademicRecords();
		$this->GetDbExperience();
	}
	public function GetDbDataByUserId($id)
	{
		$this->user		= new SB_User($id);
		if( !$this->user )
			return false;
		$query = "SELECT * FROM rrhh_person WHERE user_id = $id LIMIT 1";
		$row = $this->dbh->FetchRow($query);
		if( !$row )
			return false;
		$this->_dbData 	= $row;
		$this->user		= new SB_User($this->user_id);
		$this->GetDbMeta();
		$this->GetDbSkills();
		$this->GetDbAcademicRecords();
		$this->GetDbExperience();
		
	}
	public function SetDbData($data)
	{
		$this->_dbData = (object)$data;
	}
	public function GetDbMeta()
	{
		$query = "SELECT * FROM rrhh_person_meta WHERE person_id = $this->id";
		foreach($this->dbh->FetchResults($query) as $row)
		{
			$this->meta[$row->meta_key] = $row->meta_value;
		}
	}
	public function GetDbSkills()
	{
		$query = "SELECT * FROM rrhh_skills WHERE person_id = $this->id ORDER BY creation_date ASC";
		$this->Skills = $this->dbh->FetchResults($query);
	}
	public function GetDbAcademicRecords()
	{
		$query = "SELECT r.*, l.name as study_level FROM rrhh_academic_records r, rrhh_study_levels l 
					WHERE 1 = 1
					AND r.study_level_id = l.id 
					AND r.person_id = $this->id 
					ORDER BY r.creation_date ASC";
		$this->AcademicRecords = $this->dbh->FetchResults($query);
	}
	public function GetDbExperience()
	{
		$query = "SELECT *, IF(end_date = '0000-00-00' AND currently_working = 1, CURDATE(), end_date) AS fend_date,
					(DATEDIFF(end_date,start_date)/365) AS total_experience 
					FROM rrhh_experience 
					WHERE person_id = $this->id 
					ORDER BY fend_date DESC";
		$this->WorkExperience = $this->dbh->FetchResults($query);
	}
	public function GetAcademicRecords()
	{
		if( !$this->AcademicRecords )
			$this->GetDbAcademicRecords();
		return $this->AcademicRecords;
	}
	public function GetWorkExperience()
	{
		if( !$this->WorkExperience )
			$this->GetDbExperience();
		return $this->WorkExperience;
	}
	public function GetPersonalReferences()
	{
		if( !$this->PersonalReferences)
		{
			$query = "SELECT * FROM rrhh_references WHERE person_id = $this->id AND type = 'personal' ORDER BY id ASC";
			$this->PersonalReferences = $this->dbh->FetchResults($query);
		}
		
		return $this->PersonalReferences;
	}
	public function GetWorkReferences()
	{
		if( !$this->EmploymentReferences )
		{
			$query = "SELECT * FROM rrhh_references WHERE person_id = $this->id AND type = 'work' ORDER BY id ASC";
			$this->EmploymentReferences = $this->dbh->FetchResults($query);
		}
	
		return $this->EmploymentReferences;
	}
}