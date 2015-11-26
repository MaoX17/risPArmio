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

//require_once ($percorso_relativo.'oauth2callback.php');

//$user_db = $cfg->getValue('UserDB');
$titolo_pagina = $cfg->getValue('titolo_applicazione');
$folder_dest = $cfg->getValue('folder_dest_video');
$link_folder_video = $cfg->getValue('link_folder_video');
$fmpeg_command = $cfg->getValue('ffmpeg_command');

//include($percorso_relativo."grafica/head_bootstrap.php");
//include($percorso_relativo."grafica/body_head_bootstrap.php");


//Se ho inserito il link
if ($_POST['server_address'] != "") {
	$video = VideosQuery::create()
		->filterByLinkVideo($_POST['server_address'])
		->filterByNome($_POST['nome'])
		->findOneOrCreate();
	$video->setUploadedVideo(0);

	$video->save();
}

//se ho fatto upload
else {

	$storage = new \Upload\Storage\FileSystem($folder_dest);
	$file = new Upload\File('upload_file', $storage);

	// Validate file upload
	// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
	//$file->addValidations(array(
		// Ensure file is of type "image/png"
	//	new \Upload\Validation\Mimetype('image/png'),

		//You can also add multi mimetype validation
		//new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

		// Ensure file is no larger than 5M (use "B", "K", M", or "G")
	//	new \Upload\Validation\Size('5M')
	//));

	$filenameWithExtension = $file->getNameWithExtension();
	$fileSize = $file->getSize();

	$full_link_video = $link_folder_video."/".rawurlencode($filenameWithExtension);
	$full_path_video = $folder_dest."/".$filenameWithExtension;

	// Try to upload file
	try {
		// Success!
		@unlink($full_path_video);

		$file->upload();

		$video = VideosQuery::create()
			->filterByLinkVideo($full_link_video)
			->filterByNome($_POST['nome'])
			->filterBySizeVideo($fileSize)
			->findOneOrCreate();
		$video->setUploadedVideo(1);

		$video->save();

	} catch (\Exception $e) {
	// Fail!
	$errors = $file->getErrors();
	}

} // fine else


?>

<!--
<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-xs-12 col-sm-9">
			<div class="well">
				<h2 class="text-danger">Inserimento Video</h2>
				<h3 class="text-danger">Inserimento dati relativi al video</h3>
				<table class="table table-condensed">
					<thead>
					<tr>
						<th>Nome</th>
						<th>Link di accesso</th>
						<th>Dimensione (opz.)</th>
						<th>Locale/Remoto</th>
					</tr>
					</thead>
					<tbody>
				<tr>
					<td><?=$video->getNome()?></td>
					<td><?=$video->getLinkVideo()?></td>
					<td><?=number_format(($video->getSizeVideo() / 1024), 2, ',', '.')." KB";?></td>
					<td><?=($video->getUploadedVideo()==0?'<span class="glyphicon glyphicon-cloud"></span>':'<span class="glyphicon glyphicon-film"></span>')?></td>
				</tr>
				</table>
					<br>
				<a href="ins_video.php" class="btn btn-success">Nuovo inserimento Video</a>
			</div>
		</div>
	</div>
</div>
-->

<a href="ins_video.php" class="btn btn-success">Video Inserito - Clicca qui per continuare.</a>


<?
//include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

