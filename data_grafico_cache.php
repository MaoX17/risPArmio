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


$spese_cache = CacheDataQuery::create()
	->orderByDt('asc')
	->find();

$dati_grafico = array();

foreach ($spese_cache as $spesa_cache) {
	$dati_grafico[] = array("x" => $spesa_cache->getDt()->format('Y-m-d'), "y" => $spesa_cache->getTot());
}

echo json_encode( $dati_grafico );

?>
