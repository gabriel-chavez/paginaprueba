<?php
class LT_AdminControllerRrhhAnnouncements extends SB_Controller
{
	public function task_default()
	{
		$table = new LT_TableList('rrhh_announcements a', 'id', 'rrhh');
		$subquery = "SELECT COUNT(id) FROM rrhh_announcement2person a2p WHERE a.id = a2p.announcement_id";
		$table->SetColumns(array(
				'id'					=> array('label' => __('ID')),
				'code'					=> array('label' => __('Code', 'rrhh')),
				'name'					=> array('label' => __('Name', 'rrhh')),
				'status'				=> array('label' => __('Status', 'rrhh'), 'callback' => 'rrhh_show_announcement_status'),
				'start_date'			=> array('label' => __('Start Date', 'rrhh')),
				'end_date'				=> array('label' => __('End Date', 'rrhh')),
				'applicants'			=> array('label' => __('Applicants', 'rrhh'), 'class' => 'text-center', 'subquery' => $subquery),
				'creation_date'			=> array('label' => __('Creation Date', 'rrhh')),
		));
		$table->order_by = 'creation_date';
		$table->SetRowActions(array(
				'view:announcements.edit'		=> array('label' => __('Edit', 'rrhh'), 'icon' => 'glyphicon glyphicon-edit'),
				'view:announcements.applicants'	=> array('label' => __('See Applicants', 'rrhh'), 'icon' => 'glyphicon glyphicon-ok'),
				'task:announcements.delete'		=> array('label' => __('Delete', 'rrhh'), 'icon' => 'glyphicon glyphicon-trash', 'class' => 'confirm')
		));
		/*
		$query = "SELECT {columns} 
					FROM rrhh_announcements a 
					LEFT JOIN rrhh_announcement2person a2p ON a2p.announcement_id = a.id
					LIMIT {limit}, {offset}";
		$table->SetQuery($query);
		*/
		$table->Fill();
		sb_set_view_var('table', $table);
	}
	public function task_new()
	{
		$study_levels = $this->dbh->FetchResults("SELECT * FROM rrhh_study_levels ORDER BY id ASC");
		lt_add_tinymce();
		$title = __('New Announcement', 'rrhh');
		sb_set_view_var('study_levels', $study_levels);
		$this->document->SetTitle($title);
	}
	public function task_edit()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('Invalid announcement identifier', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
		}
		$obj = new RRHH_Announcement($id);
		if( !$obj->id )
		{
			SB_MessagesStack::AddMessage(__('The announcement does not exists', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
		}
		sb_set_view('announcements.new');
		$study_levels = $this->dbh->FetchResults("SELECT * FROM rrhh_study_levels ORDER BY id ASC");
		lt_add_tinymce();
		sb_set_view_var('obj', $obj);
		sb_set_view_var('data', $obj->GetData());
		sb_set_view_var('study_levels', $study_levels);
		$title = __('Edit Announcement', 'rrhh');
		$this->document->SetTitle($title);
	}
	public function task_delete()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('Invalid announcement identifier', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
		}
		$obj = new RRHH_Announcement($id);
		if( !$obj->id )
		{
			SB_MessagesStack::AddMessage(__('The announcement does not exists', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
		}
		$this->dbh->Delete('rrhh_anouncements', array('id' => $id));
		SB_MessagesStack::AddMessage(__('The announcement has been deleted', 'rrhh'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
	}
	public function task_save()
	{
		$id 			= SB_Request::getInt('id');
		$code			= SB_Request::getString('code');
		$name 			= SB_Request::getString('name');
		$description 	= SB_Request::getString('description');
		$start_date		= SB_Request::getDate('start_date');
		$end_date		= SB_Request::getDate('end_date');
		$vacancies		= SB_Request::getInt('vacancies', 1);
		$total_score	= SB_Request::getInt('total_score');
		$min_points		= SB_Request::getInt('min_points');
		$status			= SB_Request::getString('status');
		$data			= json_encode(SB_Request::getVar('data'));
		$message = $link = '';
		$data = compact('code', 'name', 'description', 'start_date', 'end_date', 'min_points', 'total_score', 'vacancies', 'status', 'data');
		if( !$id )
		{
			$data['creation_date'] = date('Y-m-d H:i:s');
			$id = $this->dbh->Insert('rrhh_announcements', $data);
			$message = __('The announcement has been created', 'rrhh');
			$link = SB_Route::_('index.php?mod=rrhh&view=announcements.default');
		}
		else
		{
			$this->dbh->Update('rrhh_announcements', $data, array('id' => $id));
			$message = __('The announcement has been updated', 'rrhh');
			$link =  SB_Route::_('index.php?mod=rrhh&view=announcements.edit&id='.$id);
		}
		SB_MessagesStack::AddMessage($message, 'success');
		sb_redirect($link);
	}
	public function task_applicants()
	{
		$id = SB_Request::getInt('id');
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('The announcement identifier is invalid', 'rrhh'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
		}
		$title = __('Announcement Applicants', 'rrhh');
		$obj = new RRHH_Announcement($id);
		sb_set_view_var('obj', $obj);
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_view_profile()
	{
		$id = SB_Request::getInt('id');
		$person = new RRHH_Person($id);
		ob_start();
		include MOD_RRHH_DIR . SB_DS . 'views' . SB_DS . 'tab-my_cv.php';
		$html = ob_get_clean();
		//##convert html quote to pdf
		sb_include_lib('dompdf/dompdf.php');
		$pdf = new Dompdf\Dompdf();
		$pdf->set_option('defaultFont', 'Helvetica');
		$pdf->set_option('isRemoteEnabled', true);
		$pdf->set_option('isPhpEnabled', true);
		$pdf->setPaper('A4'/*, 'landscape'*/);
		$pdf->loadHtml($html);
		$pdf->render();
		$pdf->stream(sprintf(__('%s-%s-%s-cv.pdf', 'mb'), $person->first_name, $person->fathers_lastname, $person->mothers_lastname),
				array('Attachment' => 0, 'Accept-Ranges' => 1));
		die();
	}
	public function task_export2excel()
	{
		$id = SB_Request::getInt('id');
		$obj = new RRHH_Announcement($id);
		
		sb_include_lib('php-office/PHPExcel-1.8/PHPExcel.php');
		$font = new PHPExcel_Style_Font();
		$font->setBold(false);
		$font->setName('Verdana');
		$font->setSize(10);
		$xls = new PHPExcel();
		$sheet = $xls->setActiveSheetIndex(0);
			
		$sheet->setCellValue('a1', __('Firstname', 'rrhh'));
		$sheet->setCellValue('b1', __('Fathers Lastname', 'rrhh'));
		$sheet->setCellValue('c1', __('Mothers Lastname', 'rrhh'));
		$sheet->setCellValue('d1', __('City', 'rrhh'));
		$sheet->setCellValue('e1', __('Country', 'rrhh'));
		$sheet->setCellValue('f1', __('Telephone', 'rrhh'));
		$sheet->setCellValue('g1', __('Cell phone', 'rrhh'));
		$sheet->setCellValue('h1', __('Email', 'rrhh'));
		$sheet->setCellValue('i1', __('Score', 'rrhh'));
		$sheet->getStyle("a1:i1")->applyFromArray(
				array(
						'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '1E90FF')
						),
						'font'  => array(
								'bold'  => true,
								'color' => array('rgb' => 'FFFFFF'),
								'size'  => 10,
								//'name'  => 'Verdana'
						),
						'alignment' => array(
								'horizontal'	=> 'center'
						)
				)
		);
		$last_code = null;
		$row = 2;
		foreach($obj->GetApplicants() as $a)
		{
			$sheet->setCellValue("a$row", $a->first_name);
			$sheet->setCellValue("b$row", $a->fathers_lastname);
			$sheet->setCellValue("c$row", $a->mothers_lastname);
			$sheet->setCellValue("d$row", $a->current_city);
			$sheet->setCellValue("e$row", $a->current_country);
			$sheet->setCellValue("f$row", $a->telephone);
			$sheet->setCellValue("g$row", $a->mobile);
			$sheet->setCellValue("h$row", $a->email);
			$sheet->setCellValue("i$row", $a->score);
			$row++;
		}
			
		$sheet->getStyle("a2:i$row")->applyFromArray(
				array(
						'font'  => array(
								//'bold'  => !true,
								'color' => array('rgb' => '000000'),
								'size'  => 10,
								'name'  => 'Verdana'
						)
				)
		);
		$writer = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
		$xls_file = TEMP_DIR . SB_DS . sprintf("%s-%s-%s.xlsx", sb_build_slug($obj->code), sb_build_slug($obj->name), sb_format_datetime(time(), 'Y-m-d_H_i_s'));
		$writer->save($xls_file);
		ob_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.basename($xls_file).'"');
		header('Cache-Control: max-age=0');
		readfile($xls_file);
		unlink($xls_file);
		die();
	}
	public function task_see_curricular_filter()
	{
		$id 		= SB_Request::getInt('id');
		$ids 		= (array)SB_Request::getVar('person_id');
		$obj 		= new RRHH_Announcement($id);
		
		sb_include_lib('php-office/PHPExcel-1.8/PHPExcel.php');
		$font = new PHPExcel_Style_Font();
		$font->setBold(false);
		$font->setName('Verdana');
		$font->setSize(10);
		$xls = new PHPExcel();
		$sheet = $xls->setActiveSheetIndex(0);
		$row = 5;
		foreach($obj->GetApplicants($ids) as $a)
		{
			//$person 	= new RRHH_Person($person_id);
			//##get applicant data
			$data = json_decode($a->data);
			$sheet->setCellValue("a$row", __('Firstname', 'rrhh'));
			$sheet->setCellValue("b$row", $a->first_name);
			$sheet->setCellValue("c$row", __('Fathers Lastname', 'rrhh'));
			$sheet->setCellValue("d$row", $a->fathers_lastname);
			$sheet->setCellValue("e$row", __('Mothers Lastname', 'rrhh'));
			$sheet->setCellValue("f$row", $a->mothers_lastname);
			$row += 2;
			$sheet->setCellValue("a$row", 'Formacion Academica');
			$sheet->setCellValue("a$row", 'Grado Academico');
			$sheet->setCellValue("b$row", 'Titulo Obtenido');
			$sheet->setCellValue("c$row", 'Centro Educativo');
			$sheet->setCellValue("d$row", 'Fecha Titulo');
			$sheet->setCellValue("e$row", 'Puntaje');
			
			$sheet->getStyle("a$row:e$row")->applyFromArray(
					array(
							'fill' => array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => 'bcbcbc')
							),
							'font'  => array(
									'bold'  => true,
									'color' => array('rgb' => '000000'),
									'size'  => 10,
									//'name'  => 'Verdana'
							),
							'alignment' => array(
									'horizontal'	=> 'center'
							)
					)
			);
			$row++;
			//##get academic records
			$query = "SELECT r.*, l.name as study_level FROM rrhh_academic_records r, rrhh_study_levels l 
						WHERE 1 = 1
						AND r.study_level_id = l.id 
						AND r.person_id = $a->id 
						ORDER BY r.creation_date ASC";
			$records = $this->dbh->FetchResults($query);
			foreach($records as $rec)
			{
				$sheet->setCellValue("a$row", $rec->study_level);
				$sheet->setCellValue("b$row", $rec->degree);
				$sheet->setCellValue("c$row", $rec->center_name);
				$sheet->setCellValue("d$row", sb_format_date($rec->degree_data));
				$sheet->setCellValue("e$row", $data->academic->{'id_'.$rec->id}->points);
				$row++;
			}
			$sheet->getStyle("a10:e$row")->applyFromArray(
					array(
							'font'  => array(
									//'bold'  => !true,
									'color' => array('rgb' => '000000'),
									'size'  => 10,
									'name'  => 'Verdana'
							)
					)
			);
			$row += 2;
			$row += 2;
			//##build General Experience
			$sheet->setCellValue("a$row", 'Experiencia General');
			$row++;
			$sheet->setCellValue("a$row", 'Empresa');
			$sheet->setCellValue("b$row", 'Sector');
			$sheet->setCellValue("c$row", 'Cargo');
			$sheet->setCellValue("d$row", 'Fecha Inicio');
			$sheet->setCellValue("e$row", 'Fecha Conclusion');
			$sheet->setCellValue("f$row", 'Tiempo en el Cargo');
			$sheet->setCellValue("g$row", 'Funciones');
			$sheet->setCellValue("h$row", 'Nro. Dependientes');
			$sheet->setCellValue("i$row", 'Motivo Desvinculacion');
			$sheet->setCellValue("j$row", 'Puntaje');
				
			$sheet->getStyle("a$row:j$row")->applyFromArray(
					array(
							'fill' => array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => 'bcbcbc')
							),
							'font'  => array(
									'bold'  => true,
									'color' => array('rgb' => '000000'),
									'size'  => 10,
									//'name'  => 'Verdana'
							),
							'alignment' => array(
									'horizontal'	=> 'center'
							)
					)
			);
			$row++;
			foreach($data->general_experience as $exp)
			{
				$sheet->setCellValue("a$row", $exp->company);
				$sheet->setCellValue("b$row", $exp->company_industry);
				$sheet->setCellValue("c$row", $exp->position);
				$sheet->setCellValue("d$row", sb_format_date($exp->start_date));
				$sheet->setCellValue("e$row", sb_format_date($exp->end_date));
				$sheet->setCellValue("f$row", $exp->total_experience);
				$sheet->setCellValue("g$row", $exp->main_functions);
				$sheet->setCellValue("h$row", $exp->dependent);
				$sheet->setCellValue("i$row", (int)$exp->currently_working ? 'Actualmente trabajando' : $exp->decouplin_reason);
				$sheet->setCellValue("j$row", $exp->points);
			}
			$row++;
			//##build Specific Experience
			$sheet->setCellValue("a$row", 'Experiencia Especifica');
			$row++;
			$sheet->setCellValue("a$row", 'Empresa');
			$sheet->setCellValue("b$row", 'Sector');
			$sheet->setCellValue("c$row", 'Cargo');
			$sheet->setCellValue("d$row", 'Fecha Inicio');
			$sheet->setCellValue("e$row", 'Fecha Conclusion');
			$sheet->setCellValue("f$row", 'Tiempo en el Cargo');
			$sheet->setCellValue("g$row", 'Funciones');
			$sheet->setCellValue("h$row", 'Nro. Dependientes');
			$sheet->setCellValue("i$row", 'Motivo Desvinculacion');
			$sheet->setCellValue("j$row", 'Puntaje');
			
			$sheet->getStyle("a$row:j$row")->applyFromArray(
					array(
							'fill' => array(
									'type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => 'bcbcbc')
							),
							'font'  => array(
									'bold'  => true,
									'color' => array('rgb' => '000000'),
									'size'  => 10,
									//'name'  => 'Verdana'
							),
							'alignment' => array(
									'horizontal'	=> 'center'
							)
					)
			);
			$row++;
			foreach($data->specific_experience as $exp)
			{
				$sheet->setCellValue("a$row", $exp->company);
				$sheet->setCellValue("b$row", $exp->company_industry);
				$sheet->setCellValue("c$row", $exp->position);
				$sheet->setCellValue("d$row", sb_format_date($exp->start_date));
				$sheet->setCellValue("e$row", sb_format_date($exp->end_date));
				$sheet->setCellValue("f$row", $exp->total_experience);
				$sheet->setCellValue("g$row", $exp->main_functions);
				$sheet->setCellValue("h$row", $exp->dependent);
				$sheet->setCellValue("i$row", (int)$exp->currently_working ? 'Actualmente trabajando' : $exp->decouplin_reason);
				$sheet->setCellValue("j$row", $exp->points);
			}
		}
		$row++;
		$sheet->setCellValue("a$row", 'Nombres');
		$sheet->setCellValue("b$row", 'Apellido Paterno');
		$sheet->setCellValue("c$row", 'Apellido Materno');
		$sheet->setCellValue("d$row", 'Puntaje');
		$row++;
		foreach($obj->GetApplicants($ids) as $a)
		{
			//##get applicant data
			$data = json_decode($a->data);
			$sheet->setCellValue("a$row", $a->first_name);
			$sheet->setCellValue("b$row", $a->fathers_lastname);
			$sheet->setCellValue("c$row", $a->mothers_lastname);
			$sheet->setCellValue("d$row", 0);
			$row++;
		}
		$writer = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
		$xls_file = TEMP_DIR . SB_DS . sprintf("%s-%s-%s.xlsx", sb_build_slug($obj->code), sb_build_slug($obj->name), sb_format_datetime(time(), 'Y-m-d_H_i_s'));
		$writer->save($xls_file);
		ob_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.basename($xls_file).'"');
		header('Cache-Control: max-age=0');
		readfile($xls_file);
		unlink($xls_file);
		die();
	}
	public function task_close()
	{
		$id 		= SB_Request::getInt('id');
		$person_id 	= SB_Request::getVar('person_id');
		$this->dbh->Update('rrhh_announcements', array('status' => 'closed', 'selected' => json_encode($person_id)), array('id' => $id));
		//##send message to unselected persons
		
		SB_MessagesStack::AddMessage(__('The announcement has been closed', 'rrhh'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=rrhh&view=announcements.default'));
	}
}