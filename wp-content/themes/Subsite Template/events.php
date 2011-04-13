<?php /* Template Name: Events */ ?>

<?php get_header(); ?>
	<div id="words">
				
<a name="cal"></a>
<div style="width:100%; padding-bottom: 30px;">
<div id="calwrap">

<?php

/*
$calendars = get_terms('calendars');

foreach ($calendars as $calendar){
	echo "<li>$calendar->name</li>";
}
*/

//
if ($CurrentYearInt = get_query_var('calendaryear'));
else $CurrentYearInt = date('Y');
if ($CurrentMonthInt = get_query_var('calendarmonth'));
else $CurrentMonthInt = date('n');
$CurrentMonthBeginTime = mktime(0, 0, 0, $CurrentMonthInt , 1, $CurrentYearInt);
$CurrentMonthEndTime = mktime(0, 0, 0, $CurrentMonthInt + 1, 0, $CurrentYearInt);
$PreviousMonthInt = $CurrentMonthInt-1;
$PreviousYearInt = $CurrentYearInt;
$NextMonthInt = $CurrentMonthInt+1;
$NextYearInt = $CurrentYearInt;

if ($CurrentMonthInt == 1){
	$PreviousMonthInt = 12;
	$PreviousYearInt = $CurrentYearInt-1;
}

if ($CurrentMonthInt == 12){
	$NextMonthInt = 1;
	$NextYearInt = $CurrentYearInt+1;
}

$QueryArguments = array(
	'post_type' => 'events',
	'meta_key' => 'event_repeats', //this will have to be changed in 3.1
	'meta_value' => 'on'
	);

$RecurringEvents = new WP_Query($QueryArguments);
while ( $RecurringEvents->have_posts() ) : $RecurringEvents->the_post();
	$RecurringEventStartTime = get_post_meta($post->ID, 'event_date_start', true);
	$RecurringEventStartDayInt = date('j', $RecurringEventStartTime);
	$RecurringEventRepeatInterval = get_post_meta($post->ID, 'event_repeat_interval', true);
	$RecurringEventRepeatUnit = get_post_meta($post->ID, 'event_repeat_unit', true);
	if ($RecurringEventRepeatOn = get_post_meta($post->ID, 'event_repeat_on', true));
	if ($RecurringEventEndTime = get_post_meta($post->ID, 'event_date_end', true)){
		$RecurringEventEndDayInt = date('j', $RecurringEventEndTime); 
		$EventLength = $RecurringEventEndDayInt-$RecurringEventStartDayInt;
	}
	else unset($EventLength);
	while ($RecurringEventStartTime <= $CurrentMonthEndTime){
		$RecurringEventDateString = date('n/j/y', $RecurringEventStartTime);
		if ($RecurringEventRepeatOn == 'same weekday'){
			$monthstr = date('F', $RecurringEventStartTime);
			
			$weekdaystr = date('l', $RecurringEventStartTime);
			$year = date('Y', $RecurringEventStartTime);
			$firstweekday = date('W', strtotime("first $weekdaystr of $monthstr $year"));
			$lastweekday = date('W', strtotime("last $weekdaystr of $monthstr $year"));
			$eventweekday = date('W', $RecurringEventStartTime);
			if ($eventweekday != $lastweekday)
			$diff = ($eventweekday - $firstweekday);
			if ($eventweekday == $lastweekday) $ordinal = 'last';
			if ($diff == 0) $ordinal = 'first';
			if ($diff == 1) $ordinal = 'second';
			if ($diff == 2) $ordinal = 'third';
			if ($diff == 3) $ordinal = 'fourth';
			if ($diff == 4) $ordinal = 'last';
			$RecurringEventStartTime = strtotime("$ordinal $weekdaystr of $monthstr $year +$RecurringEventRepeatInterval month");
		}
		else{
			$RecurringEventStartTime = strtotime("$RecurringEventDateString + $RecurringEventRepeatInterval $RecurringEventRepeatUnit");
		}
		if ($RecurringEventStartTime >= $CurrentMonthBeginTime && $RecurringEventStartTime <= $CurrentMonthEndTime){
			$events[date('Y', $RecurringEventStartTime)]
					[date('n', $RecurringEventStartTime)]
						[date('j', $RecurringEventStartTime)]
							[$post->ID] = $RecurringEventStartTime;
			if ($EventLength > 0){
				$DayCount = 1;
				while ($DayCount <= $EventLength){
					$events[date('Y', $RecurringEventStartTime)]
					[date('n', $RecurringEventStartTime)]
						[(date('j', $RecurringEventStartTime)+$DayCount)]
							[$post->ID] = $RecurringEventStartTime;	
					$DayCount++;
				}
			}
		}		
	}
endwhile;
wp_reset_query();
query_posts(
	array(
		'post_type' => 'events', 
		'meta_key' => 'event_date_start',
		'meta_value' => $CurrentBoxMonthtail, 
		'meta_compare' => '>='
	)
);
while ( have_posts() ): the_post();
	$EventStartTime = get_post_meta($post->ID, 'event_date_start', true);
	$EventStartDayInt = date('j', $EventStartTime);
	if ($EventEndTime = get_post_meta($post->ID, 'event_date_end', true))
		$EventEndDayInt = date('j', $EventEndTime);
	else $EventEndDayInt =$EventStartDayInt;
	if ($EventEndDayInt > $EventStartDayInt){		
		while ($EventStartDayInt <= $EventEndDayInt){
			$events[date('Y', $EventStartTime)]
				[date('n', $EventStartTime)]
					[$EventStartDayInt]
						[$post->ID] = $EventStartTime;
			$EventStartDayInt++;
		}
	}
	else{
		$events[ date('Y', $EventStartTime) ]
			[date('n', $EventStartTime)]
				[date('j', $EventStartTime)]
					[$post->ID] = $EventStartTime;
	}
