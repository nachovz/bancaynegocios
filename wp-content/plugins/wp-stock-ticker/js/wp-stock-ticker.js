
jQuery(function($) {
	if($('#stocks-by-interface').length > 0){
		$('#stocks-by-interface').liScroll({travelocity: 0.05});
	}
	if($('#stocks-by-shortcode').length > 0){
		$('#stocks-by-shortcode').liScroll({travelocity: 0.05});
	}
	if ($('.stocksTickerWidget').length > 0){
		$('.stocksTickerWidget').liScroll({travelocity: 0.05});
	}
})