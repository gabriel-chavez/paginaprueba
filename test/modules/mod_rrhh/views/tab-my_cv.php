<?php
?>
<style>
<?php if( SB_Request::getTask() == 'profile2pdf' || SB_Request::getString('view') == 'announcements.view_profile' ): ?>
*{font-family: Helvetica,Verdana,Arial;font-size:12px;}
table{width:100%;}
table thead th{border-bottom:1px solid #ececec;}
<?php endif; ?>
#my-cv-container h1{text-align:center;font-size:18px;}
#table-personal-data{}
#table-personal-data th{background:#ececec;}
#table-personal-data th, #table-personal-data td{text-align:center;}
.section{clear:both;margin:0 0 8px 0;}
.section-title{font-size:16px;color:#f8981d;text-transform: uppercase;font-weight: normal;}
</style>
<div id="my-cv-container">
	<?php if( SB_Request::getTask() == 'profile2pdf' ): ?>
	<h1><?php _e('HOJA DE VIDA', 'rrhh'); ?></h1>
	<?php endif; ?>
	<div class="section">
		<h3 class="section-title">Datos Personales</h3>
		<table style="width:100%;">
		<tr>
			<td style="width:25%;text-align:center;">
				<?php if( $person->_image && file_exists(MOD_RRHH_IMAGES_DIR . SB_DS . $person->_image) ):?>
				<img src="<?php print MOD_RRHH_IMAGES_URL . '/' . $person->_image; ?>" alt="<?php print $person->first_name; ?>"  style="width:128px;" />
				<?php else: ?>
				<img src="<?php print BASEURL; ?>/images/nobody.png"  />
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
					<td><?php print $person->country_birth; ?></td>
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
			<td><?php print $rec->degree; ?></td>
			<td><?php print $rec->center_name; ?></td>
			<td><?php print $rec->degree_date; ?></td>
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
			<th>Centro Educativo</th>
			<th>Curso</th>
			<th>Duracion / horas</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
			<th>Ciudad / Pais</th>
		</tr>
		</thead>
		<tbody>
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
</div>