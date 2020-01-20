<?php 
require_once MOD_RRHH_DIR . '/classes/class.announcement.php';
$obj = new RRHH_Announcement(1); 
?>
<style>
	/*#pagination{ display: none !important; }*/
</style>
<?php
?>
<div id="announcements-list" class="container">
	<h1><?php print $title; ?></h1>
	<?php //print $table->Show(); ?>

	<?php
	if(count($obj->GetAnnouncements()) > 0){
	?>
	<table class="table table-condensed">
	<thead>
	<tr>
		<th>Número</th>
		<th>Código</th>
		<th>Cargo</th>
		<th>Fecha finalización</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1; foreach($obj->GetAnnouncements() as $a): ?>
	<tr>
		<td><?php print $i; ?></td>
		<td><?php print $a->code; ?></td>
		<td><?php print $a->name; ?></td>
		<td><?php print $a->end_date; ?></td>
		<td>
			<a href="<?php print SB_Route::_('index.php?mod=rrhh&view=announcementpublic&id=&id='.$a->id); ?>" class="btn btn-default btn-sm" 
				title="Ver Convocatoria">
				<span class="glyphicon glyphicon-eye-open"></span>
				Ver Convocatoria
			</a>
		</td>
	</tr>
	<?php $i++; endforeach; ?>
	</tbody>
	</table>
	<?php }	else{echo '<div class="alert alert-info">En este momento no existen convocatorias vigentes disponibles.</div>';}?>
</div>