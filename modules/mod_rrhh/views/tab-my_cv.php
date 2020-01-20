<?php
$settings = (object)sb_get_parameter('settings', array());
$is_pdf = SB_Request::getTask() == 'profile2pdf' || SB_Request::getString('view') == 'announcements.view_profile';
?>
<?php if( SB_Request::getTask() != 'ajax' ): ?>
<style>
<?php if( $is_pdf ): ?>
@page {margin: 70px 50px; font-family: Helvetica,Verdana,Arial;font-size:12px;}
*{}
.header{position:fixed;top:-60px;right:0;left:0;height:60px;/*border:1px solid #000;*/}
.header #logo{position:absolute;right:0;width:200px;}
table{width:100%;}
table thead th{border-bottom:1px solid #ececec;}
<?php endif; ?>
#my-cv-container{width:100%;clear:both;}
#my-cv-container h1{text-align:center;font-size:18px;}
#table-personal-data{}
#table-personal-data th{background:#ececec;}
#table-personal-data th, #table-personal-data td{text-align:center;}
.section{clear:both;margin:0 0 8px 0;}
.section-title{font-size:16px;color:#f8981d;text-transform: uppercase;font-weight: normal;}
</style>
<?php if( $is_pdf ): ?>
<div class="header">
	<img id="logo" src="../templates/univida/images/logo-univida.png" alt="" />
</div>
<?php endif; ?>
<div id="my-cv-container">
<?php endif; //##end if ajax?>
	<?php if( $is_pdf ): ?>
	<h1><?php _e('FORMULARIO DE POSTULACION', 'rrhh'); ?></h1>
	<?php endif; ?>
	<?php //include 'my-cv.php'; ?>
	<div class="section">
		<h3 class="section-title">Datos Personales</h3>
		<table style="width:100%;">
		<tr>
			<td style="width:25%;text-align:center;">
				<?php if( $person->_image && file_exists(MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image) ):?>
				<img src="<?php print '../uploads/rrhh/' . $person->_image; ?>" alt="<?php print $person->first_name; ?>"  style="width:128px;" />
				<?php else: ?>
				<img src="../images/nobody.png"  />
				<?php endif;?>
			</td>
			<td style="width:75%;">
				<table id="table-personal-data" class="table table-condensed">
				<tr>
					<th><?php _e('Firstname', 'rrhh'); ?></th>
					<th><?php _e('Fathers Lastname', 'rrhh'); ?></th>
					<th><?php _e('Mothers Lastname', 'rrhh'); ?></th>
					<th><?php _e('Email', 'rrhh'); ?></th>
				</tr>
				<tr>
					<td><?php print $person->first_name; ?></td>
					<td><?php print $person->fathers_lastname; ?></td>
					<td><?php print $person->mothers_lastname; ?></td>
					<td><?php print $person->email; ?></td>
				</tr>
				<tr>
					<th><?php _e('Document Type', 'rrhh'); ?></th>
					<th><?php _e('Document Number', 'rrhh'); ?></th>
					<th><?php _e('Issued in', 'rrhh'); ?></th>
					<th><?php _e('Birthday', 'rrhh'); ?></th>
				</tr>
				<tr>
					<td><?php print $person->document_type; ?></td>
					<td><?php print $person->document; ?></td>
					<td><?php print $person->document_from; ?></td>
					<td><?php print sb_format_date($person->birthday); ?></td>
				</tr>
				<tr>
					<th><?php _e('City Birth', 'rrhh'); ?></th>
					<th><?php _e('Country Birth', 'rrhh'); ?></th>
					<th><?php _e('City of Residence', 'rrhh'); ?></th>
					<th><?php _e('Country of Residence', 'rrhh'); ?></th>
				</tr>
				<tr>
					<td><?php print $person->city_birth; ?></td>
					<td><?php print @$countries[$person->country_birth]; ?></td>
					<td><?php print $person->current_city; ?></td>
					<td><?php print $person->current_country; ?></td>
				</tr>
				<tr>
					<th><b><?php _e('Address', 'rrhh'); ?></b></th>
					<th><b><?php _e('Zone', 'rrhh'); ?></b></th>
					<th><b><?php _e('Telephone', 'rrhh'); ?></b></th>
					<th><b><?php _e('Mobile Telephone', 'rrhh'); ?></b></th>
				</tr>
				<tr>
					<td><?php print $person->address_1; ?></td>
					<td><?php print $person->address_zone; ?></td>
					<td><?php print $person->telephone; ?></td>
					<td><?php print $person->mobile; ?></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Formacion Academica</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th>Nivel de Formacion</th>
			<th>Centro de Estudios</th>
			<th>Titulo Obtenido</th>
			<th>Fecha Titulo</th>
			<th><?php _e('City', 'rrhh'); ?></th>
			<th><?php _e('Country', 'rrhh'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($person->GetAcademicRecords() as $rec): ?>
		<tr>
			<td><?php print $rec->study_level; ?></td>
			<td><?php print $rec->center_name; ?></td>
            <td><?php print $rec->degree; ?></td>
			<td><?php print sb_format_date($rec->degree_date); ?></td>
			<td><?php print $rec->degree_city; ?></td>
			<td><?php print $rec->degree_country; ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Capacitacion: Cursos, Talleres, Seminarios</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th>Tipo</th>
			<th>Nombre del Curso/Taller</th>
			<th>Centro de Estudios</th>
			<th>Pa&iacute;s</th>
			<th>Duraci&oacute;n</th>
			<th>Modalidad</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		$cursos = $person->_cursos ? json_decode($person->_cursos) : new stdClass();
		unset($key);
		foreach($cursos as $item): include 'curso-row.php';?>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Conocimientos de Idiomas</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th>Idioma</th>
			<th>Nivel de Lectura</th>
			<th>Nivel de Escritura</th>
			<th>Nivel de Conversacion</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$idiomas = $person->_idiomas ? json_decode($person->_idiomas) : new stdClass();
		unset($key); 
		foreach($idiomas as $item) include 'idiomas-row.php'; 
		?>
		</tbody>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Conocimientos en Sistemas</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th>Programa/Paquete/Sistema</th>
			<th>Nivel de Conocimiento</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$sistemas = $person->_sistemas ? json_decode($person->_sistemas) : new stdClass(); 
		foreach($sistemas as $item) include 'sistemas-row.php'; 
		?>
		</tbody>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Experiencia Laboral</h3>
		<?php unset($we_actions); foreach($person->GetWorkExperience() as $exp) include 'we-row.php'; ?>
	</div>
	<div class="section">
		<h3 class="section-title">Referencias Laborales</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Empresa</th>
			<th>Telefono/Celular</th>
			<th>Correo Electronico</th>
			<th>Relacion</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($person->GetWorkReferences() as $ref): ?>
		<tr>
			<td><?php print $ref->name; ?></td>
			<td><?php print $ref->position; ?></td>
			<td><?php print $ref->company; ?></td>
			<td><?php printf("%s %s", $ref->telephone, $ref->cell_phone); ?></td>
			<td><?php print $ref->email; ?></td>
			<td><?php print $ref->relationship; ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<div class="section">
		<h3 class="section-title">Referencias Personales</h3>
		<table class="table table-condensed">
		<thead>
		<tr>
			<th><?php _e('Name', 'rrhh'); ?></th>
			<th><?php _e('Company', 'rrhh'); ?></th>
			<th><?php _e('Position', 'rrhh'); ?></th>
			<th><?php _e('Relationship', 'rrhh'); ?></th>
			<th><?php _e('Telephone', 'rrhh'); ?></th>
			<th><?php _e('Cell phone', 'rrhh'); ?></th>
			<th><?php _e('Email', 'rrhh'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($person->GetPersonalReferences() as $ref): ?>
		<tr>
			<td><?php print $ref->name; ?></td>
			<td><?php print $ref->company; ?></td>
			<td><?php print $ref->position; ?></td>
			<td><?php print $ref->relationship; ?></td>
			<td><?php print $ref->telephone; ?></td>
			<td><?php print $ref->cell_phone; ?></td>
			<td><?php print $ref->email; ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
    <br/><br/>
    <?php if( $is_pdf && lt_is_admin() && $id = SB_Request::getInt('bid') ): ?>
    <?php
    $bid = SB_Factory::getDbh()->FetchRow("SELECT * FROM rrhh_announcement2person WHERE id = $id LIMIT 1"); 
    ?>
    <div class="section">
        <b>Pretension Salarial:</b> <?php print number_format($bid->salary_pretension, 2, '.', ','); ?><br/>
        <?php if( (int)$bid->employee_relationship ): ?>
        <b>Parentesco con funcionario:</b> Si<br/>
        <b>Nombre funcionario:</b> <?php print $bid->employee_name; ?><br/>
        <?php else: ?>
        <b>Parentesco con funcionario:</b> No<br/>
        <?php endif; ?>
        <b>Disponibilidad: </b> <?php print $bid->inmediate_availability == 'yes' ? 'Inmediata' : sprintf("%d, dias", $bid->days); ?>
    </div>
    <?php endif; ?><br/><br/>
    <p style="font-size:10px;">TODA LA INFORMACI&Oacute;N DECLARADA ES VERDADERA Y ESTOY EN CONDICIONES DE SUSTENTARLA A REQUERIMIENTO DE LA EMPRESA. EL FORMULARIO ES UNA 
        DECLARACI&Oacute;N JURADA, SEGUROS Y REASEGUROS UNIVIDA SA. SE RESERVA EL DERECHO DE LA VERIFICACIÓN DE LA INFORMACI&Oacute;N QUE CONTIENE.</p>
<?php if( SB_Request::getTask() != 'ajax' ): ?>
</div>
<?php endif; ?>
