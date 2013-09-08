<?php

date_default_timezone_set('America/Toronto');

require_once('config.php');

function __autoload($class_name) {
	$fname = strtolower($class_name);
// 	error_log(SYSTEMPATH . "includes/$fname.inc.php");
	if(file_exists(SYSTEMPATH . "includes/$fname.inc.php")) {
		require_once (SYSTEMPATH . "includes/$fname.inc.php");
	} elseif(file_exists(SYSTEMPATH . "libs/" . str_replace('\\', '/', $class_name) . ".php")) {
		require_once(SYSTEMPATH . "libs/" . str_replace('\\', '/', $class_name) . ".php");
	}
}

$db = new Db();
$connection = $db->connect();

if($connection === false) {
	print(json_encode(array("error" => "There was a connection problem. Try again."/*$db->getError()*/)));
	error_log($db->getError());
	die();
}

?>