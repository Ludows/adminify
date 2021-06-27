let _ = require('lodash');

jQuery(document).ready(function($) {

    let listingBlock = $('.js-listings');

    let tBodyStart = listingBlock.find('.js-datatable tbody').html();

    listingBlock.on('keyup', '.js-search-entity', function(e) {
        e.preventDefault();

        let val = $(this).val()

        if(val.length > 2) {
            _.debounce(function() {
                triggerSearch(val);
            }, 300)
        }
        else {
            listingBlock.find('.js-datatable tbody').html('');
            listingBlock.find('.js-datatable tbody').append(tBodyStart);
        }
        
    })

    function triggerSearch(valInput) {
        // window.listingConfig

        let o = window.listingConfig;

        o['search'] = valInput.toLowerCase().trim();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: Route('listing'),
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
