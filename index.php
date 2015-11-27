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

?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">risPArmio - Dettagli e Informazioni</h2>
				<h3>Le nostre scelte</h3>
				<p>
				Con questo progetto la Provincia di Prato intende rendere visibile
				un'attivit&agrave; quotidiana svolta dal personale del Servizio Risorse Informatiche e
				Sit per fornire servizi informatici in modo da incidere il meno possibile sul bilancio dell'Ente.
				</p>
				<p>
				Infatti, attraverso l'uso della tecnologia <a href="https://it.wikipedia.org/wiki/Open_source">
						<b>Open Source</b></a>,
				che promuove poi la
					<a href="http://www.agid.gov.it/agenda-digitale/pubblica-amministrazione/riuso-software" target="_blank">
						buona pratica del Riuso</a>,
				&egrave; possibile implementare applicazioni equivalenti a soluzioni commerciali
				comunemente disponibili con i seguenti vantaggi:

				<ul>
					<li>indipendenza dal fornitore</li>
					<li>maggior controllo sui dati e sul funzionamento dell'applicazione software</li>
					<li>ridotto o nessun impatto sul bilancio dell'Ente</li>
				</ul>
				</p>
				<p>
				Questi risultati però richiedono un diverso approccio alla
				risoluzione dei problemi tecnici per l'implementazione del software e
				per la sua manutenzione quotidiana:
				saper fare rete con altri colleghi anche di altri amministrazioni
				ed essere in grado di acquisire maggiore autonomia e competenza sulle tecnologie in uso.
				</p>
				<p>
				Tutta questa attività è misurabile numericamente con un risparmio
					esprimibile come la <b>NON SPESA</b> sostenuta dall'Ente equiparando le
					implementazioni e le attivit&agrave; fatte dal personale del Servizio con
					l'uso di tecnologia Open Source raffrontandole a equivalenti
					soluzioni commerciali disponibili sul mercato, con le relative spese
					necessarie all'acquisizione del software con conseguente manutenzione periodica.
				</p>
				<p>
				Questi progetti consentono di ottimizzare i costi e i tempi di
					realizzazione e consentono la condivisione dell'analisi e del
					lavoro svolto con altre amministrazioni pubbliche favorendo cos&igrave; un circolo
					virtuoso di esperienze e di risparmi per la Pubblica Amministrazione.
				</p>
				<p>
				I prezzi commerciali di servizi analoghi a quelli realizzati internamente provengono dal portale <a href="https://www.acquistinretepa.it" target="_blank">"acquisti in rete PA"</a>.
				</p>
				<p>
				Nelle sezioni successive è disponibile un dettaglio sui
					progetti realizzati a basso impatto finanziario.
				</p>

				<a href="<?=$percorso_relativo?>tabella.php" class="btn btn-success">Maggiori Dettagli</a>

			</div>
		</div>
	</div>




	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<!-- <div class="well"> -->
				<h2 class="text-danger">Andamento dei risparmi ottenuti</h2>

				<!--------------------------------------------------------------------------->
				<?php
				include($percorso_relativo."include_graph_cache.html");
				?>
				<!--------------------------------------------------------------------------->



			<!-- </div> -->
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