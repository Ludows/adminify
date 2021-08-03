(function ($) {
    $.fn.clearValues = function ($selector = null) {

        var values = this.serializeFormJSON();
        var ObjectKeys = Object.keys(values);
        var fields = $(this).find( '[name]');
        $.each(ObjectKeys, function(i, key) {
            $.each(fields, function(i, field) {
                var attrName = $(field).attr('name');
                // console.log(attrName, field)
                if(attrName == key) {
                    if($(field).is(':radio') || $(field).is(':checkbox')) {
                        $(field).prop('checked', false);
                    }
                    else {
                        $(field).val(null);
                    }

                    return false;
                }
            })
        })
    };
})(jQuery);
