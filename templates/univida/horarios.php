<?php
//1920x1080
$pages = lt_content_get_frontpage_items();
$services = uv_get_services(4);
lt_get_header();
?>
<style>
	.cntTabS{
}


/*
.cntTabS{
	width: 100%;
	overflow-y: scroll;
	margin-top: 10px;
}
*/
.wdthB{
	width: 100%;
}
.wdthBM{
	float: left;
	clear: none !important;
	width: 67%;
	margin: 0 15px !important;
}

.wdthBMC{
	width: 70%;
	margin: 0 auto !important;
}


.tabA{
	clear: both;
	font-size: 12px;
	margin: 30px auto;
}
.tabA thead th{
	color: #fff;
	font-family: 'open_sansextrabold', Arial, Tahoma, Verdana;
	font-weight: 100;
	line-height: 14px;
	text-align: center;
	padding: 10px 0 12px 0;
}
.tabA thead tr:nth-child(2) th{
	background: #ffae00;
}
.tabA .bLT{
	vertical-align: middle;
	text-transform: uppercase;
}
.tabA .bRT{
	border-left: 1px solid #ffffff;
}
.tabA .bRB{
	border-left: 1px solid #ffffff;
}

.tabA tbody td{
	font-size: 14px;
	line-height: 20px;
	text-align: center;
	padding: 9px 10px 11px 10px;
}

.tabA tbody tr td:nth-child(2n){
}
.tabA td, .tabA th{
	/* border: 1px solid #fff; */
	font-family: Arial !important
}
/* ---------------------------- TABLAS ---------------------------- */






.bg-guindo {
    background-color: #c2053b !important;
    color: #fff;
}
.bg-azul {
    background-color: #015a9c !important;
    color: #fff;
}
.bg-celeste {
    background-color: #0175c0 !important;
    color: #fff;
}
/* .wdthB tr:nth-child(even) {
    background-color: #dadada;
} */
h1 {
    color: #f8971f;
    font-size: 26px;
    font-family: 'open_sansextrabold', Arial, Tahoma, Verdana;
    font-weight: 100;
    line-height: 20px;
    text-align: center;
}

.contentIn .cntCntIn {
    overflow: hidden;
    position: relative;
    width: 1170px;
    min-height: 400px;
    margin: 0 auto;
    padding-top: 50px;
}
.contentIn {
    clear: both;
    position: relative;
    background: #ffffff;
    width: 100%;
}
</style>
<div class="contentIn">
	<div class="cntCntIn">

		<h1 class="bgLn">HORARIOS DE ATENCIÓN EN PUNTOS FIJOS (KIOSCOS)</h1>

		<div class="cntTabS">
			<table class="tabA wdthB" border="1">				
				<tbody>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>07/12/2019</td>
						<td>15/12/2019</td>
						<td>8:30</td>
						<td>18:30</td>
						<td>Horario ininterrumpido, incluyendo sábados y domingos</td>
					</tr>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>16/12/2019</td>
						<td>07/01/2020</td>
						<td>7:30</td>
						<td>18:30</td>
						<td>Horario ininterrumpido, incluyendo sábados y domingos</td>
					</tr>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>08/01/2020</td>
						<td>31/03/2020</td>
						<td>8:30</td>
						<td>18:30</td>
						<td>Horario ininterrumpido, incluyendo sábados y domingos</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="cntCntIn">

		<h1 class="bgLn">HORARIOS DE ATENCIÓN EN SUCURSALES Y AGENCIAS</h1>

		<div class="cntTabS">
			<table class="tabA wdthB" border="1">				
				<tbody>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>07/12/2019</td>
						<td>15/12/2019</td>
						<td>8:30 a 12:30</td>
						<td>14:30 a 18:30</td>
						<td>Horario discontinuo, incluyendo sábados y domingos</td>
					</tr>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>16/12/2019</td>
						<td>07/01/2020</td>
						<td>7:30</td>
						<td>18:30</td>
						<td>Horario ininterrumpido, incluyendo sábados y domingos</td>
					</tr>
					<tr>
						<td class="bg-azul">Fecha Inicio</td>
						<td class="bg-azul">Fecha Fin</td>
						<td class="bg-azul">Horario Inicio</td>
						<td class="bg-azul">Horario Fin</td>
						<td class="bg-azul">Observación</td>												
					</tr>
					<tr>						
						<td>08/01/2020</td>
						<td>31/01/2020</td>
						<td>8:30 a 12:30</td>
						<td>14:30 a 18:30</td>
						<td>Horario discontinuo, incluyendo sábados y domingos</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>

<?php lt_get_footer(); ?>