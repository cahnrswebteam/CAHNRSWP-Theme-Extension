(function($){

	// '.splash' div height.
	$(window).on( 'load resize', function() {
		//$( '.splash' ).height( ( $(window).height() * 0.82 ) - $( '.main-header' ).height() );
		var height_adjust;
		if ( $( '.important' ).length > 0 ) {
			height_adjust = ( $(window).height() * 0.82 ) - $( '.main-header' ).height() - $( '.important' ).outerHeight(true);
		} else {
			height_adjust = ( $(window).height() * 0.82 ) - $( '.main-header' ).height();
		}
		$( '.splash' ).height( height_adjust );
	});

	// Fixed header.
	$(window).scroll( function() {

		if ( $( '.splash' ).length > 0 ) {
			var trigger = $( '.splash .column > :first-child' ).offset().top - 78;
		} else {
			if ( $( '.sub-header' ).css('display') != 'none' ) {
				var trigger = $( '.sub-header-default' ).offset().top;
			} else {
				var trigger = $( '.main-header' ).height();
			}
		}

		var cahnrs_header = $( '.cahnrs-header-group' ),
				opaque        = 'opaque';

		if ( $(window).scrollTop() >= trigger ) {
			cahnrs_header.addClass( opaque );
		} else if ( cahnrs_header.hasClass( opaque ) ) {
			cahnrs_header.removeClass( opaque );
		}

	});

	// Accordion.
	$(document).ready( function() {
		$( '.cahnrs-accordion > dd' ).hide();
		$( 'main' ).on( 'click', '.cahnrs-accordion dt', function() {
			if ( $(this).parent( 'dl' ).hasClass( 'slide' ) ) {
				$(this).next( 'dd' ).slideToggle( 'slow' ).parents( 'dl' ).toggleClass( 'disclosed' );
			} else {
				$(this).next( 'dd' ).toggle().parents( 'dl' ).toggleClass( 'disclosed' );
			}
		})
	});

}(jQuery));