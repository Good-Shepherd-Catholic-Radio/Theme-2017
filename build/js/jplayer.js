// In jquery.jplayer.js within ./bower_components, ensure you search/replace 'root.jQuery' with 'jQuery'!
// I hate solutions like this, but I cannot tell what they were even trying to do there. Maybe it is a Browserify/AMD thing?

( function( $ ) {

	$( document ).ready( function() {

		var stream = {
			//title: 'ABC Jazz',
			m4a: '//ice10.securenetsystems.net/WJKNAM'
		},
		ready = false;
		
		$( '#gscr-radio-stream-header, #gscr-radio-stream-footer' ).jPlayer( {
			ready: function ( event ) {
				ready = true;
				$( this ).jPlayer( 'setMedia', stream );
			},
			play: function ( event ) {
				$( this ).next( '.jp-audio-stream' ).removeClass( 'jp-state-paused' );
				$( this ).next( '.jp-audio-stream' ).addClass( 'jp-state-playing' );
			},
			pause: function() {
				$( this ).jPlayer( 'clearMedia' );
				$( this ).next( '.jp-audio-stream' ).removeClass( 'jp-state-playing' );
				$( this ).next( '.jp-audio-stream' ).addClass( 'jp-state-paused' );
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
			keyEnabled: false,
			volume: 1,
			noVolume: {
				ipad: false,
				iphone: false,
				ipod: false,
				android_pad: false,
				android_phone: false,
				blackberry: false,
				windows_ce: false,
				iemobile: false,
				webos: false,
				playbook: false,
			},
		} );

	} );

} )( jQuery );