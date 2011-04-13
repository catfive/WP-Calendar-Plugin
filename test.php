<style>
table{
width: 700px
}
td{
border: 1px solid black;
height: 70px; 
vertical-align: top;
}
</style>
<?php
$post =   '499';
date_default_timezone_set('America/Chicago'); 
$events = array(
	499 => '123456789'
);
$recurringEvents = array(
	501 => '122345678'
);

$allEvents = array_merge($events, $recurringEvents);
class Events{
	public $theday = 1;
	
	function __construct($theday){
		$this->theday = $theday;
	function have_days(){

	}
}
echo $theday;
print_r($events+$recurringEvents);
$firstweekday = date("w", mktime(0, 0, 0, 3, 1, 2011));
$lastweekday = date('w', mktime(0, 0, 0, 4, 0, 2011));
$day = mktime(0,0,0,3,1-$firstweekday,2011);
$lastday = mktime(0, 0, 0, 4, 7-$lastweekday,2011);
echo "<table><tr>";
while ($day < $lastday):?>

<td>
	<?php
	$date = date('j', $day);
	echo $date;
	?>
</td>
	<?php 
	$mdy = date ('m/d/y', $day);
	$day = strtotime("$mdy + 1 day");
	if (date('w', $day)==0) echo '</tr><tr>';
endwhile;
?>