<?
//Configurazione da Singleton
require_once('class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance();
//imposto in path include a runtime 
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__)));
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__))."/pear");
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__))."/class");
//ini_set('include_path',ini_get('include_path').":/usr/share/pear");
date_default_timezone_set('Europe/Rome');

$titolo_pagina = $cfg->getValue('titolo_applicazione');

$spesa_unatantum = $cfg->getValue('spesa_unatantum');
$spesa_periodica = $cfg->getValue('spesa_periodica');
$spesa_annuale = $cfg->getValue('spesa_annuale');
$spesa_mensile = $cfg->getValue('spesa_mensile');

$spesa_sostenuta = $cfg->getValue('spesa_sostenuta');
$spesa_preventivata = $cfg->getValue('spesa_preventivata');

//var_dump($_SESSION);
/*
 * Eseguo le funzioni necessarie in ogni file:
 */
session_start();
function connetti_db($host, $user, $password, $db) {
	$mysqli = new mysqli($host, $user, $password, $db);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		exit(0);
	}
	return $mysqli;
/*
	$res = $mysqli->query("SELECT 'choices to please everybody.' AS _msg FROM DUAL");
	$row = $res->fetch_assoc();
	echo $row['_msg'];
*/
}

function cron_to_next_date($minuto, $ora, $giorno_del_mese, $mese, $giorno_della_settimana) {

	$next_date = new DateTime();
	$year = $next_date->format('Y');

	if ($minuto != '' AND (($minuto != '*') OR ($minuto != 'x'))) {
		$next_minuto = $minuto;
	}
	else {
		$next_minuto = $next_date->format('i');
	}

	if ($ora != '' AND (($ora != '*') OR ($ora != 'x'))) {
		$next_ora = $ora;
	}
	else {
		$next_ora = $next_date->format('G');
	}

	if ($giorno_del_mese != '' AND (($giorno_del_mese != '*') OR ($giorno_del_mese != 'x'))) {
		$next_giorno_mese = $giorno_del_mese;
	}
	else {
		$next_giorno_mese = $next_date->format('j');
	}

	if ($mese != '' AND (($mese != '*') OR ($mese != 'x'))) {
		$next_mese = $mese;
	}
	else {
		$next_mese = $next_date->format('m');
	}

	if($giorno_della_settimana != '' AND  (($giorno_della_settimana != '*') OR ($giorno_della_settimana != 'x'))) {
		$next_giorno_settimana = $giorno_della_settimana;
	}
	else {
		$next_giorno_settimana = $next_date->format('N');
	}



	$next_date->setDate($year,$next_mese,$next_giorno_mese);
	$next_date->setTime($next_ora,$next_minuto);

	return $next_date;

}

