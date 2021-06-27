let _ = require('lodash');

jQuery(document).ready(function($) {

    let listingBlock = $('.js-listings');

    listingBlock.on('keydown', 'js-search-entity', function(e) {
        e.preventDefault();

        let val = $(this).val()

        _.debounce(function() {
            triggerSearch(val);
        }, 500)
    })

    function triggerSearch(valInput) {

    }

})
