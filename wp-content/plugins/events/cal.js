jQuery(document).ready(function($){
	$('a.event').click(function(){
		var offset = $("div.wrap").offset();
		var rightness = $(this).offset()
		$('div.details').hide();
		var id = $(this).attr('id');
		if (rightness.left > offset.left+700){
			$('div#'+id).addClass('detailsLeft');
			$('div#'+id).children('.bubbletop').removeClass('bubbletop').addClass('leftbubble');
		}
		$('div#'+id).show(function(){
			var elink = $('div#'+id+' h2 a').attr('href');
			$(this).children('div.eventdescription').load(elink+' .eventdetails p', function(){
				if ($(this).children('p').text() != ''){
					$(this).slideDown();
				}
			});
		});
	});
	$('div.details').click(function(){
		$(this).hide();
	})
});