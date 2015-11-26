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

$idprogetto = $_GET['idprogetto'];
$progetto = ProgettiQuery::create()
	->findPk($idprogetto);
?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
	<!-- Colonna centrale-SX -->
	<div class="col-xs-12 col-sm-9">

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Risparmio in Eur. per il progetto <?=$progetto->getProgetto()?> </h3>
				</div>
				<div class="panel-body">
					<script src="/include/grafici/charts/amcharts/amcharts.js"></script>
					<script src="/include/grafici/charts/amcharts/serial.js"></script>
					<script src="/include/grafici/charts/amcharts/plugins/dataloader/dataloader.min.js"></script>

					<div id="chartdiv" style="width: 100%; height: 500px;"></div>
					<script>
						var chart = AmCharts.makeChart( "chartdiv", {
							"type": "serial",
							"dataLoader": {
								"url": "data_grafico_singolo_prj.php?<?='idprogetto='.$idprogetto?>"
							},
							"pathToImages": "/include/grafici/charts/amcharts/images/",
							"categoryField": "x",
							"dataDateFormat": "YYYY-MM-DD",
							"startDuration": 1,
							"categoryAxis": {
								"parseDates": true
							},
							"graphs": [ {
								"fillAlphas": 0.5,
								"valueField": "y",
								"bullet": "round",
								"bulletBorderColor": "#FFFFFF",
								"bulletBorderThickness": 2,
								"lineThickness ": 2,
								"lineAlpha": 0.5
							} ]
						} );
					</script>
				</div>
			</div>

	</div>
	</div>
</div>




<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>