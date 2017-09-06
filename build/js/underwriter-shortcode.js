( function( $ ) {

	$( document ).on( 'ready', function() {

		if ( $( '.underwriters-shortcode' ).length > 0 ) {

			var $element, $children, $container, totalHeight;

			$( '.underwriters-shortcode .read-more-container a' ).click( function() {

				totalHeight = 0

				$element = $( this );
				$container = $element.closest( '.underwriter' );
				$children = $container.find( '*:not(".read-more-container")' );

				if ( ! $container.hasClass( 'opened' ) ) {

					// measure how tall inside should be by adding together heights of all inside paragraphs
					$children.each( function() {
						totalHeight += $( this ).outerHeight();
					} );

					$container.data( 'max-height', $container.css( 'max-height' ) );
					
					console.log( 'set max-height data to ' + $container.data( 'max-height' ) );
					
					console.log( 'opening to ' + totalHeight );

					$container.css( {
						// Set height to prevent instant jumpdown when max height is removed
						'height': $container.height(),
						'max-height': 9999
					} )
					//.removeClass( 'closed' )
					.addClass( 'opened' )
					.animate( {
						'height': totalHeight
					}, {
						duration: 300,
						easing: 'linear'
					} );

				}
				else {
					
					console.log( 'Closing to ' + $container.data( 'max-height' ) );

					$container.removeAttr( 'style' ).css( {
						// Set height to prevent instant jumpdown when max height is removed
						'height': $container.data( 'max-height' ),
					} )
					.removeClass( 'opened' )
					//.addClass( 'closed' )
					.animate( {
						'height': $container.data( 'max-height' ),
						'maxHeight': $container.data( 'max-height' )
					}, {
						duration: 1500,
						easing: 'linear'
					} );

				}

				// prevent jump-down
				return false;

			} );

		}

	} );

} )( jQuery );