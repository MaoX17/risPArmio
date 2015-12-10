
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
//imposto la valuta
setlocale(LC_MONETARY, 'it_IT');
//progetti per pagina
$limit_per_page = 10;
$page = (isset($_GET['page']))?$_GET['page']:1;

//uso paginate x impaginazione
$progetti = ProgettiQuery::create()
	->paginate($page, $limit_per_page);
?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-12">
			<!-- <div class="well"> -->
				<h2 class="text-danger">Informazioni dettagliate</h2>
				<h3 class="text-danger"></h3>


				<div class="panel-group" id="accordion">
				<?php

				foreach ($progetti as $progetto) {
					$idprogetto = $progetto->getIdprogetto();


					?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$idprogetto?>"><?=$progetto->getProgetto()?></a>
							</h4>
						</div>
						<div id="collapse<?=$idprogetto?>" class="panel-collapse collapse">
							<div class="panel-body">
								<dl class="dl-horizontal">
									<dt>Progetto:</dt>
									<dd><?=$progetto->getDescrizione()?></dd>
									<dd><a href="<?=$percorso_relativo?>include_graph_singolo_prj.php?idprogetto=<?=$idprogetto?>"
										   class="btn btn-info" onclick="target='_blank';">Andamento del risparmio nel tempo</a></dd>
								</dl>
								<!-- <b>Descrizione del progetto:</b> <br>
								<?=$progetto->getDescrizione()?> -->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="panel panel-success">
											<div class="panel-heading">
												<h3 class="panel-title">Soluzione adottata</h3>
											</div>
											<div class="panel-body">
												<ul class="list-group">
													<?php
													$spese_reali = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_sostenuta)
														->filterByTipologia($spesa_unatantum)
														->find();
													foreach ($spese_reali as $spesa_reale) {
														echo '<li class="list-group-item">';
															echo '<b>Spesa UnaTantum del '.$spesa_reale->getDtDa()->format('d/m/Y').'</b>';
															echo '<span class="badge">'.money_format('%.2n', $spesa_reale->getSpesa()).'</span>';
														echo '</li>';
													}
													?>


													<?php
													$spese_reali = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_sostenuta)
														->filterByTipologia($spesa_periodica)
														->find();
													foreach ($spese_reali as $spesa_reale) {
														echo '<li class="list-group-item">';
															echo '<b>Spesa complessiva dal '.$spesa_reale->getDtDa()->format('d/m/Y').'
																al '.$spesa_reale->getDtA()->format('d/m/Y').'</b>';
															echo '<span class="badge">'.money_format('%.2n', $spesa_reale->getSpesa()).' </span>';
														echo '</li>';
													}
													?>

													<?php
													$spese_reali = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_sostenuta)
														->filterByTipologia($spesa_annuale)
														->find();
													foreach ($spese_reali as $spesa_reale) {
														echo '<li class="list-group-item">';
															echo '<b>Spesa annuale dal '.$spesa_reale->getDtDa()->format('d/m/Y').'</b>';
															echo '<span class="badge">'.money_format('%.2n', $spesa_reale->getSpesa()).'</span>';
														echo '</li>';
													}
													?>


												</ul>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="panel panel-warning">
											<div class="panel-heading">
												<h3 class="panel-title">Soluzione Commerciale equivalente</h3>
											</div>
											<div class="panel-body">
												<ul class="list-group">
													<?php
													$spese_preventivi = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_preventivata)
														->filterByTipologia($spesa_unatantum)
														->find();
													foreach ($spese_preventivi as $spesa_preventivo) {
														echo '<li class="list-group-item">';
														echo '<b>Spesa UnaTantum del '.$spesa_preventivo->getDtDa()->format('d/m/Y').'</b>';
														echo '<span class="badge">'.money_format('%.2n', $spesa_preventivo->getSpesa()).'</span>';
														echo '</li>';
													}
													?>


													<?php
													$spese_preventivi = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_preventivata)
														->filterByTipologia($spesa_periodica)
														->find();
													foreach ($spese_preventivi as $spesa_preventivo) {
														echo '<li class="list-group-item">';
														echo '<b>Spesa complessiva dal '.$spesa_preventivo->getDtDa()->format('d/m/Y').'
																al '.$spesa_preventivo->getDtA()->format('d/m/Y').'</b>';
														echo '<span class="badge">'.money_format('%.2n', $spesa_preventivo->getSpesa()).' </span>';
														echo '</li>';
													}
													?>

													<?php
													$spese_preventivi = SpeseQuery::create()
														->filterByProgettiIdprogetto($progetto->getIdprogetto())
														->filterByRealePreventivo($spesa_preventivata)
														->filterByTipologia($spesa_annuale)
														->find();
													foreach ($spese_preventivi as $spesa_preventivo) {
														echo '<li class="list-group-item">';
														echo '<b>Spesa annuale dal '.$spesa_preventivo->getDtDa()->format('d/m/Y').'</b>';
														echo '<span class="badge">'.money_format('%.2n', $spesa_preventivo->getSpesa()).'</span>';
														echo '</li>';
													}
													?>

												</ul>
											</div>
										</div>
									</div>



								</div>
							</div>
						</div>
					</div>

				<?php

				}
				?>

				</div>
			<!-- </div> -->
		</div>
	</div>


	<?php // PropelModelPager offers a convenient API to display pagination controls ?>
	<?php if($progetti->haveToPaginate()): ?>
		<div class="pagination">
			<ul class='pagination'>
				<li>
					<a href="#"><?php echo $progetti->getPage() ?> di <?php echo $progetti->getLastPage() ?></a>
				</li>
				<?php
				if ($progetti->getPage() == 1) {
					echo '<li class="disabled"><a href = "#">&laquo;</a></li>';
				}
				else {
					echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($progetti->getPage() - 1).'">&laquo;</a></li>';
				}
				?>

				<?php
				for ($i=1; $i<=$progetti->getLastPage(); $i++) {
					if ($i == $progetti->getPage()) {
						$active = ' class="active" ';
					}
					else {
						$active = '';
					}

					echo '<li'.$active.'>';
					echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a>';
					echo '</li>';
				}
				?>

				<?php
				if ($progetti->getPage() == $progetti->getLastPage()) {
				echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
				}
				else {
				echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($progetti->getPage() + 1).'">&raquo;</a></li>';
				}
				?>

			</ul>
			<p>
				Progetti dal nr. <?php echo $progetti->getFirstIndex() ?> al nr. <?php echo $progetti->getLastIndex() ?>
				<br/>
				Progetti totali: <?php echo $progetti->getNbResults() ?>
			</p>
		</div>


	<?php endif; ?>




</div>



<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
