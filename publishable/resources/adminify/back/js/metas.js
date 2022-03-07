jQuery(document).ready(function ($) {
    console.log('hello from metas !')


    $(document).on('change', '.js-typed-data', function(e) {
        let data = $(this).val();

        let o = formatObjectSearch($(this))

        if(o.SendToAjax) {
            makeSearch(o, (err, data) => {
                if(err) {
                    console.log('whoops', err)
                    return false;
                }
    
                console.log(data)
            })
        }
        
    })

    // $(document).on('change', '.js-select-value', function(e) {
    //     let parent = $(this).parent().parent().parent()
    //     let sel = parent.find('select').first();
    //     sel.trigger('change');
    // })

    function formatObjectSearch(jQuerySelector, data) {
        let o = {};

        o.data = {};
        o.SendToAjax = true;

        let parent = jQuerySelector.parent().parent().parent()
        let trigger = null;

        if(jQuerySelector.hasClass('.js-typed-data')) {
            trigger = parent.find('select').last()
        }
        else {
            trigger = parent.find('select').first()
        }

        if(data = 'content_type_model') {
            o.url = Route('finder.contentTypes', {});
        }
        else {

            let theVal = trigger.val();

            if(theVal.length == 0) {
                o.SendToAjax = false;
            }

            o.url = Route('finder', {
                type: trigger.val()
            });
        }

        return o;
    }

    function makeSearch(object, callback) {

        // console.log('selecteds', selecteds);

        $.ajax({
            method: 'POST',
            url: object.url,
            data: object.data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (typeof callback == 'function') {
                    callback(null, data);
                }
            },
            error: function (err) {
                // console.log('whoops', err);
                if (typeof callback == 'function') {
                    callback(err, null);
                }
            }
        })

    }
});