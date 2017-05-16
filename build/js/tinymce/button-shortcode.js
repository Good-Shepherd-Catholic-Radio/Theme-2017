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
        
        tinymce.PluginManager.add( 'gscr_button_shortcode_script', function( editor, url ) {
            editor.addButton( 'gscr_button_shortcode', {
                text: gscr_tinymce_l10n.gscr_button_shortcode.tinymce_title,
                icon: false,
                onclick: function() {
                    editor.windowManager.open( {
                        title: gscr_tinymce_l10n.gscr_button_shortcode.tinymce_title,
                        body: [
                            {
                                type: 'textbox',
                                name: 'text',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.button_text.label
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.button_url.label
                            },
                            {
                                type: 'listbox',
                                name: 'color',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.colors.label,
                                values: gscr_generate_tinymce_listbox( gscr_tinymce_l10n.gscr_button_shortcode.colors.choices ),
                                value: gscr_tinymce_l10n.gscr_button_shortcode.colors.default,
                            },
                            {
                                type: 'listbox',
                                name: 'size',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.size.label,
                                values: gscr_generate_tinymce_listbox( gscr_tinymce_l10n.gscr_button_shortcode.size.choices ),
                                value: gscr_tinymce_l10n.gscr_button_shortcode.size.default,
                            },
                            {
                                type: 'checkbox',
                                name: 'hollow',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.hollow.label,
                            },
                            {
                                type: 'checkbox',
                                name: 'expand',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.expand.label,
                            },
                            {
                                type: 'checkbox',
                                name: 'newTab',
                                label: gscr_tinymce_l10n.gscr_button_shortcode.new_tab.label,
                            },
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent( '[gscr_button' + 
                                                     ( e.data.url !== undefined && e.data.url !== '' ? ' url="' + e.data.url + '"' : '' ) + 
                                                     ( e.data.color !== undefined ? ' color="' + e.data.color + '"' : '' ) + 
                                                     ( e.data.size !== undefined ? ' size="' + e.data.size + '"' : '' ) + 
                                                     ( e.data.hollow !== undefined && e.data.hollow !== false ? ' hollow="' + e.data.hollow + '"' : '' ) + 
                                                     ( e.data.expand !== undefined && e.data.expand !== false ? ' expand="' + e.data.expand + '"' : '' ) + 
                                                     ( e.data.newTab !== undefined && e.data.newTab !== false ? ' new_tab="' + e.data.newTab + '"' : '' ) + 
                                                 ']' + 
                                                     ( e.data.text !== undefined ? e.data.text : '' ) + 
                                                 '[/gscr_button]' );
                        }

                    } ); // Editor

                } // onclick

            } ); // addButton

        } ); // Plugin Manager

    } ); // Document Ready

} )( jQuery );