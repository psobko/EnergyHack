<?php

include("mheader.php");

$date = isset($_REQUEST['date']) && !(empty($_REQUEST['date'])) ? $_REQUEST['date'] : '';

$datetime = new DateTime();
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);

$consMng = new Consumption($connection);

$hours = $consMng->getConsumptionHourly($end->format('Y-m-d'));

// 7 days before Yesterday (Dayly
$start->add(date_interval_create_from_date_string('-8 DAYS'));
$end->add(date_interval_create_from_date_string('-1 DAY'));
$fiftienSums = $consMng->getConsumptionDailyTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-16 DAYS'));
$end->add(date_interval_create_from_date_string('-1 DAY'));
$fiftienSums = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15-31 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-31 DAYS'));
$end->add(date_interval_create_from_date_string('-16 DAY'));
$thirtiesSums = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15-31 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-31 DAYS'));
$end->add(date_interval_create_from_date_string('-1 DAY'));
$pastmonth = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));


$data = array();
$data['hours'] = $hours;
$data['days'] = $days;
$data['fiftien'] = $fiftienSums;
$data['thirtien'] = $thirtiesSums;
$data['pastmonth'] = $pastmonth;

echo '<pre>';print_r($data);echo '</pre>';
// print(json_encode($data));
exit();

?>