jQuery(document).ready(function ($) {
    console.log('hello from metas !')


    $(document).on('change', '.js-typed-data', function(e) {
        let data = $(this).val();

        console.log('data', data)

        let o = formatObjectSearch($(this), data)

        console.log('o',o)

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

        // console.log('jQuerySelector', jQuerySelector)
        // console.log('hasClass js-typed-data', jQuerySelector.hasClass('js-typed-data'))

        let parent = jQuerySelector.parent().parent().parent()
        let trigger = null;

        if(jQuerySelector.hasClass('js-typed-data') == true) {
            trigger = parent.find('select').last()
        }
        else {
            trigger = parent.find('select').first()
        }

        if(data == 'content_type_model') {
            o.url = Route('finder.contentTypes', {});
        }
        else {

            let theVal = jQuerySelector.val();
            theVal = theVal.replace('model:', '').trim()

            o.url = Route('finder', {
                type: theVal
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
