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

$pianificazioni = CronsQuery::create()
	->orderByNextDate('desc')
	->orderByNextTime('desc')
	->find();

?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Inserimento Pianificazioni dello streaming</h2>
				<h3 class="text-danger">Inserire i dati relativi alle pianificazioni</h3>


				<table class="table table-condensed">

					<thead>
					<tr>
						<th>Quando</th>
						<th>Video</th>
						<th>Dove</th>
						<th>Elimina</th>

					</tr>
					</thead>
					<tbody>

					<?php

					foreach ($pianificazioni as $pianificazione) {

						$associazione = VideosHasDestinazioniQuery::create()
							->filterByIdvideosHasDestinazioni($pianificazione->getVideosHasDestinazioniIdvideosHasDestinazioni())
							->findOne();

						$video = VideosQuery::create()
							->findPk($associazione->getVideosIdvideo());

						$destinazione = DestinazioniQuery::create()
							->findPk($associazione->getDestinazioniIddestinazione());


						?>
						<tr>
							<td>
								<?//=$pianificazione->getGiornoDelMese()."/".$pianificazione->getMese()." alle ore ".$pianificazione->getOra().":".$pianificazione->getMinuto()?>
								<?=$pianificazione->getNextDate()!=""?($pianificazione->getNextDate()->format('d/m/Y')." alle ore ".$pianificazione->getNextTime()->format('H:i')):""?>
							</td>
							<td><?=(is_object($video))!=''?($video->getNome()):"Video non presente"?></td>
							<td><?=(is_object($destinazione))?($destinazione->getNome()):"Destinzaione non presente"?></td>

							<td>
								<a href="del_cron.php?id_pianificazione=<?=$pianificazione->getIdcron()?>" class="btn btn-danger">Elimina</a>
							</td>


						</tr>
					<?php
					}
					?>

				</table>

				<br>

			</div>
		</div>
	</div>
</div>
