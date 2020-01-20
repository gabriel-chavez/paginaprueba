<?php
function rrhh_get_announcement_statuses()
{
	return array(
			'active'	=> __('Active', 'rrhh'),
			'inactive'	=> __('Inactive', 'rrhh'),
			'closed'	=> __('Closed', 'rrhh'),
	);
}
function rrhh_show_announcement_status($status)
{
	$statuses = rrhh_get_announcement_statuses();
	$class = '';
	if( $status == 'active' )
		$class = 'success';
	if( $status == 'inactive' )
		$class = 'default';
	if( $status == 'closed' )
		$class = 'danger';
	return '<span class="label label-'.$class.'">'.$statuses[$status] . '</span>';
}
function rrhh_review_announcement_status($annuoncement)
{
	$obj = is_object($annuoncement) ? $annuoncement : new RRHH_Announcement((int)$annuoncement);
	if( !$obj->id )
		return false;
	if( $obj->status == 'inactive' || $obj->status == 'closed' )
		return false;
	$end_time = strtotime($obj->end_date);
	$end_time = mktime(23, 59, 59, date('m', $end_time), date('d', $end_time), date('Y', $end_time));
	if( time() > $end_time )
	{
		SB_Factory::getDbh()->Update('rrhh_announcements', array('status' => 'inactive'), array('id' => $obj->id));
	}
}
function rrhh_show_experience($number)
{
	$years 		= floor($number);
	$decimals 	= $number - $years;
	$months 	= ($decimals*12);// * 12;
	return sprintf("%d A&ntilde;os %d Meses", $years, floor($months));
}
/**
 * Build person excel CV
 * 
 * @brief 
 * @param RRHH_Person $person 
 * @return  PHPExcel $xls
 */
