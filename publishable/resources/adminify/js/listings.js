let _ = require('lodash');

jQuery(document).ready(function ($) {

    let listingBlock = $('.js-listings');

    let tBodyStart = listingBlock.find('.js-datatable tbody').html();

    console.log(_.debounce)

    listingBlock.on('keyup', '.js-search-entity', _.debounce(function (e) {
            e.preventDefault();

            let val = $(this).val()

            if (val.length > 2) {
                console.log('val>>>', val)
                triggerSearch(val);
            } else {
                listingBlock.find('.js-datatable tbody').html('');
                listingBlock.find('.js-datatable tbody').append(tBodyStart);
            }

        }, 300)



    )

    function triggerSearch(valInput) {
        // window.listingConfig

        console.log('debounced')
        let o = window.listingConfig;

        o['search'] = valInput.toLowerCase().trim();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: Route('listings'),
            data: o,
            success: function (data) {
                listingBlock.find('.js-datatable tbody').html('');
                listingBlock.find('.js-datatable tbody').append(data.html);
            },
            error: function (err) {
                console.log('err', err)
            }
        })
    }

})
