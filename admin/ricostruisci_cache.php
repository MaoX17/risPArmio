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

<?php


$i = 0;
//Trovo la data di inizio
$spese = SpeseQuery::create()
	->orderByDtDa('asc')
	->limit(1)
	->findOne();

$data_inizio = $spese->getDtDa();

//oggi
$data_fine = new DateTime();

//Intervallo giornaliero
$interval = new DateInterval('P1D');
$period = new DatePeriod($data_inizio, $interval, $data_fine);
$spesa_totale_osservazione = 0;
$dati_grafico = array();
foreach ($period as $data_osservazione) {

	//qui dovrei calcolare la spesa
	$spesa_osservazione = SpeseQuery::create()
		->filterByDtDa(array('max' => $data_osservazione))
		->find();

	foreach ($spesa_osservazione as $ss) {
		//una tantum
		if (($ss->getTipologia() == $spesa_unatantum) AND ($ss->getDtDa() == $data_osservazione)){
			if ($ss->getRealePreventivo() == $spesa_sostenuta) {
				//NB i segni sono al contrario perchè cerco il risparmio
				$spesa_totale_osservazione = $spesa_totale_osservazione - $ss->getSpesa();
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $ss->getSpesa();
			}

		}
		//spesa sostenuta per un periodo
		elseif ($ss->getTipologia() == $spesa_periodica) {

			//calcolo il nr di giorni fra l'inizio e la data di osservazione
			$interval = $data_osservazione->diff($ss->getDtDa());
			//echo $interval->format('%R%a days');
			$giorni_a_moltiplicare =  $interval->format('%a');

			//nr giorni fra inizio e fine del periodo di spesa
			$interval = $ss->getDtA()->diff($ss->getDtDa());
			$giorni_a_dividere =  $interval->format('%a');

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere);//*$giorni_a_moltiplicare;

			if ($ss->getRealePreventivo() == $spesa_sostenuta) {

				$spesa_totale_osservazione = $spesa_totale_osservazione - $spesa_puntuale;
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $spesa_puntuale;
			}

		}
		elseif ($ss->getTipologia() == $spesa_annuale) {
			//calcolo il nr di giorni fra l'inizio e la data di osservazione
			$interval = $data_osservazione->diff($ss->getDtDa());
			$giorni_a_moltiplicare =  $interval->format('%a');

			//nr giorni fra inizio e fine del periodo di spesa
			//in questo caso sono sempre 365
			$giorni_a_dividere =  365;

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere);//*$giorni_a_moltiplicare;

			if ($ss->getRealePreventivo() == $spesa_sostenuta) {

				$spesa_totale_osservazione = $spesa_totale_osservazione - $spesa_puntuale;
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $spesa_puntuale;
			}

		}
		elseif ($ss->getTipologia() == $spesa_mensile) {
			//calcolo il nr di giorni fra l'inizio e la data di osservazione
			$interval = $data_osservazione->diff($ss->getDtDa());
			$giorni_a_moltiplicare =  $interval->format('%a');

			//nr giorni fra inizio e fine del periodo di spesa
			//TODO: i giorni a dividere NON sono sempre 30
			//in questo caso sono sempre 30??
			$giorni_a_dividere =  30;

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere);//*$giorni_a_moltiplicare;

			if ($ss->getRealePreventivo() == $spesa_sostenuta) {

				$spesa_totale_osservazione = $spesa_totale_osservazione - $spesa_puntuale;
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $spesa_puntuale;
			}

		}

	}

	$cache = CacheDataQuery::create()
		->filterByDt($data_osservazione->format('Y-m-d'))
		->findOneOrCreate();
	$cache->setTot(round($spesa_totale_osservazione,2));
	$cache->save();

	$i++;
}
?>


				Ho aggiornato o creato
				<span class="badge badge-success"><?=$i?></span>
				righe nella cache!!!
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