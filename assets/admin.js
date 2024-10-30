(function($){
  $(document).ready(function(){
    var fields = [
      'c4d-woo-bs-email-process-order',
      'c4d-woo-bs-email-complete-order',
      'c4d-woo-bs-email-customer-note',
      'c4d-woo-bs-global-thankyou-page',
      'c4d-woo-bs-up-order',
      'c4d-woo-bs-cross-order',
      'c4d-woo-bs-up-limit',
      'c4d-woo-bs-cross-limit',
      'c4d-woo-bs-cross-column',
      'c4d-woo-bs-up-column'
    ];
    $.each(fields, function(index, el){
      var element = $('fieldset[id*="' + el + '"]');
      element.append('<div class="c4d-label-pro-version"><a target="blank" href="#">Pro Version</a></div>');
    });
  });
})(jQuery);