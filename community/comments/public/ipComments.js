(function($) {
    $.fn.ipWidgetIpCommentsForm = function() {
        return this.each(function() {
            var $ipCommentsForm = $(this);
            $ipCommentsForm.find('form').validator(validatorConfig);
            $ipCommentsForm.find('form').submit(function(e) {
                var $form = $(this);
                // client-side validation OK.
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: ip.baseUrl,
                        dataType: 'json',
                        type : 'POST',
                        data: $form.serialize(),
                        success: function (response){
                            if (!response) {
                                return;
                            }
                            if (response.status && response.status == 'success') {
                                if (response.redirectUrl) {
                                    document.location = response.redirectUrl;
                                }
                            } else {
                                if (response.errors) {
                                    $form.data("validator").invalidate(response.errors);
                                }
                            }
                        },
                        error: function () {
                            console.log('error');
                        }
                      });
                }
                e.preventDefault();
            });

        });
    };
})(jQuery);


$(document).ready(function() {
    $('.ipWidget-IpComments').ipWidgetIpCommentsForm();
    console.log($('.ipWidget-IpComments'));
});