function map_tipologia($id_tipo) {
	$tipo = "";
	switch ($id_tipo) {
		case 1:
			$tipo ="YLE-STARTERS";
			break;
		case 2:
			$tipo ="YLE-MOVERS";
			break;
		case 3:
			$tipo ="KEY";
			break;
		case 4:
			$tipo ="PRELIMINARY";
			break;
		case 5:
			$tipo ="FIRST";
			break;
		case 6:
			$tipo ="ADVANCED";
			break;
		case 7:
			$tipo ="PROFICIENCY";
			break;
		case 8:
			$tipo ="BEC PRELIMIN";
			break;
		case 9:
			$tipo ="BEC VANTAGE";
			break;
	}
	return $tipo;
}
function contaIscritti($idesame) {
	require_once ('class/ConfigSingleton.php');
	$cfg = SingletonConfiguration::getInstance ();
	$user_db = $cfg->getValue('UserDB');
	$pass_db = $cfg->getValue('PassDB');
	$host_db = $cfg->getValue('HostDB');
	$name_db = $cfg->getValue('NameDB');
	$db = connetti_db($host_db, $user_db, $pass_db, $name_db);
	$sql = "SELECT sum(partecipazioni.nr_iscritti) as iscritti
			FROM partecipazioni
			WHERE
			idesame = ".$idesame.";";
	$rs = $db->query($sql);
	$row = $rs->fetch_assoc();
	return $row['iscritti'];
}
function iduser2user($iduser) {
	require_once ('class/ConfigSingleton.php');
	$cfg = SingletonConfiguration::getInstance ();
	$user_db = $cfg->getValue('UserDB');
	$pass_db = $cfg->getValue('PassDB');
	$host_db = $cfg->getValue('HostDB');
	$name_db = $cfg->getValue('NameDB');
	$db = connetti_db($host_db, $user_db, $pass_db, $name_db);
	$sql = "SELECT * FROM users WHERE id = ".$iduser.";";
	$rs = $db->query($sql);
	$row = $rs->fetch_assoc();
	$array_user = array('name' => $row['name'], 'email' => $row['email'], 'username' => $row['username'], 'password' => $row['password'], 'group' => $row['group']);
	return $array_user;
}
function idesame2esame($idesame) {
	require_once ('class/ConfigSingleton.php');
	$cfg = SingletonConfiguration::getInstance ();
	$user_db = $cfg->getValue('UserDB');
	$pass_db = $cfg->getValue('PassDB');
	$host_db = $cfg->getValue('HostDB');
	$name_db = $cfg->getValue('NameDB');
	$db = connetti_db($host_db, $user_db, $pass_db, $name_db);
	$sql = "SELECT * FROM esami WHERE idesame = ".$idesame.";";
	$rs = $db->query($sql);
	$row = $rs->fetch_assoc();
	$array_esame = array('dt_esame' => $row['dt_esame'], 'tipo_esame' => $row['tipo_esame'], 'dt_scadenza' => $row['dt_scadenza_iscrizioni']);
	return $array_esame;
}
function ctrl_login() {
	if (!isset($_SESSION['idLogin']) OR ($_SESSION['idLogin'] == "")) {
		//session_restart();
		//$redir="Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/../index.php";
		$redir="Location: ./access_error.php";
		header($redir);
		exit;
	}
}
function ctrl_login_poweruser() {
	if (!isset($_SESSION['idLogin']) OR ($_SESSION['idLogin'] == "") OR (($_SESSION['rule'] != "POWERUSER") AND ($_SESSION['rule'] != "ADMIN"))) {
		//session_restart();
		//$redir="Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/../index.php";
		$redir="Location: ./access_error.php";
		header($redir);
		exit;
	}
}
function ctrl_login_admin() {
	if (!isset($_SESSION['idLogin']) OR ($_SESSION['idLogin'] == "") OR ($_SESSION['rule'] != "ADMIN")) {
		//session_restart();
		//$redir="Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/../index.php";
		$redir="Location: ./access_error.php";
		header($redir);
		exit;	
	}
}
function periodo_registrazione() {
	//Configurazione da Singleton
	require_once('class/ConfigSingleton.php');
	$cfg = SingletonConfiguration::getInstance();
	if (datebetween(date("Y-m-d"),$cfg->getValue('Data_Inizio_Registrazioni'),$cfg->getValue('Data_Fine_Registrazioni'))) 
		return TRUE;
	else 	
		return FALSE;
}
function periodo_modifica() {
	//Configurazione da Singleton
	require_once('class/ConfigSingleton.php');
	$cfg = SingletonConfiguration::getInstance();
	if (datebetween(date("Y-m-d"),$cfg->getValue('Data_Inizio_Modifiche'),$cfg->getValue('Data_Fine_Modifiche'))) 
		return TRUE;
	else 	
		return FALSE;
}
function __autoload($class) {
	$SubDirectories = array("");
	$result = FALSE;
	foreach ($SubDirectories as $Dir) {
		if(file_exists(dirname(__FILE__). "/class/{$Dir}{$class}.php") && 
			require_once (dirname(__FILE__). "/class/{$Dir}{$class}.php")) {
        		$result = TRUE;
    	}
	}
	if (strstr($class, 'Singleton')) {
		$result = TRUE;
	}
	if ($result == FALSE) {
		trigger_error("MaoX : Could not load class '{$class}' from file '{$class}.php'", E_USER_WARNING);
	}
	return $result;
}
function session_restart()
{
    if (session_name()=='') {
        // Session not started yet
        session_start();
    }
    else {
        // Session was started, so destroy
        session_unset();
		session_destroy();
        // But we do want a session started for the next request
        session_start();
        session_regenerate_id();
        // PHP < 4.3.3, since it does not put
        setcookie(session_name(), session_id());
    }
}
function datediff($datefrom, $dateto)
{
	$datefrom = strtotime($datefrom);
	$dateto = strtotime($dateto);
	$difference = ($dateto - $datefrom)/( 60 * 60 * 24); // Difference in days
	return $difference;
}
function datebetween($data, $datefrom, $dateto)
{
	$data = strtotime($data);
	$datefrom = strtotime($datefrom);
	$dateto = strtotime($dateto);
	$difference1 = ($dateto - $data)/( 60 * 60 * 24); // Difference in days
	$difference2 = ($data - $datefrom)/( 60 * 60 * 24); // Difference in days
	if ($difference1 >=0 AND $difference2>= 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
function recuperaNomeComune($codice)
{
	/*
	 	* Config e chiamo DB *******************************
	 	*/
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************
		$GiaPresente=FALSE;
		$sql = "SELECT nome FROM comuni WHERE codice='".$codice."';";
		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
			{
				return $row['nome'];
			}
}
function recuperaNomeProvincia($codice)
{
	/*
	 	* Config e chiamo DB *******************************
	 	*/
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************
		$GiaPresente=FALSE;
		$sql = "SELECT nome FROM province WHERE codice='".$codice."';";
		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
			{
				return $row['nome'];
			}
}
function controllaCorreggiData($dt)
{
	list($year, $month, $day) = split('[/.-]', $dt);
	if (($month == "") OR ($month == "0")) {
		$month = "00";
	}
	if (($day == "") OR ($day == "0")) {
		$day = "00";
	}
	if (($year == "") OR ($year == "0") OR ($year == "00") OR ($year == "000")) {
		$year = "0000";
	}
	$data_corretta = $year."-".$month."-".$day;
	return $data_corretta;
}
function giraData($dt)
{
	list($year, $month, $day) = split('[/.-]', $dt);
	$data_corretta = $day."-".$month."-".$year;
	return $data_corretta;
}
function stampaData($dt)
{
	$year = substr($dt, 0, 4);
	$month = substr($dt, 4, 2);
	$day = substr($dt, 6, 2);
	$data_corretta = $day."-".$month."-".$year;
	return $data_corretta;
}
function prelevaAnnoFromDataDB($dt)
{
	$year = substr($dt, 0, 4);
	$month = substr($dt, 4, 2);
	$day = substr($dt, 6, 2);
	return $year;
}
function ctrl_modifica_possibile($ditta) {
	$data_ultima_modifica = $ditta->getDt_ultima_modifica();
	if (($ditta->getDt_ultima_modifica() == "") OR ($ditta->getDt_ultima_modifica() == "0")){
		//se ultima modifica non inserito (significa che si è iscritto prima di questa modifica
		//al codice e non ha mai fatto modifiche)
		$data_ultima_modifica = $ditta->getDt_iscrizione();
	}
	$year_ultima_modifica = prelevaAnnoFromDataDB($data_ultima_modifica);
	$year_corrente = date("Y");
	if ($year_ultima_modifica == $year_corrente) {
		echo '
			<div class="panel panel-danger">
				<div class="panel-heading">
					<p class="panel-title">Attenzione!!!</p>
				</div>
				<div class="panel-body">
					La modifica dei suoi dati non sar&agrave; possibile prima del <strong>01/01/'.(date("Y")+1).'</strong>
				</div>
			</div>
			<a href="/login02.php" class="btn btn-info">Torna al pannello</a>';
		exit(0);
	}
}
function get_client_ip() {
	$ipaddress = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *              $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
 */
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();
    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }
    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if(!$xml_values) return;//Hmm...
    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();
    $current = &$xml_array; //Refference
    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble
        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.
        $result = array();
        $attributes_data = array();
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }
        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                $current = &$current[$tag];
            } else { //There was another element with the same tag name
                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }
        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;
            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }
        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    return($xml_array);
}
/*
 * Nell'xml non sono ammessi i seguenti caratteri: & % "
 * la & la sostituisco con &amp; 
 */
function purifica_valori_xml($valore) {
	$valore = str_replace('&', '&amp;', $valore);
	$valore = str_replace('"', '&quot;', $valore);
	return $valore;	
}
function differenceInDays ($firstDate, $secondDate)
{
	$firstDateTimeStamp = $firstDate->format("U");
	$secondDateTimeStamp = $secondDate->format("U");
	$rv = round((($firstDateTimeStamp - $secondDateTimeStamp)) / 86400);
	return $rv;
}
function generateRandomString($length = 10) {
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
?>