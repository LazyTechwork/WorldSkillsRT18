var predefined_busy = false;

jQuery(document).ready(function() {

    document.addEventListener('formSaved', function() {
        if (!predefined_busy) {
            // TODO event handler logic
            var formData = formBuilder.formData;
            console.log(formData);



            var escapeEl = document.createElement('textarea'),
              code = document.getElementById('markup'),
              escapeHTML = function(html) {
                escapeEl.textContent = html;
                return escapeEl.innerHTML;
              },
              addLineBreaks = function(html) {
                return html.replace(new RegExp('&gt; &lt;', 'g'), '&gt;\n&lt;').replace(new RegExp('&gt;&lt;', 'g'), '&gt;\n&lt;');
              };

            var formRenderOpts = {
              render: false,
              formData: formData
            };

            // Grab markup and escape it
            var markup = escapeHTML(new FormRenderFn(formRenderOpts).markup);


            var decoded = jQuery("<div/>").html(addLineBreaks(markup)).text();


            jQuery("#fb-temp-formdata").val(formData);
            jQuery("#fb-temp-htmldata").val(decoded);
        }
    });

    var can_continue = false;


    
    jQuery("body").on("change","#wpcf_nd_predfined",function(e) {

        var ctype = jQuery(this).val();
        console.log(wpcf_nd_types);

        if (ctype !== 'x') {
            if (typeof wpcf_nd_types[ctype].xml_data !== 'undefined') {
                predefined_busy = true;


                var tformData = wpcf_nd_types[ctype].xml_data;
                console.log('tformdata');
                console.log(tformData);



                var escapeEl = document.createElement('textarea'),
                  code = document.getElementById('markup'),
                  escapeHTML = function(html) {
                    escapeEl.textContent = html;
                    return escapeEl.innerHTML;
                  },
                  addLineBreaks = function(html) {
                    return html.replace(new RegExp('&gt; &lt;', 'g'), '&gt;\n&lt;').replace(new RegExp('&gt;&lt;', 'g'), '&gt;\n&lt;');
                  };

                var formRenderOpts = {
                  render: false,
                  formData: tformData
                };

                // Grab markup and escape it
                var markup = escapeHTML(new FormRenderFn(formRenderOpts).markup);


                var decoded = jQuery("<div/>").html(addLineBreaks(markup)).text();


                jQuery("#fb-temp-formdata").val(tformData);
                jQuery("#fb-temp-htmldata").val(decoded);


                
                fbOptions = {
                    controlPosition: 'left',
                    disableFields: ['autocomplete', 'button', 'file', 'access'],
                    editOnAdd: true,
                    formData: tformData
                };

               
                jQuery('.build-wrap').html('');
                formBuilder = jQuery('.build-wrap').formBuilder(fbOptions).data('formBuilder');

                predefined_busy = false;
                


            }
            
        }

    });
    
    
});
