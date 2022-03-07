jQuery(document).ready(function ($) {
    console.log('hello from metas !')

    let jsTypedData = $('.js-typed-data');

    jsTypedData.on('change', function(e) {
        let data = $(this).val();
        // makeSearch(data, (err, data) => {
        //     if(err) {
        //         console.log('whoops', err)
        //         return false;
        //     }

        //     console.log(data)


        // })
    })

    function makeSearch(modelType, callback) {

        // console.log('selecteds', selecteds);

        let o = {};

        $.ajax({
            method: 'POST',
            url: Route('finder', {
                type: modelType
            }),
            data: o,
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