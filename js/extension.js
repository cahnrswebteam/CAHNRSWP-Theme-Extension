/*jQuery(document).ready(function($){

	$(window).scroll( function(){
		var scr = $(window).scrollTop();
		var b_scr = scr * 0.5;
		$( ".parallax-banner-wrapper .parallax-banner" ).css( 'bottom', '-' + b_scr + 'px' );

		// Sticky header idear.
		$( '#global-header' ).toggleClass('scrolled', scr >= 250);
				
	});

});*/

(function($){

	// Set height of '.splash' div.
	$(window).on( 'load resize', function() {
		$('.splash .widget_content_block .item-inner-wrapper').height( ( $(window).height() * 0.85 ) - $('.main-header').height() );
	});

}(jQuery));