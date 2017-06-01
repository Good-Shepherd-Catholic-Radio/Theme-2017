// In jquery.jplayer.js within node_modules, ensure you search/replace 'root.jQuery' with 'jQuery'!
// I hate solutions like this, but I cannot tell what they were even trying to do there. Maybe it is a Browserify/AMD thing?

( function( $ ) {

	$( document ).ready( function() {

		var stream = {
			//title: 'ABC Jazz',
			m4a: '//ice10.securenetsystems.net/WJKNAM'
		},
		ready = false;
		
		$( '#jquery_jplayer_1' ).jPlayer( {
			ready: function ( event ) {
				ready = true;
				$( this ).jPlayer( 'setMedia', stream ).jPlayer( 'play' );
			},
			pause: function() {
				$( this ).jPlayer( 'clearMedia' );
			},
			error: function( event ) {
				if( ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET ) {
					// Setup the media stream again and play it.
					$( this ).jPlayer( 'setMedia', stream ).jPlayer( 'play' );
				}
			},
			swfPath: './',
			supplied: 'M4A',
			preload: 'none',
			wmode: 'window',
			useStateClassSkin: true,
			autoBlur: false,
			keyEnabled: true
		} );

	} );

} )( jQuery );