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
			
			// if its not an admin url, or doesnt contain #
			if ( this.href.indexOf( goodShepherdCatholicRadio.siteUrl ) >= 0 && 
				checkIgnoreURL( this.href ) == true ) {

				// stop default behaviour
				event.preventDefault();

				// remove click border
				this.blur();

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
				pathpos = url.indexOf(nohttp),
				path = url.substring(pathpos + firstsla);

			//Only do a history state if clicked on the page.
			if ( push != 1 ) {
				//TODO: implement a method for IE
				if ( typeof window.history.pushState == "function" ) {
					var stateObj = { foo: 1000 + Math.random()*1001 };
					window.history.pushState( stateObj, "ajax page loaded...", path );
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

			//Nothing like good old pure JavaScript...
			//document.getElementById( 'site-content' ).innerHTML = AAPL_loading_code;
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

					//GOOGLE ANALYTICS TRACKING

					if ( typeof _gaq != "undefined" ) {

						if ( typeof getData == "undefined" ) {
							getData = "";
						}
						else {
							getData = "?" + getData;
						}

						_gaq.push( [ '_trackPageview', path + getData ] );

					}

					//GET PAGE CONTENT
					data = data.split('id="site-content"')[1];
					data = data.substring( data.indexOf( '>' ) + 1 );
					var depth = 1;
					var output = '';

					while ( depth > 0 ) {

						var temp = data.split('</section>')[0];

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

					$( document ).trigger( "ready" ); // Tell browser that Document is "ready" again

					$( 'ul.menu li' ).each( function( index, menuItem ) {
						$( menuItem ).removeClass( 'current-menu-item' );
					} );

					$( this ).parents( 'li' ).addClass( 'current-menu-item' );

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

	} );

} )( jQuery );