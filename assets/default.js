(function($){
  "use strict";
  $(document).ready(function(){
    if ($('body').hasClass('woocommerce-order-received')) {
      setTimeout(function(){
        $(document.body).unbind('added_to_cart');
      }, 2000);

      $( document ).ajaxComplete(function( event, xhr, settings ) {
        if (settings.url.indexOf('wc-ajax=add_to_cart') > 0) {
          if ( xhr.responseJSON.fragments ) {
            $.each( xhr.responseJSON.fragments, function( key, value ) {
              $( key ).replaceWith( value );
            });
            $( document.body ).trigger( 'wc_fragments_loaded' );
          }
        }
      });
    }
  });
})(jQuery);