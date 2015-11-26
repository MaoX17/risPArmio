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

//var_dump($_POST);

$progetto = ProgettiQuery::create()
	->filterByProgetto($_POST['progetto'])
	->findOneOrCreate();
$progetto->setDescrizione($_POST['desc']);
$progetto->save();


if ($_POST['spesa_reale_unatantum'] != "") {
	$spesa_reale_una_tantum = SpeseQuery::create()
		->filterByTipologia($spesa_unatantum)
		->filterByRealePreventivo($spesa_sostenuta)
		->filterByDtDa($_POST['dt_spesa_reale_unatantum'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_reale_una_tantum->setSpesa($_POST['spesa_reale_unatantum']);
	$spesa_reale_una_tantum->save();
	$srt = $_POST['spesa_reale_unatantum'];
}

if ($_POST['spesa_prev_unatantum'] != "") {
	$spesa_prev_una_tantum = SpeseQuery::create()
		->filterByTipologia($spesa_unatantum)
		->filterByRealePreventivo($spesa_preventivata)
		->filterByDtDa($_POST['dt_spesa_prev_unatantum'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_prev_una_tantum->setSpesa($_POST['spesa_prev_unatantum']);
	$spesa_prev_una_tantum->save();
	$spt = $_POST['spesa_prev_unatantum'];
}
//----------------------
if ($_POST['spesa_reale_periodo'] != "") {
	$spesa_reale_periodo = SpeseQuery::create()
		->filterByTipologia($spesa_periodica)
		->filterByRealePreventivo($spesa_sostenuta)
		->filterByDtDa($_POST['dt_da_spesa_reale'])
		->filterByDtA($_POST['dt_a_spesa_reale'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_reale_periodo->setSpesa($_POST['spesa_reale_periodo']);
	$spesa_reale_periodo->save();
	$srp = $_POST['spesa_reale_periodo'];
}
if ($_POST['spesa_prev_periodo'] != "") {
	$spesa_prev_periodo = SpeseQuery::create()
		->filterByTipologia($spesa_periodica)
		->filterByRealePreventivo($spesa_preventivata)
		->filterByDtDa($_POST['dt_da_spesa_prev'])
		->filterByDtA($_POST['dt_a_spesa_prev'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_prev_periodo->setSpesa($_POST['spesa_prev_periodo']);
	$spesa_prev_periodo->save();
	$spp = $_POST['spesa_prev_periodo'];
}

	//---------------------------
if ($_POST['spesa_reale_anno'] != "") {
	$spesa_reale_annua = SpeseQuery::create()
		->filterByTipologia($spesa_annuale)
		->filterByRealePreventivo($spesa_sostenuta)
		->filterByDtDa($_POST['dt_spesa_reale_anno'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_reale_annua->setSpesa($_POST['spesa_reale_anno']);
	$spesa_reale_annua->save();
	$sra = $_POST['spesa_reale_anno'];
}
if ($_POST['spesa_prev_anno'] != "") {
	$spesa_prev_annua = SpeseQuery::create()
		->filterByTipologia($spesa_annuale)
		->filterByRealePreventivo($spesa_preventivata)
		->filterByDtDa($_POST['dt_spesa_prev_anno'])
		->filterByProgettiIdprogetto($progetto->getIdprogetto())
		->findOneOrCreate();
	$spesa_prev_annua->setSpesa($_POST['spesa_prev_anno']);
	$spesa_prev_annua->save();
	$spa = $_POST['spesa_prev_anno'];
}

?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Inserimento Progetti e Spese</h2>
				<h3 class="text-danger">Dati si progetto e spese</h3>


				<table class="table table-condensed">

					<thead>
					<tr>
						<th>Progetto</th>
						<th>Spese Preventivate</th>
						<th>Spese Reali</th>

					</tr>
					</thead>
					<tbody>

					<tr>
						<td>
							<?=$progetto->getProgetto()?>
						</td>
						<td><?=$spt + $spp + $spa ?></td>
						<td><?=$$srt + $srp + $sra ?></td>


					</tr>

				</table>


				<p>
					Ricorda di ricostruire la tabella della cache -> <a href="ricostruisci_cache.php" class="btn btn-warning">Ricostruisci Cache</a>
				</p>
				<br>

				<a href="inserisci.php" class="btn btn-success">Nuovo inserimento</a>

			</div>
		</div>
	</div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
