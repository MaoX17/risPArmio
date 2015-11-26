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

//$user_db = $cfg->getValue('UserDB');
$titolo_pagina = $cfg->getValue('titolo_applicazione');

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

include($percorso_relativo."read_video.php");

?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Inserimento Video da mandare in stream</h2>
				<h3 class="text-danger">Inserire i dati relativi al video</h3>

				<form role="form" name='frmVideo' id='frmVideo' action="ins_video2.php" method="post" enctype="multipart/form-data">

					<div class="form-group">
						<label for="nome">Nome che identifica il Video</label>
						<input type="text" class="form-control" name="nome" id="nome" placeholder="Example: Video Pubblicitario 01" required>
					</div>
					<hr>

					<div class="form-group col-xs-offset-1">
						<label for="server_address">URL del video (Dropbox, OneDrive, GoogleDrive - Ricorda di condividerlo)</label>
						<input type="url" class="form-control" name="server_address" id="server_address" placeholder="Example: https://dl.dropboxusercontent.com/u/44747062/ProvinciaWIFI.flv">
					</div>
					<b>oppure</b><br><br>

					<div class="form-group col-xs-offset-1">
						<label for="file">Upload File</label>
						<input type="file" class="form-control" name="upload_file" id="upload_file" >
					</div>


					<br>
					<button type="submit" class="btn btn-default">Salva</button>

				</form>

				<div id="sbar" class="progress progress-bar-info" style="width:0px;">
					<div class="bar"></div >
					<div class="percent">0%</div >
				</div>

				<div id="status"></div>

			</div>
		</div>
	</div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>


<!-- progress bar upload -->
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">

$(function() {

var bar = $('.bar');
var bar2 = $('#sbar');
var percent = $('.percent');
var status = $('#status');

$('#frmVideo').ajaxForm({
	beforeSend: function() {
		status.empty();
		var percentVal = '0%';
		bar.width(percentVal);
		bar2.width(percentVal);
		percent.html(percentVal);
	},
	uploadProgress: function(event, position, total, percentComplete) {
		var percentVal = percentComplete + '%';
		bar.width(percentVal);
		bar2.width(percentVal);
		percent.html(percentVal);
	},
	complete: function(xhr) {
		status.html(xhr.responseText);
	}
});
});

</script>