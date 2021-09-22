let _ = require('lodash');

jQuery(document).ready(function ($) {

    let listingBlock = $('.js-listings');

    let tBodyStart = listingBlock.find('.js-datatable tbody').html();

    let searchEntity = listingBlock.find('.js-search-entity');
    let btnsListing = listingBlock.find('.js-listing-btn');
    let searchhasbeenTriggered = false;

    listingBlock.on('change', '.js-select-status', _.debounce(function (e) {
        loadSearch($(this).val(), true)
    }, 300))

    listingBlock.on('keyup', '.js-search-entity', _.debounce(function (e) {
        e.preventDefault();

        loadSearch($(this).val(), false)

    }, 300))

    listingBlock.on('click', '.js-listing-btn', function (e) {
        triggerSearch(searchEntity ? searchEntity.val() : null, true, $(this));
    });

    function loadSearch(value, isStatusable) {
        let val = value

        if (val.length > 2 && !isStatusable) {
            console.log('val>>>', val)
            triggerSearch(val, false);
        } else if(isStatusable) {
            triggerSearch( listingBlock.find('.js-search-entity').val() , false, null, val);
        } else {
            listingBlock.find('.js-datatable tbody').html('');
            listingBlock.find('.js-datatable tbody').append(tBodyStart);
            listingBlock.attr('data-page', '1')
        }
    }

    function syncBtns(currentPage = 1) {

        console.log('SYNC')

        let dataPage = currentPage;

        console.log('dataPage', dataPage)

        if(dataPage == 1) {
            btnsListing.eq(0).attr('disabled', 'disabled');
        }

        if( listingBlock.find('.js-datatable tbody').children().length <  window.listingConfig.limit) {
            btnsListing.attr('disabled', 'disabled');
        }
        else {
            btnsListing.eq(1).removeAttr('disabled');
        }

        if(!window.listingConfig.isEnd && dataPage > 1) {
            console.log('sup')
            btnsListing.eq(0).removeAttr('disabled');
        }



        if(window.listingConfig.isEnd) {
            btnsListing.eq(0).removeAttr('disabled');
            btnsListing.eq(1).attr('disabled', 'disabled');
        }
        else {
            btnsListing.eq(1).removeAttr('disabled');
        }

    }

    function triggerSearch(valInput, fromBtns, btnElement = null, statusId = -1) {
        // window.listingConfig

        console.log('debounced')

        let o = window.listingConfig;

        if(valInput != null && valInput.length > 0) {
            o['search'] = valInput.toLowerCase().trim();
        }

        if(btnElement != null) {
            var _direction = btnElement.attr('data-direction');
        }

        // if(statusId != -1) {
        o['status'] = statusId;
        // }
        // if(fromBtns) {
        o['offset'] = _direction == 'next' ? parseInt( listingBlock.attr('data-page') ) * window.listingConfig.limit : ( parseInt( listingBlock.attr('data-page') ) * window.listingConfig.limit ) - (window.listingConfig.limit * 2);

        console.log('offset', o['offset']);
        // }


        if(searchhasbeenTriggered == false) {



            searchhasbeenTriggered = true;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: Route('listings'),
                data: o,
                success: function (data) {
                    console.log('data', data);
                    console.log(listingBlock.find('.js-datatable tbody'))
                    listingBlock.find('.js-datatable tbody').html('');
                    listingBlock.find('.js-datatable tbody').append(data.html);

                    window.listingConfig.isEnd = data.isEnd;
                    console.log('after change is end', window.listingConfig);

                    if(!fromBtns) {
                        listingBlock.attr('data-page', '1')
                    }
                    else {

                        let dataPage = parseInt(listingBlock.attr('data-page'));

                        if(btnElement != null) {
                            if(_direction == 'next') {
                                listingBlock.attr('data-page', dataPage + 1);
                            }
                            if(_direction == 'previous') {
                                listingBlock.attr('data-page', dataPage - 1);
                            }
                        }

                    }

                    syncBtns( parseInt(listingBlock.attr('data-page')) )

                    searchhasbeenTriggered = false;

                },
                error: function (err) {
                    console.log('err', err)
                }
            })
        }

    }

    if (searchEntity.length > 0 && searchEntity.val().length > 0) {
        searchEntity.trigger('keyup');
    }

    syncBtns();
})
