<?php
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
?>
<!--
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
-->

<?php
$percorso_relativo = "./";
require ($percorso_relativo."include.inc.php");
// setup the autoloading
require_once ($percorso_relativo.'vendor/autoload.php');
//require_once 'vendor/autoload.php';
// setup Propel
require_once ($percorso_relativo.'propel/config.php');

require_once ('class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();

$titolo_pagina = $cfg->getValue('titolo_applicazione');
$folder_dest = $cfg->getValue('folder_dest_video');
$link_folder_video = $cfg->getValue('link_folder_video');
$fmpeg_command = $cfg->getValue('ffmpeg_command');

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

include($percorso_relativo."read_cron.php");


$videos = VideosQuery::create()
	->find();

$destinazioni = DestinazioniQuery::create()
	->find();


?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Inserimento Pianificazioni dello streaming</h2>
				<h3 class="text-danger">Inserire i dati relativi alle pianificazioni</h3>

				<form role="form" name='frmVideo' id='frmVideo' action="ins_cron2.php" method="post" enctype="multipart/form-data">

					<table class="table table-condensed">
						<thead>
						<tr>
							<th>Data</th>
							<th>Ora</th>
<!--
							<th>Giorno</th>
							<th>Mese</th>
							<th>Ora</th>
							<th>Minuto</th>
	-->
							<th>Video</th>
							<th>Destinazione</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<input type="text" class="datetimepicker" name="next_date" id="next_date">
							</td>
							<td>
								<input type="text" class="datetimepicker" name="next_time" id="next_time">
							</td>
<!--
							<td>
								<select class="form-group" name="giorno">
									<option class="form-group" value="x">Tutti</option>
									<?php
									for ($i=1;$i<=31;$i++) {
									?>
										<option class="form-group" value="<?=$i?>"><?=$i?></option>
									<?php
									}
									?>
								</select>
							</td>
							<td>
								<select class="form-group" name="mese">
									<option class="form-group" value="x">Tutti</option>
									<?php
									for ($i=1;$i<=12;$i++) {
										?>
										<option class="form-group" value="<?=$i?>"><?=$i?></option>
									<?php
									}
									?>
								</select>
							</td>

							<td>
								<select class="form-group" name="ora">
									<option class="form-group" value="x">Tutti</option>
									<?php
									for ($i=0;$i<=23;$i++) {
										?>
										<option class="form-group" value="<?=$i?>"><?=$i?></option>
									<?php
									}
									?>
								</select>
							</td>
							<td>
								<select class="form-group" name="minuto">
									<option class="form-group" value="x">Tutti</option>
									<?php
									for ($i=0;$i<=59;$i++) {
										?>
										<option class="form-group" value="<?=$i?>"><?=$i?></option>
									<?php
									}
									?>
								</select>
							</td>
-->
							<td>
								<select class="form-group" name="video">
									<?php
									foreach ($videos as $video) {
										?>
										<option class="form-group" value="<?=$video->getIdvideo()?>"><?=$video->getNome()?></option>
									<?php
									}
									?>
								</select>
							</td>
							<td>
								<select class="form-group" name="destinazione">
									<?php
									foreach ($destinazioni as $destinazione) {
										?>
										<option class="form-group" value="<?=$destinazione->getIddestinazione()?>"><?=$destinazione->getNome()?></option>
									<?php
									}
									?>
								</select>
							</td>
						</tr>
					</table>

					<br>
					<button type="submit" class="btn btn-default">Salva</button>

				</form>


			</div>
		</div>
	</div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>



<script type="text/javascript">

	$("#next_date").datetimepicker({
		format: "yyyy-mm-dd",
		linkField: "next_time",
		linkFormat: "hh:ii",
		todayBtn: true,
		autoclose: true,
		pickDate: true,
		pickTime: false,
		pickerPosition: "bottom-left",
		minuteStep: 30,
		language: "it"
		//minView: 2
	});



</script>