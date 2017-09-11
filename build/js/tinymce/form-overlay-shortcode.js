( function( $ ) {
    
    /**
     * Take our Localized Choices and turn them into something TinyMCE Listbox understands
     * 
     * @param       {object} choices Choices Object from our Localized JSON
     *                               
     * @since       1.0.0
     * @returns     {Array}  Array of TinyMCE Listbox Choices
     */
    function gscr_generate_tinymce_listbox( choices ) {

        var result = [];
        
        for ( var key in choices ) {
            
            result.push( {
                text: choices[key],
                value: key
            } );
            
        }
        
        return result;
        
    }

    $( document ).ready( function() {
        
        tinymce.PluginManager.add( 'gscr_form_overlay_shortcode_script', function( editor, url ) {
            editor.addButton( 'gscr_form_overlay_shortcode', {
                text: gscr_tinymce_l10n.gscr_form_overlay_shortcode.tinymce_title,
                icon: false,
                onclick: function() {
                    editor.windowManager.open( {
                        title: gscr_tinymce_l10n.gscr_form_overlay_shortcode.tinymce_title,
                        body: [
							{
								type: 'listbox',
								name: 'form_id',
								label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.form_id.label,
								values: gscr_generate_tinymce_listbox( gscr_tinymce_l10n.gscr_form_overlay_shortcode.form_id.choices ),
							},
                            {
                                type: 'textbox',
                                name: 'text',
                                label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.button_text.label,
                            },
                            {
                                type: 'listbox',
                                name: 'color',
                                label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.colors.label,
                                values: gscr_generate_tinymce_listbox( gscr_tinymce_l10n.gscr_button_shortcode.colors.choices ),
                                value: gscr_tinymce_l10n.gscr_button_shortcode.colors.default,
                            },
                            {
                                type: 'listbox',
                                name: 'size',
                                label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.size.label,
                                values: gscr_generate_tinymce_listbox( gscr_tinymce_l10n.gscr_button_shortcode.size.choices ),
                            },
                            {
                                type: 'checkbox',
                                name: 'hollow',
                                label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.hollow.label,
                            },
                            {
                                type: 'checkbox',
                                name: 'expand',
                                label: gscr_tinymce_l10n.gscr_form_overlay_shortcode.expand.label,
                            },
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent( '[gscr_form_overlay' + 
												 	 ( e.data.form_id !== undefined ? ' form_id="' + e.data.form_id + '"' : '' ) + 
                                                     ( e.data.color !== undefined ? ' color="' + e.data.color + '"' : '' ) + 
                                                     ( e.data.size !== undefined && e.data.size !== '' ? ' size="' + e.data.size + '"' : '' ) + 
                                                     ( e.data.hollow !== undefined && e.data.hollow !== false ? ' hollow="' + e.data.hollow + '"' : '' ) + 
                                                     ( e.data.expand !== undefined && e.data.expand !== false ? ' expand="' + e.data.expand + '"' : '' ) + 
                                                 ']' + 
                                                     ( e.data.text !== undefined ? e.data.text : '' ) + 
                                                 '[/gscr_form_overlay]' );
                        }

                    } ); // Editor

                } // onclick

            } ); // addButton

        } ); // Plugin Manager

    } ); // Document Ready

} )( jQuery );