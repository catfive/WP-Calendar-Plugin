<?php 
/
error_reporting(5);
date_default_timezone_set('America/Chicago');

$date = strtotime('march 30 2011');

echo "the date of the event is: ". date('l, F d',$date)."<br>";
echo "we are going to increment it by one month, and keep it on the same weekday<br>";
$increment = 2;
$datestr = date('m/d/y', $date);
$monthstr = date('F', $date);
$weekdaystr = date('l', $date);
$year = date('y', $date);
$firstweekday = date('W', strtotime("first $weekdaystr $monthstr $year"));
$lastweekday = date('W', strtotime("last $weekdaystr $monthstr $year"));
$eventweekday = date('W', $date);


echo "<br>we need to know that the first ".date('l', $date)." of ".date('F', $date)." is in week ".
$firstweekday."<br>";

echo "we need to know that the ".date('l', $date)." of our event is in week ".
$eventweekday."<br>";

if ($eventweekday != $lastweekday)
	$diff = ($eventweekday - $firstweekday);
echo "let's say that we can also tell the last weekday of the month: $lastweekday<br><br>";

echo "we can then say that if $eventweekday == $lastweekday, interperet it as 'last' weekday<br><br>";
echo "we therefore know that we are looking at $weekdaystr number ".($diff+1)."<br>";

if ($eventweekday == $lastweekday) $ordinal = 'last';
if ($diff == 0) $ordinal = 'first';
if ($diff == 1) $ordinal = 'second';
if ($diff == 2) $ordinal = 'third';
if ($diff == 3) $ordinal = 'fourth';
if ($diff == 4) $ordinal = 'last';

echo "so after a contitional that stipulates diff=$diff, we can say
that $weekdaystr number $diff, plus $increment month equals: ".
"$ordinal $weekdaystr of $monthstr $year +$increment month".
date('m/d/y', strtotime("$ordinal $weekdaystr $monthstr $year +$increment month"));

?>