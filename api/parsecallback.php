<?php

include("mheader.php");

// $json = (isset($_REQUEST['data']) && !empty($_REQUEST['data'])) ? json_decode($_REQUEST['data'], true) : array(); 
// error_log(serialize($json));
// echo serialize($json);

// $cons = new Consumption($connection);

// foreach($json as $key => $value) {
// // 	$consumption = array(
// // 			'Start' => '2013-01-01 00:00:00',
// // 			'Duration' => 3600,
// // 			'Cost' => 1,
// // 			'Value' => 1);
// 	$consumption = array(
// 			'Start' => $json['time'],
// 			'Duration' => 3600,
// 			'Cost' => $json['cost'],
// 			'Value' => $json['value']);
// 	$cons->insertConsumption($consumption);
// }

$cost = (isset($_REQUEST['cost']) && !empty($_REQUEST['cost'])) ? $_REQUEST['cost'] : 0;
$value = (isset($_REQUEST['value']) && !empty($_REQUEST['value'])) ? $_REQUEST['value'] : 0;
$start = (isset($_REQUEST['time']) && !empty($_REQUEST['time'])) ? new DateTime($_REQUEST['time']) : new DateTime();

$cons = new Consumption($connection);

// 	$consumption = array(
// 			'Start' => '2013-01-01 00:00:00',
// 			'Duration' => 3600,
// 			'Cost' => 1,
// 			'Value' => 1);
$consumption = array(
		'Start' => $start->format('Y-m-d H:i:s'),
		'Duration' => 3600,
		'Cost' => $cost,
		'Value' => $value);
if(!$cons->insertConsumption($consumption))
	error_log("Insert Fail");


?>