!function(o){function e(o){var e=[];for(var t in o)e.push({text:o[t],value:t});return e}o(document).ready(function(){tinymce.PluginManager.add("gscr_form_overlay_shortcode_script",function(o,t){o.addButton("gscr_form_overlay_shortcode",{text:gscr_tinymce_l10n.gscr_form_overlay_shortcode.tinymce_title,icon:!1,onclick:function(){o.windowManager.open({title:gscr_tinymce_l10n.gscr_form_overlay_shortcode.tinymce_title,body:[{type:"listbox",name:"form_id",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.form_id.label,values:e(gscr_tinymce_l10n.gscr_form_overlay_shortcode.form_id.choices)},{type:"textbox",name:"text",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.button_text.label},{type:"listbox",name:"color",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.colors.label,values:e(gscr_tinymce_l10n.gscr_button_shortcode.colors.choices),value:gscr_tinymce_l10n.gscr_button_shortcode.colors["default"]},{type:"listbox",name:"size",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.size.label,values:e(gscr_tinymce_l10n.gscr_button_shortcode.size.choices)},{type:"checkbox",name:"hollow",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.hollow.label},{type:"checkbox",name:"expand",label:gscr_tinymce_l10n.gscr_form_overlay_shortcode.expand.label}],onsubmit:function(e){o.insertContent("[gscr_form_overlay"+(void 0!==e.data.form_id?' form_id="'+e.data.form_id+'"':"")+(void 0!==e.data.color?' color="'+e.data.color+'"':"")+(void 0!==e.data.size&&""!==e.data.size?' size="'+e.data.size+'"':"")+(void 0!==e.data.hollow&&e.data.hollow!==!1?' hollow="'+e.data.hollow+'"':"")+(void 0!==e.data.expand&&e.data.expand!==!1?' expand="'+e.data.expand+'"':"")+"]"+(void 0!==e.data.text?e.data.text:"")+"[/gscr_form_overlay]")}})}})})})}(jQuery);