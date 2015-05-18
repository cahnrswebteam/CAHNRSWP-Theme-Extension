(function($){

	// Set height of '.splash' div.
	$(window).on( 'load resize', function() {
		$( '.splash .widget_content_block .item-inner-wrapper' ).height( ( $(window).height() * 0.85 ) - $( '.main-header' ).height() );
	});

	// Header class.
	$(window).scroll( function() {
		if ( $( '.splash' ).length > 0 ) {
			var trigger = $( '.splash' ).find( '.item-inner-wrapper > :first-child' ).offset().top - 78;
		} else {
			var trigger = 200;
		}
		$( '.cahnrs-header-group' ).toggleClass( 'scrolled', $(window).scrollTop() >= trigger );	
	});

}(jQuery));