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
				<td>
					<p class="<?php echo $class?>">
						<?php echo $CurrentBoxDate;?>
					</p>
					<ul class='event'>	
					<?php
					if($events[$CurrentBoxYear][$CurrentBoxMonth][$CurrentBoxDate]){
						foreach ($events[$CurrentBoxYear][$CurrentBoxMonth][$CurrentBoxDate] as $EventId => $EventTime){
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
