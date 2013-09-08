<?php

include("mheader.php");

$date = isset($_REQUEST['date']) && !(empty($_REQUEST['date'])) ? $_REQUEST['date'] : '';

$datetime = new DateTime();
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);

$consMng = new Consumption($connection);

$hours = $consMng->getConsumptionHourly($end->format('Y-m-d'));

$twohours = array();
$cost = 0; $value = 0;
foreach($hours as $key => $item) {
	if($key % 2 == 0) {
		$cost = $item['Cost'];
		$value = $item['Value'];
	} else {
		$cost += $item['Cost'];
		$value += $item['Value'];
		$twohours[] = array(
				'Start' => $item['Start'],
				'Duration' => 7200,
				'Cost' => $cost,
				'Value' => $value);
		$cost = 0; $value = 0;
	}	
}

// 7 days before Yesterday (Dayly
$start->add(date_interval_create_from_date_string('-8 DAYS'));
$end->add(date_interval_create_from_date_string('-1 DAY'));
$days = $consMng->getConsumptionDailyTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

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
$data['twohours'] = $twohours;
$data['days'] = $days;
$data['fiftien'] = $fiftienSums;
$data['thirtien'] = $thirtiesSums;
$data['pastmonth'] = $pastmonth;

// echo '<pre>';print_r($data);echo '</pre>';
print(json_encode($data));
exit();

?>