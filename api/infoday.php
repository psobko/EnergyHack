<?php

include("mheader.php");

$date = isset($_REQUEST['date']) && !(empty($_REQUEST['date'])) ? $_REQUEST['date'] : '';

$datetime = new DateTime();
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);

$consMng = new Consumption($connection);

$hours = $consMng->getConsumptionHourly($end->format('Y-m-d'));

$start->add(date_interval_create_from_date_string('-8 DAYS'));
$end->add(date_interval_create_from_date_string('-1 DAY'));

$days = $consMng->getConsumptionDailyTotal($start->format('Y-m-d'), $end->format('Y-m-d'));
$data = array();
$data['hours'] = $hours;
$data['days'] = $days;

echo '<pre>';print_r($data);echo '</pre>';
// print(json_encode($data));
exit();

?>