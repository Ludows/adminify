jQuery(document).ready(function($) {

    let Btns = $('.js-send-mailable');


    $.each(Btns, function(i, btn) {

        $(btn).on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                'method' : 'POST',
                'url' : Route('mails.send', {
                    mail : $(this).attr('data-id')
                }),
                'dataType' : 'json',
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data' : {}
            })
            .done((data) => {
                
            })
            .fail((err) => {
                console.log(err)
            })

        })
    })
    

})
