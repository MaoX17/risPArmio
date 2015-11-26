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



				<form role="form" name='frmIns' id='frmIns' action="inserisci2.php" method="post" enctype="multipart/form-data">

					<div class="form-group">
						<label for="nome">Nome che identifica il Progetto</label>
						<input type="text" class="form-control" name="progetto" id="progetto" placeholder="Example: Progetto Protocollo Informatico" required>
					</div>
					<div class="form-group">
						<label for="desc">Descrizione del Progetto </label>
						<input type="text" class="form-control" name="desc" id="desc" placeholder="Example: ....." required>
					</div>


					<div class="form-group col-xs-4">
						<h3>Spese Reali</h3>
						<label for="desc">Spesa una tantum</label>
						<input type="date" class="form-control" name="dt_spesa_reale_unatantum" id="dt_spesa_reale_unatantum" placeholder="01/01/2015">
						<input type="text" class="form-control" name="spesa_reale_unatantum" id="spesa_reale_unatantum">
					</div>
					<div class="form-group col-xs-4 col-xs-offset-4">
						<h3>Spese preventivate</h3>
						<label for="desc">Spesa una tantum</label>
						<input type="date" class="form-control" name="dt_spesa_prev_unatantum" id="dt_spesa_prev_unatantum" placeholder="01/01/2015">
						<input type="text" class="form-control" name="spesa_prev_unatantum" id="spesa_prev_unatantum" >
					</div>

					<div class="form-group col-xs-4">

						<label for="desc">Spesa nel periodo</label><br>
						da <input type="date" class="form-control" name="dt_da_spesa_reale" id="dt_da_spesa_reale" placeholder="01/01/2015">
						a <input type="date" class="form-control" name="dt_a_spesa_reale" id="dt_a_spesa_reale" placeholder="01/01/2015">
						spesa: <input type="text" class="form-control" name="spesa_reale_periodo" id="spesa_reale_periodo">
					</div>
					<div class="form-group col-xs-4 col-xs-offset-4">

						<label for="desc">Spesa nel periodo</label><br>
						da <input type="date" class="form-control" name="dt_da_spesa_prev" id="dt_da_spesa_prev" placeholder="01/01/2015">
						a <input type="date" class="form-control" name="dt_a_spesa_prev" id="dt_a_spesa_prev" placeholder="01/01/2015">
						spesa: <input type="text" class="form-control" name="spesa_prev_periodo" id="spesa_prev_periodo">
					</div>

					<div class="form-group col-xs-4">

						<label for="desc">Spesa annuale</label><br>
						inizio:
						<input type="date" class="form-control" name="dt_spesa_reale_anno" id="dt_spesa_reale_anno" placeholder="01/01/2015">
						<input type="text" class="form-control" name="spesa_reale_anno" id="spesa_reale_anno">
					</div>
					<div class="form-group col-xs-4 col-xs-offset-4">

						<label for="desc">Spesa annuale</label><br>
						inizio:
						<input type="date" class="form-control" name="dt_spesa_prev_anno" id="dt_spesa_prev_anno" placeholder="01/01/2015">
						<input type="text" class="form-control" name="spesa_prev_anno" id="spesa_prev_anno" >
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
