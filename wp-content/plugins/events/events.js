jQuery(document).ready(function($){
var datestamp = new Date();
//returns january as 0, december as 11, so increment it one
var monthtoday = datestamp.getMonth()+1; 

var datetoday = monthtoday+'/'+datestamp.getDate()+'/'+datestamp.getFullYear();
var hours = datestamp.getHours()+1;
if (hours < 12){
	var suffix = ' am';
}
else{
	hours = hours-12;
	var suffix = ' pm';
}
if (hours == 0){
	hours = 12;
	var suffix = ' am';
}
var timestamp = hours+':00'+suffix;
var futuretime = (hours+1)+':00'+suffix;
if ((hours+1) > 11){
var futuretime = ((hours-12)+2)+':00 pm';
}
	$('#eventoptions input[type=text]').each(function(){
		if ($(this).val()!='')
		$(this).addClass('set').css({'color':'black'});
	})

	if (!$('input.showrepeatops').is(':checked')){
		$('td.repeating').parent('tr').hide();
	}
	$('input#event_repeat_interval').css({'color':'black'})
			.blur(function(){
			if ($('select#event_repeat_on').is(':visible')){
				describeRepeats();
			}
			if ($(this).val()!='')
				$(this).addClass('set');	
	});
	if ($('select#event_repeat_unit option:selected').val()!='month')
		$('td.month').parent('tr').hide();
	else describeRepeats();			
	$('input.showrepeatops').click(function(){		
		if ($(this).is(':checked')) $('td.repeating').parent('tr').fadeIn('fast');
		else  $('td.repeating,td.month').parent('tr').fadeOut('fast');
	});
	$('select#event_repeat_unit').change(function(){
		if ($(this).children('option:selected').text() == 'month(s)'){
			$('td.month').parent('tr').fadeIn('fast');
				describeRepeats();
		}
		else $('td.month').parent('tr').fadeOut('fast');
	});
	//fill empty date/time fields with placeholders
	if (!$('input#event_date_start').hasClass('set')){ 
		$('input#event_date_start').val(datetoday).addClass('set');
	}
	if (!$('input#event_date_end').hasClass('set')){
		$('input#event_date_end').val($('input#event_date_start').val());
	}
	if(!$('input#event_time_start').hasClass('set')){
		$('input#event_time_start').val(timestamp)
	}
	if (!$('input#event_time_end').hasClass('set')){ 
		$('input#event_time_end').val(futuretime).css({'color':'#BBB'})
	}
	$('input#event_date_start')
		.focus(function(){
		if (!$(this).hasClass('set'))
				$(this).val('');
			$(this).css({'color':'black'});
		})
		.blur(function(){
			if ($(this).val()=='')
				$(this).css({'color':'#BBB'}).val(datetoday);
			else{
				$(this).addClass('set');
			$('input.focus').removeClass('focus');
			$(this).addClass('focus');	
			if ($('select#event_repeat_on').is(':visible')){
				describeRepeats();
			}
		}
	});
	$('input#event_time_start')
		.focus(function(){
			if (!$(this).hasClass('set'))
				$(this).val('');
			$(this).css({'color':'black'});		
		})
		.blur(function(){
			if ($(this).val()==''){
				$(this).css({'color':'#BBB'}).val(timestamp);
				$(this).removeClass('set');
			}
			else{
				$(this).addClass('set');
			}
	});
	$('input#event_date_end')
		.focus(function(){
			if (!$(this).hasClass('set'))
				$(this).val('');
			$(this).css({'color':'black'});
			$('input.focus').removeClass('focus');
			$(this).addClass('focus');
		})
		.blur(function(){
			if ($(this).val()==''){
				$(this).removeClass('set');
				$(this).css({'color':'#BBB'}).val($('input#event_date_start').val());
			}
			else{
				$(this).addClass('set');
			}
	});
	$('input#event_time_end')
		.focus(function(){
			if (!$(this).hasClass('set'))
				$(this).val('');
			$(this).css({'color':'black'});
		})
		.blur(function(){
			if ($(this).val()==''){
				$(this).removeClass('set');
				$(this).css({'color':'#BBB'}).val(futuretime);
			}
			else{
				$(this).addClass('set');
			}
	});
	$('input#event_location').css({'color':'black'}).addClass('set');
	function ordinalate(ordinalnum){
		if (ordinalnum < 1 || ordinalnum > 3) ordinal = 'th';
			if (ordinalnum == 1) ordinal = 'st';
			if (ordinalnum == 2) ordinal = 'nd';
			if (ordinalnum == 3) ordinal = 'rd';
			return ordinal;
	}
	function describeRepeats(){
		if ($('select#event_repeat_on option:selected').val()=='same weekday'){
			var begindate = $('input#event_date_start').val();
			var begindate = new Date(begindate); 
			var begindateweek = begindate.getWeek();
			var begindateweekday = begindate.toString("dddd");
			var begindateweekdayint = begindate.getDay();
			var firstweekday = begindate.moveToNthOccurrence(begindateweekdayint,1).getWeek();
			var lastweekday = begindate.moveToNthOccurrence(begindateweekdayint,-1).getWeek();
			var repeatint = $('input#event_repeat_interval').val();
			if (!repeatint){
					$('td#repeat_ondetails').text('').append('please enter a number of months');
					return;
				}
			if (repeatint > 1)
				var whenrepeats = 'every '+repeatint+' months';
			else var whenrepeats = 'every month';
			if (begindateweek == lastweekday) whenrepeats = whenrepeats+ ' on the last';
			else {
				var weekdiff = begindateweek - firstweekday;
				if (weekdiff == 0) whenrepeats = whenrepeats+' on the first';
				else {
					weekdiff++;
					console.log(weekdiff);
					ordinalate(weekdiff);
					whenrepeats = whenrepeats+' on the '+weekdiff+ordinal; 
				}
			}
				$('td#repeat_ondetails').text('').append(whenrepeats+' '+begindateweekday);
				$('input#repeat_on_description').val(whenrepeats+' '+begindateweekday);
		}
		else{
			var begindate = $('input#event_date_start').val();
				var begindate = begindate.replace(/[0-9]*\/([0-9]*)\/[0-9]*/, "$1");
				if (begindate > 20) var ordinalnum = begindate.slice(1);
				else var ordinalnum = begindate;
				ordinalate(ordinalnum);
				var repeatint = $('input#event_repeat_interval').val();
				if (!repeatint){
					$('td#repeat_ondetails').text('').append('please enter a number of months');
					return;
				}
				if (repeatint ==1){ repeatint=''; unit = 'month'}
				else unit = 'months';
				$('td#repeat_ondetails').text('').append('every '+repeatint+' '+unit+' on the '+begindate+ordinal);
				$('input#repeat_on_description').val('every '+repeatint+' '+unit+' on the '+begindate+ordinal);
		}	
	}
	$('select#event_repeat_on').change(function(){
		describeRepeats();
	});
	var url = '/events/';
	var offset = 0;
	loadcal(url);
	function loadcal(url){
		$('div#minical').load(url+' #calendar', function(){	
			$('td.day').click(function(){
				$('img#calload').hide();
				//format dates based on what's displaying and feed them to input
				var startmonth = parseInt($('span[class^="displaymonth-"]').attr('class').slice(13));
				var startday = $(this).children('p.num').text();
				var startyear = $('span[class^="displayyear-"]').attr('class').slice(12);
				var clickeddate = parseInt(startmonth)+'/'+startday+'/'+startyear;
				if ($('input').hasClass('focus'))
					$('input.focus').focus().val(clickeddate);
				else $('input#event_date_start, input#event_date_end').val(clickeddate);	
			});	
			var previous = $('a#previous').attr('href');
			var next = $('a#next').attr('href');
			$('a#previous, a#next').attr('href', 'javascript:;')
			$('a#previous').click(function(){
					$('img#calload').show();
					$('div#calendar table').fadeOut();
					offset--;
					loadcal(previous);
				});	
			$('a#next').click(function(){
					$('img#calload').show();
					$('div#calendar table').fadeOut();
					offset++;
					loadcal(next);
				});	
			});
		}
	$('input#publish').click(function(){
		$('table#eventoptions input[type=text]').each(function(){
			if (!$(this).hasClass('set'))
			$(this).val('');
		});
	});
		$('a#eventhelp').click(function(){
		$('div#eventhelp').slideToggle();
	});

});