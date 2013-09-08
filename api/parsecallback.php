<?php

include("mheader.php");


$cons = new Consumption();
$consumption = array(
		'Start' => '2013-01-01 00:00:00',
		'Duration' => 3600,
		'Cost' => 1,
		'Value' => 1);
$cons->insertConsumption($consumption);
?>