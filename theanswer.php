<?php 
error_reporting(5);
date_default_timezone_set('America/Chicago');
echo date('m/d/y', strtotime('first monday may 2011'));
$date = strtotime('march 31 2011');
$increment = 1;
$datestr = date('m/d/y', $date);
$monthstr = date('F', $date);
$monthint = date('m', $date);
$nextmonth = date('F', strtotime("$datestr +$increment month"));
echo "<br>".date('m/d/y', strtotime("last monday $nextmonth 2011"));
$weekdaystr = date('l', $date);
$year = date('Y', $date);

echo "weekdaystr: $weekdaystr<br>";
echo "monthstr: $monthstr<br>";
echo "year: $year";

$firstweekthismonth = date('W', strtotime("$monthstr 1 $year"));
$firstweekdaythismonth = date('l', strtotime("$monthstr 1 $year"));
$firstweekday = date('W', strtotime("first $weekdaystr $monthstr $year"));

echo "<br>$firstweeknumber";
echo '<br>'.$firstweekdaythismonth;
echo "<br>$firstweekthismonth";


if ($firstweekdaythismonth == $weekdaystr){
	$firstweekday = $firstweekthismonth;
}

$lastweekday = date('W', strtotime("last $weekdaystr $nextmonth $year"));
$eventweekday = date('W', $date);
$lastweekdaystr = date('m/d/y', strtotime("last $weekdaystr $nextmonth $year"));

echo "<br>$lastweekdaystr<br>last $weekdaystr of $monthstr 2011: ".  date('m/d/y', strtotime("last $weekdaystr april 2011"))."<br>";
echo "the date of the event is: ". date('l, F d',$date)."<br>";
echo "<br>we need to know that the first ".date('l', $date)." of ".date('F', $date)." is in week ".$firstweekday."<br>";
echo "we need to know that the ".date('l', $date)." of our event is in week ".

$eventweekday."<br>";

if ($eventweekday != $lastweekday)
	$diff = ($eventweekday - $firstweekday);

echo "let's say that we can also tell the last weekday of the month: $lastweekday<br><br>";
echo "we can then say that if $eventweekday == $lastweekday, interperet it as 'last' weekday<br><br>";
echo "we therefore know that we are looking at $weekdaystr number ".($diff+1)."<br>";

if ($eventweekday == $lastweekday){
	$ordinal = 'last';
	echo "mothstr: $monthstr";
}
if ($diff == 0) $ordinal = 'first';
if ($diff == 1) $ordinal = 'second';
if ($diff == 2) $ordinal = 'third';
if ($diff == 3) $ordinal = 'fourth';
if ($diff == 4){
	$ordinal = 'first';
} 

echo "so after a contitional that stipulates diff=$diff, we can say
that $weekdaystr number $diff, plus $increment month or: ".
"$ordinal $weekdaystr of $monthstr $year +$increment month ==<br><br>".
date('m/d/y', strtotime("$ordinal $weekdaystr $monthstr $year +$increment months"));
?>