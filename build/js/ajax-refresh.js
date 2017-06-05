( function( $ ) {

	var pageLoaded = false,
		isStarted = false;

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

	function pageReInit( scope ) {
		
		jQuery( scope + "a" ).click( function( event ) {
			
			//if its not an admin url, or doesnt contain #
			if (this.href.indexOf( goodShepherdCatholicRadio.siteUrl ) >= 0 && 
				checkIgnoreURL( this.href ) == true ) {
				
				// stop default behaviour
				event.preventDefault();

				// remove click border
				this.blur();

				// get caption: either title or name attribute
				var caption = this.title || this.name || "";

				// get rel attribute for image groups
				var group = this.rel || false;
				
				$( 'ul.menu li' ).each( function( index, menuItem ) {
					$( menuItem ).removeClass( 'current-menu-item' );
				} );
				
				$( this ).parents( 'li' ).addClass( 'current-menu-item' );

				// display the box for the elements href
				loadPage( this.href );
				
			}
			
		} );

		/*
		jQuery('.' + AAPL_search_class).each(function(index) {
			if (jQuery(this).attr("action")) {
				//Get the current action so we know where to submit to
				AAPL_searchPath = jQuery(this).attr("action");

				//bind our code to search submit, now we can load everything through ajax :)
				//jQuery('#searchform').name = 'searchform';
				jQuery(this).submit(function() {
					submitSearch(jQuery(this).serialize());
					return false;
				});
			} else {
				if (AAPL_warnings == true) {
					alert("WARNING: \nSearch form found but attribute 'action' missing!?!?! This may mean search form doesn't work with AAPL!");
				}
			}
		});

		if (jQuery('.' + AAPL_search_class).attr("action")) {} else {
			if (AAPL_warnings == true) {
				alert("WARNING: \nCould not bind to search form...\nCould not find <form> tag with class='" + AAPL_search_class + "' or action='' missing. This may mean search form doesnt work with AAPL!");
			}
		}
		*/
		
	}

	/**
	 * Load the Page via AJAX
	 * @param   {string}   url     [[Description]]
	 * @param   {[[Type]]} push    [[Description]]
	 * @param   {[[Type]]} getData [[Description]]
	 * @returns {boolean}  [[Description]]
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

			//start changing the page content.
			$( '#site-content' ).fadeOut( "slow", function() {
				//See peakaboo below - NEVER TRUST $ to sort ALL your problems - this breaks Ie7 + 8 :o
				//$('#site-content').html(AAPL_loading_code);

				//Nothing like good old pure JavaScript...
				//document.getElementById( 'site-content' ).innerHTML = AAPL_loading_code;
				// Loading Message

				$( '#site-content' ).fadeIn( "slow", function() {
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

							/*


							//TRY TO RUN DATA CODE
							try {
								AAPL_data_code(data);
							} catch(err) {
								if (AAPL_warnings == true) {
									txt="ERROR: \nThere was an error with data_code.\n";
									txt+="Error description: " + err.message;
									alert(txt);
								}
							}

							*/


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
								data = data.substring( data.indexOf( '</section>' ) + 10 ); // 6 characters in </div>

							}

							//put the resulting html back into the page!

							//See peakaboo below - NEVER TRUST $ to sort ALL your problems - this breaks Ie7 + 8 :o
							//$('#site-content').html(output);

							//Nothing like good old pure JavaScript...
							document.getElementById( 'site-content' ).innerHTML = output;

							//move content area so we cant see it.
							$( '#site-content' ).css( "position", "absolute" );
							$( '#site-content' ).css( "left", "20000px" );

							//show the content area
							$( '#site-content' ).show();

							//recall loader so that new URLS are captured.
							pageReInit( "#site-content" );
							
							/*

							if ( AAPL_reloadDocumentReady == true ) {
								$( document ).trigger( "ready" ); // Tell browser that Document is "ready" again
							}

							//TRY TO RUN RELOAD CODE
							try {
								AAPL_reload_code();
							} catch(err) {
								if (AAPL_warnings == true) {
									txt="ERROR: \nThere was an error with reload_code.\n";
									txt+="Error description: " + err.message;
									alert(txt);
								}
							}
							
							*/

							//now hide it again and put the position back!
							$( '#site-content' ).hide();
							$( '#site-content' ).css( "position", "" );
							$( '#site-content' ).css( "left", "" );

							$( '#site-content' ).fadeIn( "slow", function() {} );
							
						},
						error: function(jqXHR, textStatus, errorThrown) {
							//Would append this, but would not be good if this fired more than once!!
							pageLoaded = false;
							document.title = "Error loading requested page!";
							
							/*

							if (AAPL_warnings == true) {
								txt="ERROR: \nThere was an error with AJAX.\n";
								txt+="Error status: " + textStatus + "\n";
								txt+="Error: " + errorThrown;
								alert(txt);
							}
							
							*/

							//See peakaboo below - NEVER TRUST $ to sort ALL your problems - this breaks Ie7 + 8 :o
							//$('#site-content').html(AAPL_loading_error_code);

							//Nothing like good old pure JavaScript...
							//document.getElementById('site-content').innerHTML = AAPL_loading_error_code;
						}
					} );
				} );
			} );
		}

	}

	$( document ).ready( function() {

		// Grabs within the Header and Footer this way
		$( 'a' ).click( function( event ) {

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

				$( 'ul.menu li' ).each( function( index, menuItem ) {
					$( menuItem ).removeClass( 'current-menu-item' );
				} );
				
				$( this ).parents( 'li' ).addClass( 'current-menu-item' );

				// display the box for the elements href
				loadPage( this.href );
			}

		} );

	} );

} )( jQuery );