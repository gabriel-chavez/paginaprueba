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
	public function GetApplicants($ids = null, $keyword = null, $search_by = null)
	{
		//if( !$this->applicants )
		//{
			$query = "SELECT p.*, 
                            a2p.id AS bid,
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
			$query .= "AND a2p.announcement_id = $this->id ";
			if( $keyword && $search_by )
			{
				if( $search_by == 'name' )
				{
					$query .= "AND first_name LIKE '%$keyword%' ";
				}
				elseif( $search_by == 'fathers_lastname' )
				{
					$query .= "AND fathers_lastname LIKE '%$keyword%' ";
				}
				elseif( $search_by == 'mothers_lastname' )
				{
					$query .= "AND mothers_lastname LIKE '%$keyword%' ";
				}
			}
			$query .= "ORDER BY a2p.creation_date DESC";
			$this->applicants = $this->dbh->FetchResults($query);
			/*
			for($i = 0; $i < count($this->applicants); $i++)
			{
				//##
			}
			*/
			$this->CalculateScore();
		//}
		return $this->applicants;
	}
	protected function CalculateScore()
	{
		//ini_set('display_errors', 1);error_reporting(E_ALL);
		
		//##decode announcement data
		$data = json_decode($this->data);
		$res = $this->GetMaxScore($data);
		//print_r($res);
		list($academic_max_points, $general_max_points, $specific_max_pints) = $res;
		$max_points = (float)$this->total_score;
		for($i = 0; $i < count($this->applicants);$i++)
		{
			$applicant_data = array(
					'academic'				=> array(),
					'specific_experience'	=> array(),
					'general_experience'	=> array()
			);
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
				$query = "SELECT id,company,position,company_industry,dependent,main_functions,start_date,end_date,decouplin_reason,
						currently_working,
						IF(currently_working = 1, CURDATE(), end_date) AS fend_date,
						(DATEDIFF(IF(currently_working = 1, CURDATE(), end_date),start_date)/365) AS total_experience
						FROM rrhh_experience
						WHERE id IN(".implode(',', $experience_ids).")
						AND person_id = {$person->id}";
				//var_dump($query);die();
				$experiences	= $this->dbh->FetchResults($query);
				//##itereate person experiences
				foreach($experiences as $exp)
				{
					$_exp 			= $exp;
					$_exp->points 	= 0;
					//##iterate announcement general experience parameters
					foreach($data->general_experience as $value)
					{
						//##skip if there is no enough value data
						if( !$value->from && !$value->to && !$value->points ) continue;
						if( $exp->total_experience >= $value->from && $exp->total_experience <= $value->to )
						{
							$general_experience_points += (float)$value->points;
							$_exp->points 				= (float)$value->points;
						}	
					}
					$applicant_data['general_experience'][] = $_exp;
				}
			}
			if( $general_experience_points > $general_max_points )
				$general_experience_points = $general_max_points;
			
			//##calculate specific experience
			$experience_ids = json_decode($applicant->specific_experience);
			if( is_array($experience_ids) && count($experience_ids) )
			{
				$query = "SELECT id,company,position,company_industry,dependent,main_functions,start_date,end_date,decouplin_reason,
						currently_working,
						IF(currently_working = 1, CURDATE(), end_date) AS fend_date,
						(DATEDIFF(IF(currently_working = 1, CURDATE(), end_date),start_date)/365) AS total_experience
						FROM rrhh_experience
						WHERE id IN(".implode(',', $experience_ids).")
										AND person_id = {$person->id}";
				$experiences	= $this->dbh->FetchResults($query);
				//##itereate person experiences
				foreach($experiences as $exp)
				{
					$_exp 			= $exp;
					$_exp->points 	= 0;
					foreach($data->specific_experience as $value)
					{
						//##skip is there is enough value data
						if( !(int)$value->from || !(int)$value->to || !(int)$value->points ) continue;
						if( $exp->total_experience >= (int)$value->from && $exp->total_experience <= (int)$value->to )
						{
							$specific_experience_points += (float)$value->points;
							$_exp->points 				= (float)$value->points;
						}	
					}
					
					$applicant_data['specific_experience'][] = $_exp;
				}
				
			}
			if( $specific_experience_points > $specific_max_pints )
				$specific_experience_points = $specific_max_pints;
			
			$applicant->score = $academic_points + $general_experience_points + $specific_experience_points;
			/*
			if( $applicant->score > $max_points )
				$applicant->score = $max_points;
			*/
			$applicant_data['score'] = $applicant->score;
			//##update applicant data
			$this->dbh->Update('rrhh_announcement2person', 
					array('data' => json_encode($applicant_data)), 
					array('announcement_id' => $this->id, 'person_id' => $person->id));
		}
	}
	public function GetScore($person_id)
	{
		
	}
	protected function GetMaxScore($data)
	{
		$max_academic 	= 0;
		$max_general 	= 0;
		$max_specific 	= 0;
		$points = array();
		foreach($data->study_levels as $item)
		{
			$points[] = (float)$item->points;
		}
		$max_academic = max($points);
		$points = array();
		foreach($data->specific_experience as $item)
		{
			$points[] = (float)$item->points;
		}
		$max_specific = max($points);
		$points = array();
		foreach($data->general_experience as $item)
		{
			$points[] = (float)$item->points;
		}
		$max_general = max($points);
		
		return array($max_academic, $max_general, $max_specific);
	}


	public function GetAnnouncements()
	{
		$query = "SELECT id, code, name, end_date FROM rrhh_announcements WHERE status = 'active' ORDER BY id DESC";
		$this->announcements = $this->dbh->FetchResults($query);
		return $this->announcements;
	}
}