endwhile;
wp_reset_query();
function get_events($post, $day){
	$EventStartTime = get_post_meta($post, 'event_date_start', true);
	$EventTimeStartStr = get_post_meta($post, 'event_time_start', true);
	$EventEndTime = get_post_meta($post, 'event_date_end', true);
	$EventTimeEndStr = get_post_meta($post, 'event_time_end', true);
	$EventLocation = get_post_meta($post, 'event_location', true);
	?>
	<li class="<?php echo $class?>">
		<a id="event-<?php echo $post.$day?>" class="event" href="javascript:;">
			<?php echo get_the_title($post);?>
		</a>
	</li>									
	<div id="event-<?php echo $post.$day?>" class="details">
	<div class="bubbletop">
		<h2><a href="<?php echo get_permalink($post)?>"><?php echo get_the_title($post) ?></a></h2>
	</div>
	<div class="timeplace">
		<p><?php 
		if (get_post_meta($post, 'event_repeats', true)){
			echo get_post_meta($post,'event_repeat_on_description', true);
		}
		else {
		if ($EventEndTime):?>
		<strong>from: </strong>
		<?php	
		endif;
		echo date('l, F j', $EventStartTime);
		}
		if ($EventTimeStartStr) echo " at " . date ('g:i a', $EventStartTime);
		if ($EventEndTime):
		?></p>
		<p><strong>to:</strong>
		<?php
		echo date('l, F j', $EventEndTime);
		if ($EventTimeEndStr) echo " at " . date('g:i a', $EventTimeEndStr);
		endif;
		if ($EventLocation):?></p>
		<p><strong>location:</strong>
		<?php
		echo $EventLocation;	
		endif;
		?>
		</p>
		
	</div>
		<div class="eventdescription"></div>	
		<div class="bubblebottom"></div>
	</div>
<?php
}
wp_reset_query();
?>
<div id="calendar">
	<div style='float:right'>
		<img id="calload" src="/wp-admin/images/wpspin_light.gif">
		<a class='button' id="previous" 
			href='/events/<?php echo "$PreviousYearInt/$PreviousMonthInt"?> '>
			&laquo; Previous
		</a>
		<a class='button' id="next" href='/events/<?php echo "$NextYearInt/$NextMonthInt"?>'>Next &raquo;</a>
	</div>
	<h1>
		<span class="displaymonth-<?php echo date("n", $CurrentMonthBeginTime)?>">
		<?php echo date("F", $CurrentMonthBeginTime)?></span>
		<span class="displayyear-<?php echo date("Y", $CurrentMonthBeginTime)?>">
		<?php echo date("Y", $CurrentMonthBeginTime)?></span>
	</h1>
	<table style='width:100%' cellspacing=0>
		<tr class='days'>
			<th>Sunday</th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
			<th>Saturday</th>
		</tr>
		<tr>
			<?php
if ($CurrentMonthInt = get_query_var('calendarmonth'));
			else $CurrentMonthInt = date('n');
			$CurrentMonthLastDayInt = date("d", $CurrentMonthEndTime);
			$FirstWeekDayInt = date("w", mktime(0, 0, 0, $CurrentMonthInt, 1, $CurrentYearInt));
			$LastWeekDayInt = date("w", mktime(0, 0, 0, $CurrentMonthInt + 1, 0, $CurrentYearInt));
			
			if ($FirstWeekDayInt>0){
				$DayCounter = 1-($FirstWeekDayInt);
			}
			else $DayCounter = 1;
			if (date('w', $CurrentMonthLastDayInt) < 6){
				$LastCalendarBoxInt = $CurrentMonthLastDayInt+(6-$LastWeekDayInt);
			}
			else $LastCalendarBoxInt = $CurrentMonthLastDayInt;
			$BoxCounter = 0;
			while($DayCounter <= $LastCalendarBoxInt):
				$CurrentBoxTime = mktime(0, 0, 0, $CurrentMonthInt, $DayCounter, $CurrentYearInt);
				$CurrentBoxYear = date('Y', $CurrentBoxTime);
				$CurrentBoxMonth = date('n', $CurrentBoxTime);
				$CurrentBoxDate = date('j', $CurrentBoxTime);
				if ($CurrentBoxMonth != $CurrentMonthInt) $class = 'fade';
				else unset($class);
				?>
				<td class="day">
					<p class="num<?php echo ' '.$class;?>"><?php echo $CurrentBoxDate;?></p>
					<ul class='event'>	
					<?php
					if($events[$CurrentBoxYear][$CurrentBoxMonth][$CurrentBoxDate]){
						foreach ($events[$CurrentBoxYear][$CurrentBoxMonth][$CurrentBoxDate] 
						as $EventId => $EventTime){
							$EventsToday[$EventId] = $EventTime;
						} 
						asort($EventsToday);
						foreach ($EventsToday as $EventId => $EventTime){
							get_events($EventId, $CurrentBoxDate);
						}
						unset($EventsToday);
					};													
					?>		
					</ul>
				</td>
				<?php 
				$DayCounter++;
				$BoxCounter++;
				if ($BoxCounter % 7 == 0)echo "</tr><tr>";
			endwhile;
			?>
	</table>
	</div>
</div>
<br class="clear"/>
</div>
	<br class="clear"/>
	</div>
<?php get_footer(); ?>