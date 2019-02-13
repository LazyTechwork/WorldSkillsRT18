var fbTemplate;
var formBuilder;
jQuery(document).ready(function($) {
    
    jQuery("#post").attr('novalidate','novalidate');



     var buildWrap = document.querySelector('.build-wrap'),
        renderWrap = document.querySelector('.render-wrap'),
        editing = true,
        fbOptions = {
            controlPosition: 'left',
            disableFields: ['autocomplete', 'button', 'file', 'access'],
            editOnAdd: true,
            formData: tmpformData
        };

      if (tmpformData) {
        fbOptions.formData = tmpformData;
      }

    formBuilder = jQuery(buildWrap).formBuilder(fbOptions).data('formBuilder');

});