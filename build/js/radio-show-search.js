( function( $ ) {
	
	$( document ).ready( function() {
		
		if ( $( 'form.radio-shows-filter' ).length > 0 ) {
			
			var facet = $( 'form.radio-shows-filter' ).facets( {
				ajaxMethod: 'POST',
				ajaxURL: goodShepherdCatholicRadio.ajaxUrl,
				URLParams: [
					{
						name: "action",
						value: "gscr_get_radio_shows"
					},
				],
				searchCont: '.search-content',
				bindTypes: [
					{
						'selector': 'input[type="text"]',
						'bindType': 'keyup',
					}
				],
			} );
			
		}
		
	} );
	
} )( jQuery );