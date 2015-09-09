jQuery(document).ready(function($){

	var default_title = document.title;

	// Sort according to selected filter options.
	$( '.filter .items li label' ).on( 'change', 'input:checkbox', function() {

		var sort_class = new Array(),
				profiles = $( '.wsuwp-people-wrapper' ).find( '.wsuwp-person-container' );

		$( '.filter .items input:checkbox:checked' ).each( function() {
			sort_class.push( '.' + $(this).data('filter') + '-' + $(this).attr('value') );
		});

		if ( '' != sort_class ) {
			profiles.not( sort_class.join( ',' ) ).hide('fast');
			profiles.filter( sort_class.join( ',' ) ).show('fast');
		} else {
			profiles.show('fast');
		}

	});

	// Search.
	$( '.people-actions' ).on( 'keyup', '#people-search', function() {

		var	searchval = $( '#people-search' ).val(),
				profiles = $( '.wsuwp-people-wrapper' ).find( '.wsuwp-person-container' );

		if ( searchval.length > 0 ) {
			profiles.each( function() {
				var c = $(this);
				if ( c.text().toLowerCase().indexOf( searchval.toLowerCase() ) > 0 ) {
					c.show('fast');
				} else {
					c.hide('fast');
				}
			});
		} else {
			profiles.show('fast');
		}

	});

});