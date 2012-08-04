
"use strict";

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

                            if (response.commentId) {
                                var newLocation = document.location.href;
                                if (newLocation.indexOf('ipModuleComments=') > 0) {
                                    newLocation = newLocation.substring(0, newLocation.indexOf('ipModuleComments='));
                                }
                                if (newLocation.indexOf('#') > 0) {
                                    newLocation = newLocation.substring(0, newLocation.indexOf('#'));
                                }

                                if (newLocation.indexOf('?') < 0) {
                                    newLocation = newLocation + '?';
                                } else {
                                    newLocation = newLocation + '&';
                                }
                                newLocation = newLocation + 'ipModuleComments=' + response.commentId + '#ipModuleComments-' + response.commentId;
                                document.location = newLocation;
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

});