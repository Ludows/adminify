export default function LarabergInititalization(fields) {
    $.each(fields, function(i, el) {
        let textarea = $('#'+el.selector+' textarea');
        let laraberg =  Laraberg.init(textarea.attr('id'), el.options);

        let modal_select = $('#modalSelectTemplate');
        let modal_save = $('#modalSaveTemplate');

        $("#"+el.selector).on('click', '.js-select-template', function(e) {
            e.preventDefault();
            modal_select.modal('show');
        })

        $("#"+el.selector).on('click', '.js-save-template', function(e) {
            e.preventDefault();
            modal_save.modal('show');
        })

        modal_select.on('submit', 'form', function(e) {
            e.preventDefault();

            let form = $(this);

            $.ajax({
                'method' : 'POST',
                'url' : $(this).attr('action'),
                'dataType' : 'json',
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data' : {}
            })
            .done((data) => {
                console.log('success')
                $(form).clearValues();

                let c = Laraberg.getContent() + data.html;

                Laraberg.setContent( c );
                modal_save.modal('close');
            })
            .fail((err) => {
                console.log(err)
            })
        })

        modal_save.on('submit', 'form', function(e) {
            e.preventDefault();

            let form = $(this);

            form.find('[name="content"]').val( Laraberg.getContent() )

            $.ajax({
                'method' : 'POST',
                'url' : $(this).attr('action'),
                'dataType' : 'json',
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data' : {}
            })
            .done((data) => {
                console.log('success')
                $(form).find('[name]').not('[name="_token"]').setResponseFromAjax()
                $(form).clearValues();
                modal_save.modal('close');
            })
            .fail((err) => {
                console.log(err)
                $(form).find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON)
            })
        })
    })
}
