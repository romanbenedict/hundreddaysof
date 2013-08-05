$(document).ready(function() {



	//On mouse over those thumbnail
	$('.imagewrapper').hover(function() {
		
		
		//Display the caption
		$(this).find('div.overlayinfo').stop(false,true).fadeIn(200);
	},
	function() {	

		//Hide the caption
		$(this).find('div.overlayinfo').stop(false,true).fadeOut(200);
	});

});