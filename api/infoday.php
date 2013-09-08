<?php

include("mheader.php");

$date = isset($_REQUEST['date']) && !(empty($_REQUEST['date'])) ? $_REQUEST['date'] : '';

$datetime = new DateTime();

$consMng = new Consumption($connection);

$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-1 DAY'));
$end->add(date_interval_create_from_date_string('-1 DAY'));
$hours = $consMng->getConsumptionHourly($end->format('Y-m-d'));

$twohours = array();
$cost = 0; $value = 0; 
$maximums = array('Cost' => 0, 'Value' => 0);
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
	if($item['Cost'] > $maximums['Cost'])
		$maximums['Cost'] = $item['Cost'];
	if($item['Value'] > $maximums['Value'])
		$maximums['Value'] = $item['Value'];
}

// 7 days before Yesterday (Dayly
$start->add(date_interval_create_from_date_string('-9 DAYS'));
$end->add(date_interval_create_from_date_string('-2 DAY'));
$days = $consMng->getConsumptionDailyTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-17 DAYS'));
$end->add(date_interval_create_from_date_string('-2 DAY'));
$fiftienSums = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15-31 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-32 DAYS'));
$end->add(date_interval_create_from_date_string('-17 DAY'));
$thirtiesSums = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));

// 15-31 days before yesterday
$start = $datetime->createFromFormat('Y-m-d', $date);
$end = $datetime->createFromFormat('Y-m-d', $date);
$start->add(date_interval_create_from_date_string('-32 DAYS'));
$end->add(date_interval_create_from_date_string('-2 DAY'));
$pastmonth = $consMng->getConsumptionTotal($start->format('Y-m-d'), $end->format('Y-m-d'));


$data = array();
$data['hours'] = $hours;
$data['hoursmax'] = $maximums;
$data['twohours'] = $twohours;
$data['days'] = $days;
$data['fiftien'] = $fiftienSums;
$data['thirtien'] = $thirtiesSums;
$data['pastmonth'] = $pastmonth;

// echo '<pre>';print_r($data);echo '</pre>';
print(json_encode($data));
exit();

?>