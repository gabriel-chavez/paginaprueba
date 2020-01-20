<?php
$cursos = $person->_cursos ? json_decode($person->_cursos) : new stdClass();
?>
<div>
	<p><a href="javascript:;" id="btn-add-curso" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Adicionar Curso/Taller</a></p>
	<div id="cursos-messages"></div>
	<table id="table-cursos" class="table table-condensed">
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
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($cursos as $key => $item): include 'curso-row.php';?>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div id="modal-curso" class="modal fade">
	<form id="form-curso" class="modal-dialog" action="" method="post">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_curso" />
		<input type="hidden" id="curso_id" name="id" value="-1" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Adicionar/Modificar Curso', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label><?php _e('Tipo Curso/Taller'); ?></label>
				<select id="tipo_curso" name="tipo_curso" class="form-control">
					<option value="-1">-- tipo --</option>
					<option value="Conferencia">Conferencia</option>
					<option value="Curso">Curso</option>
					<option value="Seminario">Seminario</option>
					<option value="Taller">Taller</option>
				</select>
			</div>
			<div class="form-group">
				<label><?php _e('Nombre Curso/Taller'); ?></label>
				<input type="text" name="nombre" value="" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Centro de Estudios'); ?></label>
				<input type="text" name="centro_estudio" value="" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Pa&iacute;s'); ?></label>
				<input type="text" name="pais" value="" class="form-control" />
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="form-group">
						<label><?php _e('Modalidad'); ?></label>
						<select class="form-control" name="modalidad" required>
							<option value="">-- modalidad --</option>
							<option value="PRESENCIAL">PRESENCIAL</option>
							<option value="SEMIPRESENCIAL">SEMIPRESENCIAL</option>
							<option value="A_DISTANCIA">A_DISTANCIA</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="form-group">
						<label><?php _e('Horas Acad&eacute;micas'); ?></label>
						<input type="number" name="horas" value="" class="form-control" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="form-group">
						<label><?php _e('Fecha Inicio'); ?></label>
						<input type="text" name="fecha_inicio" class="form-control datepicker" required />
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="form-group">
						<label><?php _e('Fecha Fin'); ?></label>
						<input type="text" name="fecha_fin" class="form-control datepicker" required />
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="javascript:;" class="btn btn-default" data-dismiss="modal"><?php _e('Cerrar', 'rrhh'); ?></a>
			<button type="submit" class="btn btn-green"><?php _e('Guardar', 'rrhh'); ?></button>
		</div>
	</form>
</div>