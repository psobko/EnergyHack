<?php

include("mheader.php");

$json = (isset($_POST['data']) && !empty($_POST['data'])) ? json_decode($_POST['data'], true) : array(); 

$cons = new Consumption($connection);

foreach($json as $key => $value) {
// 	$consumption = array(
// 			'Start' => '2013-01-01 00:00:00',
// 			'Duration' => 3600,
// 			'Cost' => 1,
// 			'Value' => 1);
	$consumption = array(
			'Start' => $json['time'],
			'Duration' => 3600,
			'Cost' => $json['cost'],
			'Value' => $json['value']);
	$cons->insertConsumption($consumption);
}

?>