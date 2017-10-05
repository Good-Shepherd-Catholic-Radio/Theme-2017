// In jquery.jplayer.js within ./bower_components, ensure you search/replace 'root.jQuery' with 'jQuery'!
// I hate solutions like this, but I cannot tell what they were even trying to do there. Maybe it is a Browserify/AMD thing?

( function( $ ) {

	$( document ).ready( function() {

		var stream = {
			//title: 'ABC Jazz',
			m4a: '//ice10.securenetsystems.net/WJKNAM'
		},
		ready = false,
		played = false;
		
		$( '#gscr-radio-stream-header' ).jPlayer( {
			ready: function ( event ) {
				ready = true;
				$( this ).jPlayer( 'setMedia', stream );
			},
			play: function ( event ) {
				played = true;
				$( this ).next( '.jp-audio-stream' ).removeClass( 'jp-state-paused' );
				$( this ).next( '.jp-audio-stream' ).addClass( 'jp-state-playing' );
				$( '.radio-shows-header .stream-control' ).addClass( 'jp-state-playing' ).removeClass( 'jp-state-paused' );
			},
			pause: function() {
				$( this ).jPlayer( 'clearMedia' );
				$( this ).next( '.jp-audio-stream' ).removeClass( 'jp-state-playing' );
				$( this ).next( '.jp-audio-stream' ).addClass( 'jp-state-paused' );
				$( '.radio-shows-header .stream-control' ).addClass( 'jp-state-paused' ).removeClass( 'jp-state-playing' );
			},
			error: function( event ) {
				
				if ( ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET ) {
					// Setup the media stream again and play it.
					$( this ).jPlayer( 'setMedia', stream ).jPlayer( 'play' );
				}
				
				if ( played && event.jPlayer.error.type === $.jPlayer.error.URL ) {
					
					var ie = GSCRdetectIE();
					
					// If they're not on IE 11 or below, determine the Stream must be down
					if ( ! ie || ie >= 12 ) {
					
						var data = {
							action: 'gscr_stream_down',
						};

						$( '#gscr_stream_down' ).foundation( 'open' );

						$.ajax( {
							'type' : 'POST',
							'url' : goodShepherdCatholicRadio.ajaxUrl,
							'data' : data,
							success : function( response ) {
							},
							error : function( request, status, error ) {
							}
						} );
						
					}
					else { // If IE 11 or below, not supported
						
						$( '#gscr_stream_old' ).foundation( 'open' );
						
					}
					
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
		
		$( document ).on( 'click', '.radio-shows-header .stream-control .jp-play .play-icon', function() {

			if ( $( '.sticky-container .stream-container .jp-audio-stream' ).hasClass( 'jp-state-paused' ) ) {

				$( '#gscr-radio-stream-header' ).jPlayer( 'play' );

				$( this ).closest( '.stream-control' ).addClass( 'jp-state-playing' ).removeClass( 'jp-state-paused' );

			}
			else if ( $( '.sticky-container .stream-container .jp-audio-stream' ).hasClass( 'jp-state-playing' ) ) {

				$( '#gscr-radio-stream-header' ).jPlayer( 'pause' );

				$( this ).closest( '.stream-control' ).removeClass( 'jp-state-playing' ).addClass( 'jp-state-paused' );

			}
			else {

				$( '#gscr-radio-stream-header' ).jPlayer( 'play' );

				$( this ).closest( '.stream-control' ).removeClass( 'jp-state-paused' ).addClass( 'jp-state-playing' );

			}

		} );

	} );
	
	$( document ).on( 'ready ajaxRefresh', function() {
		
		setTimeout( function() {
		
			if ( $( '.radio-shows-header .stream-control' ).length > 0 ) {

				if ( $( '.sticky-container .stream-container .jp-audio-stream' ).hasClass( 'jp-state-paused' ) ) {

					$( '.radio-shows-header .stream-control' ).addClass( 'jp-state-paused' ).removeClass( 'jp-state-playing' );

				}
				else if ( $( '.sticky-container .stream-container .jp-audio-stream' ).hasClass( 'jp-state-playing' ) ) {

					$( '.radio-shows-header .stream-control' ).removeClass( 'jp-state-paused' ).addClass( 'jp-state-playing' );

				}

			}
			
		}, 500 );
		
	} );

} )( jQuery );