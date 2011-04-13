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
var futuretime = (hours+2)+':00'+suffix;
if ((hours+1) > 11){
var futuretime = ((hours-12)+2)+':00 pm';
}
	$('a#eventhelp').click(function(){
		$('div#eventhelp').slideToggle();
	});
	if (!$('input.showrepeatops').is(':checked')){
		$('td.repeating').parent('tr').hide();
	}
	if ($('select#event_repeat_unit option:selected').val()!='month')
		$('td.month').parent('tr').hide();		
	
	$('input.showrepeatops').click(function(){		
		if ($(this).is(':checked')) $('td.repeating').parent('tr').fadeIn('fast');
		else  $('td.repeating,td.month').parent('tr').fadeOut('fast');
	});
	$('select#event_repeat_unit').change(function(){
		if ($(this).children('option:selected').text() == 'month(s)')
			$('td.month').parent('tr').fadeIn('fast');
		else $('td.month').parent('tr').fadeOut('fast');
	});
	if ($('input#event_date_start').val()==''){ 
		$('input#event_date_start').val(datetoday)
	}
	$('input#event_date_start')
		.focus(function(){
			if (!$(this).css('color')=='black')
			$(this).css({'color':'black'}).val('');
		})
		.blur(function(){
			if ($(this).val()=='')
				$(this).css({'color':'#BBB'}).val(datetoday);
			else{ 
				var day = $(this).val();
				$('input#event_date_end').css({'color':'black'}).val(day);
			}
	});
	
	if($('input#event_time_start').val()==''){
		$('input#event_time_start').val(timestamp).css({'color':'#BBB'})
	}
	$('input#event_time_start')
		.focus(function(){
			$(this).css({'color':'black'});
			$('input#event_date_start').css({'color':'black'});				
		})
		.blur(function(){
			if ($(this).val()=='')
			$(this).css({'color':'#BBB'}).val(timestamp);
	});

	if ($('input#event_date_end').val()==''){
		$('input#event_date_end').val(datetoday).css({'color':'#BBB'})
	}
	$('input#event_date_end')
		.focus(function(){
			$(this).css({'color':'black'});
			$('input#event_date_start').css({'color':'black'});
		})
		.blur(function(){
			if ($(this).val()=='')
				$(this).css({'color':'#BBB'}).val($('input#event_date_start').val());
			else if(!$('input#event_date_start').css('color')=='black'){
				$('input#event_date_start').css({'color':'black'}).val(datetoday);
			}
	});
	if ($('input#event_time_end').val()==''){ 
		$('input#event_time_end').val(futuretime).css({'color':'#BBB'})
	}
	$('input#event_time_end')
		.focus(function(){
			$(this).css({'color':'black'});
		})
		.blur(function(){
			if ($(this).val()=='')
				$(this).css({'color':'#BBB'}).val(timestamp);
			else if($('input#event_time_start').css('color') != 'black')
					$('input#event_time_start').css({'color':'black'}).val(timestamp);
	});
	var url = '/events/';
	var offset = 0;
	loadcal(url);
	function loadcal(url){
		$('div#minical').load(url+' #calendar', function(){	
			$('td.day').click(function(){
				$('img#calload').hide();
				//format dates based on what's displaying and feed them to input
				var startmonth = parseInt($('span[class^="displaymonth-"]').attr('class').slice(13))+1;
				var startday = $(this).children('p.num').text();
				var startyear = $('span[class^="displayyear-"]').attr('class').slice(12);
				$('input#event_date_start, input#event_date_end').val((parseInt(startmonth)+offset)+'/'+startday+'/'+startyear);
				$('input#event_date_start').css({'color':'black'});		
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
});