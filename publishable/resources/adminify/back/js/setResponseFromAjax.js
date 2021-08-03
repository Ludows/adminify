(function ($) {
    $.fn.setResponseFromAjax = function (error) {

        var elms = $(this);
        console.log(elms)

        if(error) {
            var errorKeys = Object.keys(error.errors);

            $.each(elms, function(i, el) {
                var input = $(el)
                var name = $(el).attr('name');
                $.each(errorKeys, function(i, errorKey) {

                    if(name == errorKey) {
                        input.addClass('is-invalid');
                        var tpl = '<div class="invalid-feedback">'+ error.message +'</div>';
                        if( $(input).next().hasClass('invalid-feedback') ) {
                            $(input).next().remove()
                        }
                        $(input).after( tpl )
                    }
                    else {
                        input.removeClass('is-invalid');
                        if( $(input).next().hasClass('invalid-feedback') ) {
                            $(input).next().remove()
                        }
                    }


                })
            })
        }
        else {
            $.each(elms, function(i, el) {
                var input = $(el)
                input.removeClass('is-invalid');
                if( $(input).next().hasClass('invalid-feedback') ) {
                    $(input).next().remove()
                }
            })
        }

    };
})(jQuery);
