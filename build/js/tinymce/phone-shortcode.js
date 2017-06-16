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
        
        tinymce.PluginManager.add( 'gscr_phone_shortcode_script', function( editor, url ) {
            editor.addButton( 'gscr_phone_shortcode', {
                text: gscr_tinymce_l10n.gscr_phone_shortcode.tinymce_title,
                icon: false,
                onclick: function() {
                    editor.windowManager.open( {
                        title: gscr_tinymce_l10n.gscr_phone_shortcode.tinymce_title,
                        body: [
                            {
                                type: 'textbox',
                                name: 'phoneNumber',
                                label: gscr_tinymce_l10n.gscr_phone_shortcode.phone_number.label
                            },
                            {
                                type: 'textbox',
                                name: 'extension',
                                label: gscr_tinymce_l10n.gscr_phone_shortcode.extension.label
                            },
                            {
                                type: 'textbox',
                                name: 'linkText',
                                label: gscr_tinymce_l10n.gscr_phone_shortcode.link_text.label,
                            },
                            {
                                type: 'checkbox',
                                name: 'phoneIcon',
                                label: gscr_tinymce_l10n.gscr_phone_shortcode.phone_icon.label,
                            },
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent( '[gscr_phone' + 
                                                     ( e.data.phoneNumber !== undefined && e.data.phoneNumber !== '' ? ' phone_number="' + e.data.phoneNumber + '"' : '' ) + 
                                                     ( e.data.extension !== undefined && e.data.extension !== '' ? ' extension="' + e.data.extension + '"' : '' ) + 
                                                     ( e.data.phoneIcon !== undefined && e.data.phoneIcon !== false ? ' phone_icon="' + e.data.phoneIcon + '"' : '' ) + 
                                                 ']' + 
                                                     ( e.data.linkText !== undefined ? e.data.linkText : '' ) + 
                                                 '[/gscr_phone]' );
                        }

                    } ); // Editor

                } // onclick

            } ); // addButton

        } ); // Plugin Manager

    } ); // Document Ready

} )( jQuery );