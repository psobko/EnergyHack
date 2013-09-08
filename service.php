<?php
$seasons = array(
		'winter' );
$winterpeaks = array(
		'0' => 0,
		'7' => 2,
		'11' => 1,
		'17' => 2,
		'19' => 0);
$summerpeaks = array(
		'0' => 0,
		'7' => 1,
		'11' => 2,
		'17' => 1,
		'19' => 0);

$summerday = array(
		'0' => 1,
		'1' => 2,
		'2' => 2,
		'3' => 2,
		'4' => 2,
		'5' => 2,
		'6' => 2,
		'7' => 2,
		'8' => 2,
		'9' => 2,
		'10' => 2,
		'11' => 2,
		'12' => 2,
		'13' => 2,
		'14' => 2,
		'15' => 2,
		'16' => 2,
		'17' => 2,
		'18' => 2,
		'19' => 2,
		'20' => 2,
		'21' => 2,
		'22' => 2,
		'23' => 2,
		);

$winterday = array(
		'0' => 1,
		'1' => 2,
		'2' => 2,
		'3' => 2,
		'4' => 2,
		'5' => 2,
		'6' => 2,
		'7' => 2,
		'8' => 2,
		'9' => 2,
		'10' => 2,
		'11' => 2,
		'12' => 2,
		'13' => 2,
		'14' => 2,
		'15' => 2,
		'16' => 2,
		'17' => 2,
		'18' => 2,
		'19' => 2,
		'20' => 2,
		'21' => 2,
		'22' => 2,
		'23' => 2
		);

// GOAL: POPULATE A YEAR
function getPeaks($timestamp) {
	
	$season = getSeason($timestamp);
	May 1st, Novemvember
// 	$date = new DateTime($timestamp);
	
	if 
}


// $date - A date in any English textual format. If blank 
// defaults to the current date
// $hemisphere - "northern", "southern" or "australia"
function getSeason($date="", $hemisphere="northern") {
	
	// Set $date to today if no date specified
	if ($date=="") { $date = date("Y-m-d"); }
	
	// Specify the season names
	$season_names = array('Winter', 'Spring', 'Summer', 'Fall');

	// Get year of date specified
	$date_year = date("Y", strtotime($date));

	// Declare season date ranges
	switch (strtolower($hemisphere)) {
		case "northern": {
			if (
				strtotime($date)<strtotime($date_year.'-03-21') || 
				strtotime($date)>=strtotime($date_year.'-12-21')
			) { 
				return $season_names[0]; // Must be in Winter
			}elseif (strtotime($date)>=strtotime($date_year.'-09-23')) {
				return $season_names[3]; // Must be in Fall
			}elseif (strtotime($date)>=strtotime($date_year.'-06-21')) {
				return $season_names[2]; // Must be in Summer
			}elseif (strtotime($date)>=strtotime($date_year.'-03-21')) {
				return $season_names[1]; // Must be in Spring
			}
			break;
		}
		case "southern": {
			if (
				strtotime($date)<strtotime($date_year.'-03-21') || 
				strtotime($date)>=strtotime($date_year.'-12-21')
			) { 
				return $season_names[2]; // Must be in Summer
			}elseif (strtotime($date)>=strtotime($date_year.'-09-23')) {
				return $season_names[1]; // Must be in Spring
			}elseif (strtotime($date)>=strtotime($date_year.'-06-21')) {
				return $season_names[0]; // Must be in Winter
			}elseif (strtotime($date)>=strtotime($date_year.'-03-21')) {
				return $season_names[3]; // Must be in Fall	
			}
			break;
		}
		case "australia": {
			if (
				strtotime($date)<strtotime($date_year.'-03-01') || 
				strtotime($date)>=strtotime($date_year.'-12-01')
			) { 
				return $season_names[2]; // Must be in Summer
			}elseif (strtotime($date)>=strtotime($date_year.'-09-01')) {
				return $season_names[1]; // Must be in Spring
			}elseif (strtotime($date)>=strtotime($date_year.'-06-01')) {
				return $season_names[0]; // Must be in Winter
			}elseif (strtotime($date)>=strtotime($date_year.'-03-01')) {
				return $season_names[3]; // Must be in Fall	
			}
			break;
		}
		default: //{ echo "Invalid hemisphere set"; }
	}

}
?>