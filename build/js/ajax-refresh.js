// Strongly based on Advanced AJAX Page Loader by deano1987
// I rewrote it slightly in order to have it work more specifically for this theme as well as solve some quirks, like the Body Class not being loaded into the new page

( function( $ ) {

	var pageLoaded = false,
		isStarted = false,
		searchAction = null;

	/**
	 * Check whether to ignore a URL from AJAX-ifying or not
	 * 
	 * @param		{string}  url URL
	 *                       
	 * @since		1.0.0
	 * @returns 	{boolean} Ignore or not
	 */
	function checkIgnoreURL( url ) {

		var ignoreURLs = [
			'#',
			'/wp-',
			'.pdf',
			'.zip',
			'.rar'
		];

		for ( var index in ignoreURLs ) {

			if (url.indexOf( ignoreURLs[index] ) >= 0 ) {
				return false;
			}

		}

		return true;

	}

	/**
	 * Reattach all click events for Links from within the Scope of your Content Container
	 * 
	 * @param 		{string} scope jQuery Scope
	 *                       
	 * @since		1.0.0
	 */
	function pageInit( scope ) {
		
		$( "a" ).click( function( event ) {
			
			// Sometimes we want the Events Calendar to do its own AJAX rather than our own
			if ( $( this ).closest( 'body' ).hasClass( 'post-type-archive-tribe_events' ) ) {
				
				if ( $( this ).parent().hasClass( 'tribe-events-nav-next' ) ||
					$( this ).parent().hasClass( 'tribe-events-nav-previous' ) ) {
					return;
				}
				
			}
			
			// if its not an admin url, or doesnt contain #
			if ( this.href.indexOf( goodShepherdCatholicRadio.siteUrl ) >= 0 && 
				checkIgnoreURL( this.href ) == true ) {

				// stop default behaviour
				event.preventDefault();

				// remove click border
				this.blur();
				
				$( 'ul.menu li' ).each( function( index, menuItem ) {
					$( menuItem ).removeClass( 'current-menu-item' );
				} );
				
				if ( $( this ).parents( 'ul' ).hasClass( 'menu' ) ) {

					$( this ).parents( 'li' ).addClass( 'current-menu-item' );
					
				}

				// get caption: either title or name attribute
				var caption = this.title || this.name || "";

				// get rel attribute for image groups
				var group = this.rel || false;
			
				loadPage( this.href );
				
			}
			
		} );

		$( scope + ' .search-form' ).each( function( index, search ) {
			
			if ( $( search ).attr( "action" ) ) {
				
				//Get the current action so we know where to submit to
				searchAction = $( search ).attr( "action" );

				//bind our code to search submit, now we can load everything through ajax :)
				$( search ).on( 'submit', function( event ) {
					
					event.preventDefault();
					
					submitSearch( $( search ).serialize() );
					
					return false;
					
				} );
			}
			
		} );
		
	}
	
	/**
	 * Submit Search Form via AJAX
	 * 
	 * @param		{object} args GET Args generated by jQuery.serialize()
	 *                       
	 * @since		1.0.0
	 */
	function submitSearch( args ) {
		
		if ( ! pageLoaded ) {
			
			loadPage( searchAction, 0, args );
			
		}
		
	}
	
	/**
	 * Load the Page via AJAX
	 * 
	 * @param		{string}  url     URL to send the Request to
	 * @param 		{boolean} push    Whether to push History State
	 * @param 		{object}  getData GET Data from URL Parameters
	 *                            
	 * @since		1.0.0
	 */
	function loadPage( url, push, getData ) {

		if ( ! pageLoaded ) {

			$( 'html, body' ).animate( {
				scrollTop: 0
			}, 1500 );

			pageLoaded = true;

			//enable onpopstate
			isStarted = true;

			//AJAX Load page and update address bar url! :)
			//get domain name...
			var nohttp = url.replace( "http://", "" ).replace( "https://", "" ),
				firstsla = nohttp.indexOf( "/" ),
				pathpos = url.indexOf( nohttp ),
				path = url.substring( pathpos + firstsla );
				
			if ( typeof getData == "undefined" ) {
				getData = "";
			}
			else {
				getData = "?" + getData;
			}

			// Ensure intial Search is appended to URL
			path = path + getData;
			
			// Remove weird garbage from pagination. Maybe it's a nonce?
			path = path.replace( /[\?|&]_=\d*/ig, '' );

			// Only do a history state if clicked on the page.
			if ( typeof push == 'undefined' || 
				push != 1 ) {
				
				//TODO: implement a method for IE
				if ( typeof window.history.pushState == "function" ) {
					var stateObj = {
						page: path,
					};
					window.history.pushState( stateObj, null, path );
				}
				
			}
			
			// Start Overlay
			setTimeout( function() {
				
				$( '#site-header, #site-content, #site-footer' ).css( 'pointer-events', 'none' );
						
				$( '#site-content' ).fadeOut( "slow", function() {
				} );

				$( '.ajax-loading' ).fadeIn( 'slow', function() {
				} );

			}, 100 );

			// Loading Message
			$.ajax( {
				type: "GET",
				url: url,
				data: getData,
				cache: false,
				dataType: "html",
				success: function( data ) {

					pageLoaded = false;

					//get title attribute
					var datax = data.split( '<title>' ),
						titlesx = data.split( '</title>' );

					if ( datax.length == 2 ||
						titlesx.length == 2 ) {

						data = data.split( '<title>' )[1];
						var titles = data.split( '</title>' )[0];

						// set the title?
						// after several months, I think this is the solution to fix &amp; issues
						$( document ).attr( 'title', ( $( "<div/>" ).html( titles ).text() ) );
					}

					var bodyClassRegex = /<body(?:.*)class="(.*)"/igm,
						bodyClass = bodyClassRegex.exec( data )[1];

					if ( typeof bodyClass != "undefined" &&
					   bodyClass.length > 0 ) {
						// Update the Body Class since it exists outside of the Site Content <div>
						$( 'body' ).removeClass().addClass( bodyClass );
					}
					
					var cdataRegex = /<script(.*)\n\/\* <!\[CDATA\[[\s\S]*?> \*\/\n<\/script>/igm,
						eventsCalendarRegex = /(?:<link|<script)(?:.*)(?:href|src)(?:.*)>/igm,
						cdata = data.match( cdataRegex ),
						eventsCalendarScripts = data.match( eventsCalendarRegex );
					
					for ( var script in cdata ) {
						
						var strippedHTML = $( 'head' ).html().toString().replace( /\n/igm, '' ),
							strippedScript = cdata[ script ].replace( /\n/igm, '' ).replace( /'/g, '"' );
						
						if ( strippedHTML.indexOf( strippedScript ) > 0 ) continue;
						
						$( 'head' ).append( cdata[ script ] );
						
					}
					
					for ( var script in eventsCalendarScripts ) {
						
						var strippedHTML = $( 'head' ).html().toString().replace( /\n/igm, '' ),
							strippedScript = eventsCalendarScripts[ script ].replace( /\n/igm, '' ).replace( /'/g, '"' ).replace( /\s\/>$/igm, '>' ).replace( /\s\s/g, ' ' );
						
						if ( strippedScript.indexOf( 'jquery.fancybox' ) > 0 ) continue;
						
						if ( strippedScript.indexOf( 'uix-shortcodes' ) > 0 ) continue;
						
						if ( strippedScript.indexOf( goodShepherdCatholicRadio.baseName ) > 0 ) continue;
						
						if ( strippedHTML.indexOf( strippedScript ) > 0 ) continue;
						
						$( 'head' ).append( eventsCalendarScripts[ script ] );
						
					}

					//GOOGLE ANALYTICS TRACKING

					if ( typeof _gaq != "undefined" ) {

						_gaq.push( [ '_trackPageview', path + getData ] );

					}

					//GET PAGE CONTENT
					data = data.split('id="site-content"')[1];
					data = data.substring( data.indexOf( '>' ) + 1 );
					var depth = 1;
					var output = '';

					while ( depth > 0 ) {

						var temp = data.split( '</section>' )[0];

						//count occurrences
						var i = 0,
							pos = temp.indexOf( "<section" );

						while ( pos != -1 ) {
							i++;
							pos = temp.indexOf( "<section", pos + 1 );
						}
						//end count

						depth = depth + i - 1;
						output = output + data.split( '</section>' )[0] + '</section>';
						data = data.substring( data.indexOf( '</section>' ) + 10 ); // 6 characters in </section>

					}

					//put the resulting html back into the page!

					//Nothing like good old pure JavaScript...
					document.getElementById( 'site-content' ).innerHTML = output;

					//move content area so we cant see it.
					$( '#site-content' ).css( "position", "absolute" );
					$( '#site-content' ).css( "left", "20000px" );

					//show the content area
					$( '#site-content' ).show();

					//recall loader so that new URLS are captured.
					pageInit( "#site-content" );

					//now hide it again and put the position back!
					$( '#site-content' ).hide();
					$( '#site-content' ).css( "position", "" );
					$( '#site-content' ).css( "left", "" );

					setTimeout( function() {
						
						$( '#site-content' ).fadeIn( "slow", function() {
						} );
						
						$( '.ajax-loading' ).fadeOut( 'slow', function() {
						} );
						
						$( '#site-header, #site-content, #site-footer' ).css( 'pointer-events', 'initial' );
						
					}, 100 );
					
					$( document ).trigger( 'ajaxRefresh' );
					

				},
				error: function(jqXHR, textStatus, errorThrown) {
					//Would append this, but would not be good if this fired more than once!!
					pageLoaded = false;
					document.title = "Error loading requested page!";
				}

			} );
			
		}

	}

	$( document ).ready( function() {

		pageInit( '#site-content' );
		
		// Push a state for the very first page load
		if ( window.history.state === null ) {
			
			// Path along with any Query Parameters
			var path = location.pathname + location.search;
			
			var stateObj = {
				page: path,
			};
			
			window.history.pushState( stateObj, null, path );
			
		}
		
		window.onpopstate = function(event) {
			
			if ( window.history.state !== null ) {

				// By the time popstate has fired, location.pathname has been changed
				loadPage( window.history.state.page, 1 );
				
			}

		};

	} );
	
	$( document ).on( 'ajaxRefresh', function() {
		
		$( 'a.fancybox-pdf, area.fancybox-pdf, li.fancybox-pdf a' ).fancybox( $.extend( 
			{}, 
			fb_opts, 
			{ 
				'type' : 'iframe',
				'width' : '90%',
				'height' : '90%',
				'padding' : 10,
				'titleShow' : false,
				'titlePosition' : 'float',
				'titleFromAlt' : true,
				'autoDimensions' : false,
				'scrolling' : 'no',
				'onStart' : function( selectedArray, selectedIndex, selectedOpts ) {
					
					console.log( selectedOpts );
					
					selectedOpts.content = '<object data="' + selectedArray[ selectedIndex ].href + '" type="application/pdf" height="100%" width="100%"><a href="' + selectedArray[ selectedIndex ].href + '" style="display:block;position:absolute;top:48%;width:100%;text-align:center">' + $( selectedArray[ selectedIndex ] ).html() + '</a></object>';
				}
			}
		) );

		$( document ).trigger( "ready" ).trigger( 'post-load' ); // Tell browser that Document is "ready" again
		
	} );

} )( jQuery );