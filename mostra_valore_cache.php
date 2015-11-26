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
//require ($percorso_relativo."include.inc.php");
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
//include($percorso_relativo."grafica/body_head_bootstrap.php");

$spesa_cache = CacheDataQuery::create()
	->orderByDt('desc')
	->limit(1)
	->findOne();

$spesa_finale = round($spesa_cache->getTot(),0);

?>
<link href="<?=$percorso_relativo?>include/jcounter/jquery.counter-analog.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=$percorso_relativo?>include/jcounter/jquery.counter-analog2.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=$percorso_relativo?>include/jcounter/jquery.counter-analog3.css" media="screen" rel="stylesheet" type="text/css" />

				<!--------------------------------------------------------------------------->
<b>Ad oggi abbiamo risparmiato:
				<span class="counter counter-analog" data-direction="up"  data-interval="1" data-format="999999" data-stop="<?=$spesa_finale?>"><?=($spesa_finale - 500)?></span>
<span class="glyphicon-euro"></span> </b><br>
<a target="_blank" class="btn btn-xs btn-success" href="http://risparmio.provincia.prato.it">Scopri come</a>
<!--------------------------------------------------------------------------->

<script src="<?=$percorso_relativo?>libs/js/jquery/jquery.min.js"></script>
<script src="<?=$percorso_relativo?>libs/js/jquery/jquery-migrate.min.js"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap/js/bootstrap.min.js"></script>

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