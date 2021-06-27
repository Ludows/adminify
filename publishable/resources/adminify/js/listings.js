let _ = require('lodash');

jQuery(document).ready(function ($) {

    let listingBlock = $('.js-listings');

    let tBodyStart = listingBlock.find('.js-datatable tbody').html();

    let searchEntity = listingBlock.find('.js-search-entity');
    let btnsListing = listingBlock.find('.js-listing-btn');

    listingBlock.on('keyup', '.js-search-entity', _.debounce(function (e) {
        e.preventDefault();

        let val = $(this).val()

        if (val.length > 2) {
            console.log('val>>>', val)
            triggerSearch(val, false);
        } else {
            listingBlock.find('.js-datatable tbody').html('');
            listingBlock.find('.js-datatable tbody').append(tBodyStart);
            listingBlock.attr('data-page', '1')
        }

    }, 300))

    listingBlock.on('click', '.js-listing-btn', function (e) {
        triggerSearch(searchEntity.val(), true, $(this));
    });

    function syncBtns() {
        
        let dataPage = parseInt(listingBlock.attr('data-page'));
        
        if(dataPage = 1) {
            btnsListing.eq(0).attr('disabled', 'disabled');
        }

        if(dataPage > 1) {
            btnsListing.eq(0).removeAttr('disabled');
        }

        if( listingBlock.find('.js-datatable tbody').children().length <  window.listingConfig.maxItems) {
            btnsListing.eq(0).attr('disabled', 'disabled');
            btnsListing.eq(1).attr('disabled', 'disabled');
        }

        if(window.listingConfig.isEnd) {
            btnsListing.eq(1).attr('disabled', 'disabled');
        }

    }

    function triggerSearch(valInput, fromBtns, btnElement = null) {
        // window.listingConfig

        console.log('debounced')
        let o = window.listingConfig;

        if(valInput.length > 0) {
            o['search'] = valInput.toLowerCase().trim();
        }

        if(fromBtns) {
            o['offset'] = parseInt( listingBlock.attr('data-page') ) * window.listingBlock.limit;
        }

        if(btnElement != null) {
            let direction = btnElement.attr('data-direction');
        }

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

                window.listingBlock.isEnd = data.isEnd;

                if(!fromBtns) {
                    listingBlock.attr('data-page', '1')
                }
                else {

                    let dataPage = parseInt(listingBlock.attr('data-page'));

                    if(btnElement != null) {
                        if(direction == 'next') {
                            listingBlock.attr('data-page', dataPage + 1);
                        }
                        else {
                            listingBlock.attr('data-page', dataPage - 1);
                        }
                    }

                }

                syncBtns()
                
            },
            error: function (err) {
                console.log('err', err)
            }
        })
    }

    if (searchEntity.val().length > 0) {
        searchEntity.trigger('keyup');
    }

    syncBtns();
})
