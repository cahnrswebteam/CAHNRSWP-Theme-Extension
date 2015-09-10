(function($){

	// Set height of '.splash' div.
	$(window).on( 'load resize', function() {
		$( '.splash' ).height( ( $(window).height() * 0.82 ) - $( '.main-header' ).height() );
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
	$(function() {
		$('.cahnrs-accordion > dd').hide();
		$('.cahnrs-accordion').on( 'click', 'dt', function() {
			$(this).next('dd').toggle().parents('dl').toggleClass('disclosed');
		})
	});

}(jQuery));