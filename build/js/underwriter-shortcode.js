( function( $ ) {

	$( document ).on( 'ready', function() {

		if ( $( '.underwriters-shortcode' ).length > 0 ) {

			var $element, $children, $container, totalHeight;

			$( '.underwriters-shortcode .read-more-container a' ).click( function() {

				totalHeight = 0

				$element = $( this );
				$container = $element.closest( '.underwriter' );
				$children = $container.find( '*' );

				if ( ! $container.hasClass( 'opened' ) ) {
					
					$container.removeClass( 'closed' );

					// measure how tall inside should be by adding together heights of all inside paragraphs
					$children.each( function() {
						totalHeight += $( this ).outerHeight();
					} );

					$container.addClass( 'closed' );

					$container.data( 'max-height', $container.css( 'max-height' ) );

					$container.css( {
						// Set height to prevent instant jumpdown when max height is removed
						'height': $container.height(),
						'max-height': 9999
					} )
					.removeClass( 'closed' )
					.addClass( 'opened' )
					.animate( {
						'height': totalHeight
					} );
					
					$element.text( goodShepherdCatholicRadio.underwritersShortcode.collapse );

				}
				else {

					$container.removeClass( 'opened' )
					.addClass( 'closed' )
					.animate( {
						'height': $container.data( 'max-height' ),
						'max-height': $container.data( 'max-height' )
					} );
					
					$element.text( goodShepherdCatholicRadio.underwritersShortcode.readMore );

				}

				// prevent jump-down
				return false;

			} );

		}

	} );

} )( jQuery );