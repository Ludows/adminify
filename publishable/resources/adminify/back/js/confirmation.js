jQuery(document).ready(function() {
    // console.log('loaded confirmation !');

    let typedBlocks = $('[data-show-type]');

    // console.log('typedBlocks', typedBlocks)

    $('#selectTypeBlock').on('change', 'select', function(e) {
        console.log('changed');
        let theVal = $(this).val();
        let activeBlock = $('[data-show-type="'+ theVal +'"]');

        typedBlocks.not(activeBlock).addClass('d-none');

        activeBlock.removeClass('d-none');

    });


})
