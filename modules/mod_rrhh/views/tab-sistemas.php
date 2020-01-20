<?php
$sistemas = $person->_sistemas ? json_decode($person->_sistemas) : new stdClass();
?>
<div id="tab-sistemas" class="tab-pane">
	<p><a href="javascript:;" id="btn-add-sistema" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Adicionar Sistema</a></p>
	<div id="sistemas-messages"></div>
	<table id="table-sistemas" class="table table-condensed">
	<thead>
	<tr>
		<th>Programa/Sistema/Paquete</th>
		<th>Nivel Conocimiento</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($sistemas as $key => $item): include 'sistemas-row.php';?>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div id="modal-sistema" class="modal fade">
	<form id="form-sistema" class="modal-dialog" action="" method="post">
		<input type="hidden" name="mod" value="rrhh" />
		<input type="hidden" name="task" value="save_sistema" />
		<input type="hidden" id="sistema_id" name="id" value="-1" />
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title"><?php _e('Adicionar/Modificar Sistema', 'rrhh'); ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<label class="control-label required"><?php _e('Programa/Sistema/Paquete', 'rrhh'); ?></label>
				<select class="form-control" id="sistema-nombre" name="sistema" required>
					<option value="">Seleccione</option>
					<option value="MICROSOFT OFFICE EXCEL">MICROSOFT OFFICE EXCEL</option>
					<option value="MICROSOFT OFFICE OUTLOOK">MICROSOFT OFFICE OUTLOOK</option>
					<option value="MICROSOFT OFFICE POWER POINT">MICROSOFT OFFICE POWER POINT</option>
					<option value="MICROSOFT OFFICE WORD">MICROSOFT OFFICE WORD</option>                                                
					<option value="otro">OTRO</option>
				</select>
			</div>
			<div id="otro-sistema" class="form-group">
				<label class="control-label required">Nombre Programa</label>
				<input type="text" id="otro-sistema" name="otro_sistema" value="" class="form-control" />
			</div>
			<div class="form-group">
				<label class="control-label required"><?php _e('Nivel de Conocimiento', 'rrhh'); ?></label>
				<select class="form-control" id="sistema-nivel" name="nivel" required>
					<option value="">Seleccione</option>
					<option value="BASICO">BASICO</option>
					<option value="INTERMEDIO">INTERMEDIO</option>
					<option value="AVANZADO">AVANZADO</option>                                            
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<a href="javascript:;" class="btn btn-default" data-dismiss="modal">Cerrar</a>
			<button type="submit" class="btn btn-green"><?php _e('Guardar', 'rrhh'); ?></button>
		</div>
	</form>
</div>
