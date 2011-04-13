<?php
$day = 0;
$events = array(1,2,3,4,5,6);

function the_day(){
	global $day;
	$day++;
	return $day;
}

function have_days(){
	global $day;
	$endday = 5;
	if($day <= $endday){
	return true;
	}
}
function have_events(){
	global $events;
	global $day;
	
	if ($events[$day]){
		return $events[$day];
	}
}
while(have_days()){
	echo the_day();
	if (have_events()){
		echo $events[$day];
	}
}
?>