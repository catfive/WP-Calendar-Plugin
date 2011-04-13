$(document).ready(function(){

function menuScootcher(){
	//calculates whether the last menu is too wide for the content "wrapper", by how much, and moves it left accordingly
	var wrapPos = $(".wrap").offset(); 
	var wrapEnd = wrapPos.left + 960;
	var menuPos = $("#schoolmenu ul.menu:last").offset();
	var menuwidth = $("#schoolmenu ul.menu:last").outerWidth(false);
	var margin = (menuPos.left + menuwidth) - wrapEnd;

	if (margin > 0){
		var margin = '-' + margin + 'px';
		$("#schoolmenu ul.menu:last").css({'margin-left' : margin, 'white-space' : 'nowrap', 'overflow' : 'hidden'});
	}
}

menuScootcher();

//the menus have to start out displayed with visibility:hidden so their widths can be calculated, this sets them to display:none
$("#schoolmenu ul.school-menu div").css({'visibility' : 'visible', 'display' : 'none'});

$("a.school-menu-title").hover(

    function () {
    	$("#schoolmenu div[class^=menu-]").hide();
		$(this).siblings("div").show();
  		},
  	function () {
  	//do nothing when the cursor moves off the link
});	

$("#schoolmenu div[class^=menu-]").hover(  
	function () {
	//do nothing when the cursor hovers on the menu
    	$(this).show();
    },

    function () {
    	$(this).hide();
    });

$("input#search").quicksearch('div.entry > p', {		
		'onBefore': function () {
			$(".entry > h2").hide();
        	$("#infobox h2").show();
        	$("#infobox p").show();
    	}    
    });
    
$("input#reset").click(
	function () {
	$(".entry > h2").show();
	$(".entry > p").show();
});

//$("p a img").fancybox();
$("div[id^=attachment_] a").fancybox();
$("div[id^=gallery-] dl dt a").fancybox();

$("span").removeAttr('style');
}); 
