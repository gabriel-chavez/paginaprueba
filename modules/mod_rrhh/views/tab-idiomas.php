<?php
$idiomas = $person->_idiomas ? json_decode($person->_idiomas) : new stdClass();
?>
<div id="tab-idiomas" class="tab-pane">
	<p><a href="javascript:;" id="btn-add-idioma" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Adicionar Idioma</a></p>
	<div id="idiomas-messages"></div>
	<table id="table-idiomas" class="table table-condensed">
	<thead>
	<tr>
		<th>Idioma</th>
		<th>Nivel Lectura</th>
		<th>Nivel Escritura</th>
		<th>Nivel Conversaci&oacute;n</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($idiomas as $key => $item): include 'idiomas-row.php';?>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div id="modal-idioma" class="modal fade">
	<form id="form-idioma" class="modal-dialog" action="" method="post">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_idioma" />
		<input type="hidden" id="idioma_id" name="id" value="-1" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Adicionar/Modificar Idioma', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label required"><?php _e('Idioma', 'rrhh'); ?></label>
				<select class="form-control" id="idioma" name="idioma" required >
					<option value="">-- idioma --</option>
					<option value="Aleman">ALEMAN</option>
					<option value="Aymara">AYMARA</option>
					<option value="Frances">FRANCES</option>
					<option value="Guarani">GUARANI</option>
					<option value="Ingles">INGLES</option>
					<option value="Japones">JAPONES</option>
					<option value="Portugues">PORTUGUES</option>
					<option value="Quechua">QUECHUA</option> 
				</select>
			</div>
			<div class="form-group">
				<label class="control-label required">Nivel Lectura</label>
				<select id="nivel_lectura" name="nivel_lectura" class="form-control">
					<option value="">-- nivel --</option>
					<option value="Basico">Basico</option>
					<option value="Intermedio">Intermedio</option>
					<option value="Avanzado">Avanzado</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label required"><?php _e('Nivel Escritura', 'rrhh'); ?></label>
				<select id="nivel_escritura" name="nivel_escritura" class="form-control">
					<option value="">-- nivel --</option>
					<option value="Basico">Basico</option>
					<option value="Intermedio">Intermedio</option>
					<option value="Avanzado">Avanzado</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label required"><?php _e('Nivel Escritura', 'rrhh'); ?></label>
				<select id="nivel_conversacion" name="nivel_conversacion" class="form-control">
					<option value="">-- nivel --</option>
					<option value="Basico">Basico</option>
					<option value="Intermedio">Intermedio</option>
					<option value="Avanzado">Avanzado</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<a href="javascript:;" class="btn btn-default" data-dismiss="modal">Cerrar</a>
			<button type="submit" class="btn btn-green"><?php _e('Guardar', 'rrhh'); ?></button>
		</div>
	</form>
</div>