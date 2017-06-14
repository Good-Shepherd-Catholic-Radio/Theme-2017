( function( $ ) {
    
    $( document ).ready( function() {

        $( document ).foundation();  

    } );
	
	$( document ).on( 'ajaxRefresh', function() {
		
		// setTimeout ensures these occur at the same time
		// JavaScript likes to be dumb and not do things in order sometimes
		setTimeout( function() {
		
			$( '*[data-equalizer-watch]' ).each( function( index, item ) {

				// Force reflow
				// https://gist.github.com/paulirish/5d52fb081b3570c81e3a
				$( item )[0].clientHeight;

			} );

			$( document ).foundation();
			
		}, 500 );
		
	} );
    
} )( jQuery );