( function( $ ) {

    $( document ).ready( function() {
        
        tinymce.PluginManager.add( 'gscr_accordion_shortcode_script', function( editor, url ) {
            editor.addButton( 'gscr_accordion_shortcode', {
                text: gscr_tinymce_l10n.gscr_accordion_shortcode.tinymce_title,
                icon: false,
                onclick: function() {
                    editor.windowManager.open( {
                        title: gscr_tinymce_l10n.gscr_accordion_shortcode.tinymce_title,
                        body: [
                            {
                                type: 'textbox',
                                name: 'title',
                                label: gscr_tinymce_l10n.gscr_accordion_shortcode.accordion_title.label
                            },
                            {
                                type: 'checkbox',
                                name: 'open',
                                label: gscr_tinymce_l10n.gscr_accordion_shortcode.accordion_open.label,
                            },
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent( '[gscr_accordion' + 
                                                     ( e.data.title !== undefined && e.data.title !== '' ? ' title="' + e.data.title + '"' : '' ) + 
                                                     ( e.data.open !== undefined && e.data.open !== false ? ' open="' + e.data.open + '"' : '' ) + 
                                                 ']' + "<br /><br />" + 
                                                 gscr_tinymce_l10n.gscr_accordion_shortcode.accordion_contents.label + "<br /><br />" + 
                                                 '[/gscr_accordion]' );
                        }

                    } ); // Editor

                } // onclick

            } ); // addButton

        } ); // Plugin Manager

    } ); // Document Ready

} )( jQuery );