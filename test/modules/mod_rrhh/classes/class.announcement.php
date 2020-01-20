<?php
class RRHH_Announcement extends SB_ORMObject
{
	protected	$applicants;
	protected	$persons;
	
	public function __construct($id)
	{
		parent::__construct();
		if( $id )
			$this->GetDbData($id);
	}
	public function GetDbData($id)
	{
		$query = "SELECT * FROM rrhh_announcements WHERE id = $id LIMIT 1";
		$row = $this->dbh->FetchRow($query);
		if( !$row )
			return false;
		$this->_dbData = $row;
	}
	public function SetDbData($data)
	{
		$this->_dbData = (object)$data;
	}
	public function GetData()
	{
		return json_decode($this->data);
	}
	public function GetApplicants($ids = null)
	{
		if( !$this->applicants )
		{
			$query = "SELECT p.*, 
							a2p.salary_pretension,
							a2p.inmediate_availability, 
							a2p.days,
							a2p.general_experience,
							a2p.specific_experience, 
							a2p.data, 
							a2p.creation_date AS date_application
						FROM rrhh_person p, rrhh_announcement2person a2p
						WHERE 1 = 1
						AND p.id = a2p.person_id ";
			if( is_array($ids) && count($ids) )
			{
				$query .= "AND a2p.person_id IN(".implode(',', $ids).")";
			}
			$query .= "AND a2p.announcement_id = $this->id
						ORDER BY a2p.creation_date DESC";
			$this->applicants = $this->dbh->FetchResults($query);
			/*
			for($i = 0; $i < count($this->applicants); $i++)
			{
				//##
			}
			*/
			$this->CalculateScore();
		}
		return $this->applicants;
	}
	protected function CalculateScore()
	{
		$applicant_data = array(
				'academic'				=> array(),
				'specific_experience'	=> array(),
				'general_experience'	=> array()
		);
		$academic_max_points = 10;
		//##decode announcement data
		$data = json_decode($this->data);
		//print_r($data->study_levels);
		for($i = 0; $i < count($this->applicants);$i++)
		{
			$academic_points 			= 0;
			$specific_experience_points	= 0;
			$general_experience_points	= 0;
			$applicant  		=& $this->applicants[$i];
			$person				= new RRHH_Person($applicant->id);
			$academic			= $person->GetAcademicRecords();
			foreach($academic as $rec)
			{
				if( isset($data->study_levels->{'id_'.$rec->study_level_id}) )
				{
					$academic_points += $data->study_levels->{'id_'.$rec->study_level_id}->points;
					$applicant_data['academic']['id_'.$rec->id] = array(
							'id'		=> $rec->id,
							'name'		=> $data->study_levels->{'id_'.$rec->study_level_id}->name,
							'points'	=> $data->study_levels->{'id_'.$rec->study_level_id}->points
					);
				}
			}
			//##truncate the academic point to max
			if( $academic_points > $academic_max_points )
			{
				$academic_points = $academic_max_points;
			}
			//##calculate general experience
			$experience_ids = json_decode($applicant->general_experience);
			if( is_array($experience_ids) && count($experience_ids) )
			{
				$query = "SELECT id,company,position,company_industry,dependent,main_functions,start_date,end_date,decouplin_reason,currently_working,
						(DATEDIFF(end_date,start_date)/365) AS total_experience
						FROM rrhh_experience
						WHERE id IN(".implode(',', $experience_ids).")
										AND person_id = {$person->id}";
					
				$experiences	= $this->dbh->FetchResults($query);
				foreach($data->general_experience as $value)
				{
					//##skip is there is enough value data
					if( !$value->from && !$value->to && !$value->points ) continue;
					//##itereate person experiences
					foreach($experiences as $exp)
					{
						if( $exp->total_experience >= $value->from && $exp->total_experience <= $value->to )
						{
							$general_experience_points += (float)$value->points;
							$_exp = $exp;
							$_exp->points = (float)$value->points;
							$applicant_data['general_experience'][] = $_exp;
						}
					}
				}
			}
			
			//##calculate specific experience
			$experience_ids = json_decode($applicant->specific_experience);
			if( is_array($experience_ids) && count($experience_ids) )
			{
				$query = "SELECT id,company,position,company_industry,dependent,main_functions,start_date,end_date,decouplin_reason,currently_working,
						(DATEDIFF(end_date,start_date)/365) AS total_experience
						FROM rrhh_experience
						WHERE id IN(".implode(',', $experience_ids).")
										AND person_id = {$person->id}";
				$experiences	= $this->dbh->FetchResults($query);
				foreach($data->specific_experience as $value)
				{
					//##skip is there is enough value data
					if( !$value->from && !$value->to && !$value->points ) continue;
					//##itereate person experiences
					foreach($experiences as $exp)
					{
						if( $exp->total_experience >= $value->from && $exp->total_experience <= $value->to )
						{
							$specific_experience_points += (float)$value->points;
							$_exp = $exp;
							$_exp->points = (float)$value->points;
							$applicant_data['specific_experience'][] = $_exp;
						}
					}
				}
			}
			
			
			$applicant->score = $academic_points + $specific_experience_points;
			//##update applicant data
			$this->dbh->Update('rrhh_announcement2person', array('data' => json_encode($applicant_data)), array('id' => $this->id));
		}
	}
	public function GetScore($person_id)
	{
		
	}
}