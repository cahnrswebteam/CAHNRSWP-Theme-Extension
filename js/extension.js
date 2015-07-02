(function($){

	// Set height of '.splash' div.
	$(window).on( 'load resize', function() {
		$( '.splash .widget_content_block .item-inner-wrapper' ).height( ( $(window).height() * 0.85 ) - $( '.main-header' ).height() );
	});

	// Fixed header.
	$(window).scroll( function() {

		if ( $( '.splash' ).length > 0 ) {
			var trigger = $( '.splash' ).find( '.item-inner-wrapper > :first-child' ).offset().top - 78;
		} else {
			var trigger = $( '.sub-header-default').offset().top;
		}

		var cahnrs_header = $( '.cahnrs-header-group' ),
				opaque        = 'opaque';

		if ( $(window).scrollTop() >= trigger ) {
			cahnrs_header.addClass( opaque );
		} else if ( cahnrs_header.hasClass( opaque ) ) {
			cahnrs_header.removeClass( opaque );
		}

	});

}(jQuery));