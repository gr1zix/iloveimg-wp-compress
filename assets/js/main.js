// jQuery(function(){
//     alert('.field_'+ jQuery("#fieldrow-mode select").val())
//     jQuery('.field_'+ jQuery("#fieldrow-mode select").val()).show();
//     jQuery("#fieldrow-mode select").on("change", function(){
//         alert(jQuery("#fieldrow-mode select").val());
//     });
// });
(function() {
    var adminpage = '';
    if (typeof window.adminpage !== 'undefined') {
        adminpage = window.adminpage;
    }
    var timesIntervals = new Array();

    function compressImage(event) {
        var element = jQuery(event.target);
        var container = element.closest('td');
        element.attr('disabled', 'disabled');
        element.next().show();
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
              action: 'iloveimg_compress_library',
              id: element.data('id') || element.attr('data-id')
            },
            success: function(data) {
              element.removeAttr('disabled');
              container.html(data);
            },
            error: function() {
              element.removeAttr('disabled');
              //container.find('span.spinner').addClass('hidden');
            }
          });
    }

    function statusCompressing(element, index){
        var element = jQuery(element);
        var container = element.closest('td');
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
              action: 'iloveimg_compress_library_is_compressed',
              id: element.data('id') || element.attr('data-id')
            },
            success: function(data) {
                if(data != 'processing') {
                    clearInterval(timesIntervals["ref_" + index]);
                    container.html(data);
                }
            },
            error: function() {

            }
          });
    }
    
    switch (adminpage) {
        case 'upload-php':
        case 'media_page_iloveimg_image_optimized':
            jQuery(document).on("click", "button.iloveimg-compress", compressImage);
            jQuery('<option>').val('iloveimg_bulk_action').text("Compress Images").appendTo('select[name=action]');
            jQuery('<option>').val('iloveimg_bulk_action').text("Compress Images").appendTo('select[name=action2]');
            jQuery('.iloveimg_compressing').each(function(index, element) {
                timesIntervals["ref_" + index] = setInterval(function(){
                    statusCompressing(element, index);
                },  1000);
            });
            break;
    }
}).call();