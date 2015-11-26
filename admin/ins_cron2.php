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
$folder_dest = $cfg->getValue('folder_dest_video');
$link_folder_video = $cfg->getValue('link_folder_video');
$fmpeg_command = $cfg->getValue('ffmpeg_command');

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");



//var_dump($_POST);



$video = VideosQuery::create()
	->findPk($_POST['video']);

$destinazione = DestinazioniQuery::create()
	->findPk($_POST['destinazione']);

$associo_video_destinzaione = VideosHasDestinazioniQuery::create()
	->filterByVideosIdvideo($video->getIdvideo())
	->filterByDestinazioniIddestinazione($destinazione->getIddestinazione())
	->findOneOrCreate();
$associo_video_destinzaione->save();

$pianificazione = CronsQuery::create()
	->filterByNextDate($_POST['next_date'])
	->filterByNextTime($_POST['next_time'])
	->filterByVideosHasDestinazioniIdvideosHasDestinazioni($associo_video_destinzaione->getIdvideosHasDestinazioni())
	->findOneOrCreate();

//$pianificazione->setVideosHasDestinazioniIdvideosHasDestinazioni($associo_video_destinzaione->getIdvideosHasDestinazioni());

//costruisco il comando
//$comando_completo = $fmpeg_command.' -i "'.$video->getLinkVideo().'" -deinterlace -vcodec libx264 -pix_fmt yuv420p -preset fast -r 30 -g 60 -b:v 64k -acodec libmp3lame -ar 44100 -threads 3 -b:a 712000 -bufsize 256k -f flv "'.$destinazione->getStreamServer().'/'.$destinazione->getKeyServer().'"';

//TODO: distinguere se locale o remoto e trovare il comando più opportuno
//$comando_completo = $fmpeg_command.' -i "'.$video->getLinkVideo().'" -vcodec libx264 -pix_fmt yuv420p -preset slow -r 30 -g 60 -b:v 512k -tune zerolatency -acodec libmp3lame -ar 44100 -threads 3 -b:a 712000 -bufsize 256k -f flv "'.$destinazione->getStreamServer().'/'.$destinazione->getKeyServer().'"';
//$comando_completo = $fmpeg_command.' -re -i "'.$video->getLinkVideo().'" -vb 400k -minrate 300k -maxrate 700k -bufsize 400k -aspect 426:240 -s 426x240 -c:v libx264 -profile:v -level -r 30 -g 60 -keyint_min 60 -x264opts "keyint=60:min-keyint=60:no-scenecut" -c:a libfdk_aac -ab 128k -ar 48000 -f flv "'.$destinazione->getStreamServer().'/'.$destinazione->getKeyServer().'"';
///usr/bin/ffmpeg -re -i "https://dl.dropboxusercontent.com/u/44747062/ProvinciaWIFI.flv" -vb 400k -minrate 300k -maxrate 700k -bufsize 400k -vcodec libx264 -pix_fmt yuv420p -preset fast -r 30 -g 60 -acodec libmp3lame -ar 44100 -b:a 128k -bufsize 512k -f flv rtmp://a.rtmp.youtube.com/live2/maurizio.proietti.e2wk-tgz9-hzrk-91g3
///usr/bin/ffmpeg -re -i "http://159.213.89.77/stream-project/videos/ProvinciaWIFI.flv" -vcodec libx264 -preset veryfast -maxrate 800k -bufsize 1600k -pix_fmt yuv420p -g 50 -acodec libmp3lame -b:a 128k -ac 2 -ar 44100 -f flv rtmp://a.rtmp.youtube.com/live2/maurizio.proietti.e2wk-tgz9-hzrk-91g3
//$comando_completo = $fmpeg_command.' -re -i "'.$video->getLinkVideo().'" -vb 400k -minrate 300k -maxrate 700k -bufsize 400k -s 426x240 -vcodec libx264 -pix_fmt yuv420p -preset fast -r 30 -g 60 -acodec libmp3lame -ar 44100 -b:a 128k -bufsize 512k -f flv "'.$destinazione->getStreamServer().'/'.$destinazione->getKeyServer().'"';
$comando_completo = $fmpeg_command.' -re -i "'.$video->getLinkVideo().'" -loop 2 -vcodec libx264 -preset veryfast -maxrate 800k -bufsize 1600k -pix_fmt yuv420p -g 50 -acodec libmp3lame -b:a 128k -ac 2 -ar 44100 -f flv  "'.$destinazione->getStreamServer().'/'.$destinazione->getKeyServer().'"';
$pianificazione->setComando($comando_completo);


$pianificazione->save();

//Modifico pianificazione in modo che il carattere x corrisponda ad *
$minuto = $pianificazione->getMinuto()=="x"?"*":$pianificazione->getMinuto();
$ora = $pianificazione->getOra()=="x"?"*":$pianificazione->getOra();
$giorno = $pianificazione->getGiornoDelMese()=="x"?"*":$pianificazione->getGiornoDelMese();
$mese = $pianificazione->getMese()=="x"?"*":$pianificazione->getMese();

//TODO: Inserire il cron vero e proprio

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

					</tr>
					</thead>
					<tbody>

					<tr>
						<td>
							<?=$pianificazione->getNextDate()->format('d/m/Y')." alle ore ".$pianificazione->getNextTime()->format('H:i')?>
						</td>
						<td><?=$video->getNome()?></td>
						<td><?=$destinazione->getNome()?></td>


					</tr>

				</table>

				<br>

				<a href="ins_cron.php" class="btn btn-success">Nuovo inserimento</a>

			</div>
		</div>
	</div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>




<script type="text/javascript">

	$("#prv_dt_pagamento").datetimepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		pickerPosition: "bottom-left",
		language: "it",
		minView: 2
	});



</script>