function rrhh_cv2excel($person)
{
	$countries = include INCLUDE_DIR . SB_DS . 'countries.php';
	sb_include_lib('php-office/PHPExcel-1.8/PHPExcel.php');
	$color1 = new PHPExcel_Style_Color('f8981d');
	
	$font = new PHPExcel_Style_Font();
	$font->setBold(false);
	$font->setName('Verdana');
	$font->setSize(9);
	$xls 	= new PHPExcel();
	$sheet 	= $xls->setActiveSheetIndex(0);
	$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$row = 1;
	$sheet->setCellValue("a$row", 'HOJA DE VIDA');
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$sheet->mergeCells("A$row:F$row");
	$sheet->getStyle("A$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row += 2;
	$sheet->setCellValue("A$row", 'DATOS PERSONALES');
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getFont()->setColor($color1);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	$aux_row = $row++;
	for($i = 1; $i <= 8; $i++)
	{
		//$sheet->mergeCells("A$row:B$row");
		$row++;
	}
	//##load and insert image profile
	$img_file 	= MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image;
	$img_file 	= file_exists($img_file) && is_file($img_file) ? $img_file : BASEPATH . '/images/nobody.png';
	$ext 		= sb_get_file_extension($img_file);
	$gdImage 	= null;
	$rend_func = PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT;
	if( $ext == 'jpg' || $ext == 'jpeg' )
	{
		$gdImage = imagecreatefromjpeg($img_file);
		$rend_func = PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG;
		$mime = PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG;
	}
	elseif( $ext == 'png' )
	{
		$gdImage = imagecreatefrompng($img_file);
		$rend_func = PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG;
		$mime = PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG;
	}
	elseif( $ext == 'gif' )
	{
		$gdImage = imagecreatefromgif($img_file);
		$rend_func = PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF;
		$mime = PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF;
	}
	if( $gdImage )
	{
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Image Profile');
		$objDrawing->setDescription('Image Profile');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction($rend_func);
		$objDrawing->setMimeType($mime);
		$objDrawing->setHeight(150);
		$objDrawing->setWidth(150);
		$objDrawing->setWorksheet($sheet);
		$objDrawing->setCoordinates("A$aux_row");
	}
	
	//$aux_row++;
	$sheet->setCellValue("B$aux_row", 'Nombres');
	$sheet->setCellValue("C$aux_row", 'Apellido del padre');
	$sheet->setCellValue("D$aux_row", 'Apellido de la madre');
	$sheet->setCellValue("E$aux_row", 'Email');
	$aux_row++;
	$sheet->setCellValue("B$aux_row", $person->first_name);
	$sheet->setCellValue("C$aux_row", $person->fathers_lastname);
	$sheet->setCellValue("D$aux_row", $person->mothers_lastname);
	$sheet->setCellValue("E$aux_row", $person->email);
	$aux_row++;
	$sheet->setCellValue("B$aux_row", 'Tipo Documento');
	$sheet->setCellValue("C$aux_row", 'Numero Documento');
	$sheet->setCellValue("D$aux_row", 'Expedido en');
	$sheet->setCellValue("E$aux_row", 'Fecha Nacimiento');
	$aux_row++;
	$sheet->setCellValue("B$aux_row", $person->document_type);
	$sheet->setCellValue("C$aux_row", $person->document);
	$sheet->setCellValue("D$aux_row", $person->document_from);
	$sheet->setCellValue("E$aux_row", sb_format_date($person->birthday));
	$aux_row++;
	$sheet->setCellValue("B$aux_row", 'Ciudad de Nacimiento');
	$sheet->setCellValue("C$aux_row", 'País Nacimiento');
	$sheet->setCellValue("D$aux_row", 'Ciudad Residencia');
	$sheet->setCellValue("E$aux_row", 'País Residencia');
	$aux_row++;
	$sheet->setCellValue("B$aux_row", $person->city_birth);
	$sheet->setCellValue("C$aux_row", $countries[$person->country_birth]);
	$sheet->setCellValue("D$aux_row", $person->current_city);
	$sheet->setCellValue("E$aux_row", $person->curreny_country);
	$aux_row++;
	$sheet->setCellValue("B$aux_row", 'Dirección');
	$sheet->setCellValue("C$aux_row", 'Zona');
	$sheet->setCellValue("D$aux_row", 'Teléfono');
	$sheet->setCellValue("E$aux_row", 'Teléfono Mobil');
	$aux_row++;
	$sheet->setCellValue("B$aux_row", $person->address_1);
	$sheet->setCellValue("C$aux_row", $person->address_zone);
	$sheet->setCellValue("D$aux_row", $person->telephone);
	$sheet->setCellValue("E$aux_row", $person->mobile);
	$aux_row++;
	$sheet->setCellValue("A$row", 'FORMACION ACEDEMICA');
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getFont()->setColor($color1);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	//##formacion academica
	$sheet->setCellValue("A$row", 'Nivel de Formacion');
	$sheet->setCellValue("B$row", 'Centro de Estudios');
	$sheet->setCellValue("C$row", 'Titulo Obtenido');
	$sheet->setCellValue("D$row", 'Fecha Titulo');
	$sheet->setCellValue("E$row", 'Ciudad');
	$sheet->setCellValue("F$row", 'País');
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	foreach($person->GetAcademicRecords() as $rec)
	{
		$sheet->setCellValue("A$row", $rec->study_level);
		$sheet->setCellValue("B$row", $rec->center_name);
		$sheet->setCellValue("C$row", $rec->degree);
		$sheet->setCellValue("D$row", sb_format_date($rec->degree_date));
		$sheet->setCellValue("E$row", $rec->degree_city);
		$sheet->setCellValue("F$row", $rec->degree_country);
		$row++;
	}
	//###################
	//## CURSOS #########
	//###################
	$sheet->setCellValue("A$row", 'CURSOS/TALLERES/SEMINARIOS');
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$row++;
	$sheet->setCellValue("A$row", 'Tipo');
	$sheet->setCellValue("B$row", 'Nombre');
	$sheet->setCellValue("C$row", 'Centro de Estudios');
	$sheet->setCellValue("D$row", 'País');
	$sheet->setCellValue("E$row", 'Duración');
	$sheet->setCellValue("F$row", 'Modalidad');
	$sheet->setCellValue("G$row", 'Fecha Inicio');
	$sheet->setCellValue("H$row", 'Fecha Fin');
	$sheet->getStyle("A$row:H$row")->getFont()->setBold(true);
	$row++;
	$cursos = $person->_cursos ? json_decode($person->_cursos) : new stdClass();
	foreach($cursos as $item)
	{
		$sheet->setCellValue("A$row", $item->tipo_curso);
		$sheet->setCellValue("B$row", $item->nombre);
		$sheet->setCellValue("C$row", $item->centro_estudio);
		$sheet->setCellValue("D$row", $item->pais);
		$sheet->setCellValue("E$row", $item->horas);
		$sheet->setCellValue("F$row", $item->modalidad);
		$sheet->setCellValue("G$row", sb_format_date($item->fecha_inicio));
		$sheet->setCellValue("H$row", sb_format_date($item->fecha_fin));
		$row++;
	}
	//#######################
	//###### IDIOMAS ########
	//#######################
	$sheet->setCellValue("A$row", 'CONOCIMIENTOS DE IDIOMAS');
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$row++;
	$sheet->setCellValue("A$row", 'Idioma');
	$sheet->setCellValue("B$row", 'Nivel de Lectura');
	$sheet->setCellValue("C$row", 'Nivel de Escritura');
	$sheet->setCellValue("D$row", 'Nivel de Conversación');
	$sheet->getStyle("A$row:D$row")->getFont()->setBold(true);
	$row++;
	$idiomas = $person->_idiomas ? json_decode($person->_idiomas) : new stdClass();
	foreach($idiomas as $item)
	{
		$sheet->setCellValue("A$row", $item->idioma);
		$sheet->setCellValue("B$row", $item->nivel_lectura);
		$sheet->setCellValue("C$row", $item->nivel_escritura);
		$sheet->setCellValue("D$row", $item->nivel_conversacion);
		$row++;
	}
	//##############
	//## SISTEMAS ##
	//##############
	$sheet->setCellValue("A$row", 'CONOCIMIENTOS EN SISTEMAS');
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$row++;
	$sheet->setCellValue("A$row", 'Programa/Paquete/Sistema');
	$sheet->setCellValue("B$row", 'Nivel Conocimiento');
	$sheet->getStyle("A$row:B$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:B$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	$sistemas = $person->_sistemas ? json_decode($person->_sistemas) : new stdClass();
	foreach($sistemas as $item)
	{
		$sheet->setCellValue("A$row", strtolower($item->sistema) == 'otro' ? $item->otro_sistema : $item->sistema);
		$sheet->setCellValue("B$row", $item->nivel);
		$row++;
	}
	//########################
	//## experiencia la boral
	//########################
	$sheet->setCellValue("A$row", 'EXPERIENCIA LABORAL');
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$row++;
	foreach($person->GetWorkExperience() as $exp)
	{
		$sheet->setCellValue("A$row", "Empresa:");
		$sheet->setCellValue("B$row", $exp->company);
		$sheet->setCellValue("C$row", 'Cargo:');
		$sheet->setCellValue("D$row", $exp->position);
		$sheet->setCellValue("E$row", 'Sector:');
		$sheet->setCellValue("F$row", $exp->company_industry);
		$row++;
		$sheet->setCellValue("A$row", "Nro. Dependientes");
		$sheet->setCellValue("B$row", 'Nombre Superior');
		$sheet->setCellValue("C$row", 'Cargo Superior');
		$sheet->setCellValue("D$row", 'Teléfono Empresa');
		$row++;
		$sheet->setCellValue("A$row", $exp->dependent);
		$sheet->setCellValue("B$row", $exp->superior_name);
		$sheet->setCellValue("C$row", $exp->superior_position);
		$sheet->setCellValue("D$row", $exp->company_phone);
		$row++;
		$sheet->setCellValue("A$row", "Principales Funciones");
		$sheet->setCellValue("B$row", 'Fecha Inicio');
		$sheet->setCellValue("C$row", 'Fecha Final');
		$sheet->setCellValue("D$row", 'Total Experiencia');
		$sheet->setCellValue("D$row", 'Motivo Desvinculación');
		$row++;
		$sheet->setCellValue("A$row", $exp->main_functions);
		$sheet->setCellValue("B$row", sb_format_date($exp->start_date));
		$sheet->setCellValue("C$row", (int)$exp->currently_working == 1 ? sb_format_date(time()) :sb_format_date($exp->end_date));
		$total_exp = 0;
		if( (int)$exp->currently_working )
		{
			$start_time = strtotime($exp->start_date);
			$current_time = time();
			$diff = $current_time - $start_time;
			$total_exp = $diff/31556952;
		}
		else
		{
			$total_exp = $exp->total_experience;
		}
		$sheet->setCellValue("D$row", sprintf("%.2f", $total_exp));
		$sheet->setCellValue("D$row", $exp->decouplin_reason);
		$row++;
	}
	$sheet->setCellValue("A$row", 'REFERENCIAS LABORALES');
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$row++;
	$sheet->setCellValue("A$row", 'Nombre');
	$sheet->setCellValue("B$row", 'Cargo');
	$sheet->setCellValue("C$row", 'Empresa');
	$sheet->setCellValue("D$row", 'Telefono/Celular');
	$sheet->setCellValue("E$row", 'Email');
	$sheet->setCellValue("F$row", 'Relación');
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	foreach($person->GetWorkReferences() as $ref)
	{
		$sheet->setCellValue("A$row", $ref->name);
		$sheet->setCellValue("B$row", $ref->position);
		$sheet->setCellValue("C$row", $ref->company);
		$sheet->setCellValue("D$row", sprintf("%s %s", $ref->telephone, $ref->cell_phone));
		$sheet->setCellValue("E$row", $ref->email);
		$sheet->setCellValue("F$row", $ref->relationship);
		$row++;
	}
	$sheet->setCellValue("A$row", 'REFERENCIAS PERSONALES');
	$sheet->getStyle("A$row")->getFont()->setColor($color1);
	$sheet->getStyle("A$row")->getFont()->setBold(true);
	$row++;
	$sheet->setCellValue("A$row", 'Nombre');
	$sheet->setCellValue("B$row", 'Empresa');
	$sheet->setCellValue("C$row", 'Cargo');
	$sheet->setCellValue("D$row", 'Parentesco');
	$sheet->setCellValue("E$row", 'Telefono/Celular');
	$sheet->setCellValue("F$row", 'Email');
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$row++;
	foreach($person->GetPersonalReferences() as $ref)
	{
		$sheet->setCellValue("A$row", $ref->name);
		$sheet->setCellValue("B$row", $ref->company);
		$sheet->setCellValue("C$row", $ref->position);
		$sheet->setCellValue("D$row", $ref->telationship);
		$sheet->setCellValue("E$row", sprintf("%s %s", $ref->telephone, $ref->cell_phone));
		$sheet->setCellValue("F$row", $ref->email);
		$row++;
	}
	$row++;
	$sheet->setCellValue("A$row", 
			'TODA LA INFORMACIÓN DECLARADA ES VERDADERA Y ESTOY EN CONDICIONES DE SUSTENTARLA A REQUERIMIENTO DE LA EMPRESA. EL '. 
			'FORMULARIO ES UNA DECLARACIÓN JURADA, SEGUROS Y REASEGUROS UNIVIDA SA. SE RESERVA EL DERECHO DE LA VERIFICACIÓN DE '. 
			'LA INFORMACIÓN QUE CONTIENE.');
	$sheet->mergeCells("A$row:F$row");
	$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("A$row:F$row")->getAlignment()->setWrapText(true);
	$sheet->getRowDimension($row)->setRowHeight(60);
	
	return $xls;
}
function rrhh_show_last_activity($item)
{
	$DAY_SECS 		= 86400;
	$DAY_SECSx30 	= $DAY_SECS * 30;
	$logged_in_time	= (int)sb_get_user_meta($item->user_id, '_logged_in_time');
	$last_login 	= (int)sb_get_user_meta($item->user_id, '_last_login');
	$time			= time();
	$diff 			= $time - $last_login;
	$total_days		= number_format($diff / $DAY_SECS, 2, '.', ',');
	
	if( $last_login <= 0 )
	{
		print '<span class="label label-danger" data-login="'.$last_login.'" data-time="'.$time.'">'.
				'Sin actividad</span>';
	}
	elseif( $diff > $DAY_SECSx30 )
	{
		print '<span class="label label-danger" data-login="'.$last_login.'" data-time="'.$time.'">'.
				'hace '.$total_days.' dias</span>';
	}
	else
	{
		print '<span class="label label-success" data-login="'.$last_login.'" data-time="'.$time.'">'.
				'hace '.$total_days.' dias</span>';
	}
}