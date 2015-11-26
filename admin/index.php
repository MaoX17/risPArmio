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
$percorso_relativo = "../";
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



?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Sezione Admin</h2>
				<h3 class="text-danger">Sezione che permette l'inserimento e la modifica dei dati</h3>

				<a href="/admin/inserisci.php" class="btn btn-success">Inserimento</a> <br><br>

				<a href="/admin/ricostruisci_cache.php" class="btn btn-danger">Ricostruisci tabella di cache</a> <br><br>




			</div>
		</div>
	</div>
</div>



<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

<script src="<?=$percorso_relativo?>include/jcounter/jquery.counter.js" type="text/javascript"></script>
<script>
	$('.counter').counter();
	$('#custom').addClass('counter-analog').counter({
		//initial: '0:00.0',
		initial: '1000',
		direction: 'up',
		interval: '1',
		format: '9999'
		//stop: '2012'
	});
</script>


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