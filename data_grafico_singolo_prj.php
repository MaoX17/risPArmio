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

//include($percorso_relativo."grafica/head_bootstrap.php");
//include($percorso_relativo."grafica/body_head_bootstrap.php");

//TODO: Inserire anche il grafico che mostra la situazione FUTURA (5 anni) x ogni progetto e per il complessivo

$idprogetto = $_GET['idprogetto'];

$progetto = ProgettiQuery::create()
	->findPk($idprogetto);

//Trovo la data di inizio
$spese = SpeseQuery::create()
	->filterByProgettiIdprogetto($idprogetto)
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
		->filterByProgettiIdprogetto($idprogetto)
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

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere);//;*$giorni_a_moltiplicare;

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
			//echo "<br>giorni molt = ".$giorni_a_moltiplicare;

			//nr giorni fra inizio e fine del periodo di spesa
			//in questo caso sono sempre 365
			$giorni_a_dividere =  365;

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere);//*$giorni_a_moltiplicare;
			//echo " - spesa puntuale = ".$spesa_puntuale;

			if ($ss->getRealePreventivo() == $spesa_sostenuta) {

				$spesa_totale_osservazione = $spesa_totale_osservazione - $spesa_puntuale;
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $spesa_puntuale;
			}
			//echo " - spesa tot = ".$spesa_totale_osservazione;

		}
		elseif ($ss->getTipologia() == $spesa_mensile) {
			//calcolo il nr di giorni fra l'inizio e la data di osservazione
			$interval = $data_osservazione->diff($ss->getDtDa());
			$giorni_a_moltiplicare =  $interval->format('%a');

			//nr giorni fra inizio e fine del periodo di spesa
			//TODO: i giorni a dividere NON sono sempre 30
			//in questo caso sono sempre 30??
			$giorni_a_dividere =  30;

			$spesa_puntuale = ($ss->getSpesa()/$giorni_a_dividere)*$giorni_a_moltiplicare;

			if ($ss->getRealePreventivo() == $spesa_sostenuta) {

				$spesa_totale_osservazione = $spesa_totale_osservazione - $spesa_puntuale;
			}
			elseif ($ss->getRealePreventivo() == $spesa_preventivata) {
				$spesa_totale_osservazione = $spesa_totale_osservazione + $spesa_puntuale;
			}

		}

	}
	setlocale(LC_MONETARY, 'it_IT');
	$dati_grafico[] = array("x" => $data_osservazione->format('Y-m-d'), "y" => round($spesa_totale_osservazione,2));

}

echo json_encode( $dati_grafico );

$_SESSION['ultimo'] = round($spesa_totale_osservazione,0);
?>
