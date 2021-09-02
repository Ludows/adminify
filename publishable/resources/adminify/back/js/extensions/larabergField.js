export default function LarabergInititalization(fields) {
    $.each(fields, function (i, el) {
        let textarea = $('#' + el.selector + ' textarea');
        let laraberg = Laraberg.init(textarea.attr('id'), el.options);

        let modal = $(window.modalAjaxLaraberg);

        let Interfaces = {
            'select-tpl' : {
                'namespace' : 'App\Forms\SelectTemplate',
                'form-attributes' : {
                    'method' : 'POST',
                    'url' : Route('templates.store')
                }
            },
            'save-tpl' : {
                'namespace' : 'App\Forms\SaveTemplate',
                'form-attributes' : {
                    'method' : 'POST',
                    'url' : Route('templates.setcontent')
                }
            },
        }

        $("#" + el.selector).on('click', '.js-call-modal-laraberg', function (e) {
            e.preventDefault();

            let type = $(this).attr('data-type');

            createFormFromAjax(Interfaces[type], function(err, data) {
                if(err != null) {
                    throw new Error('whoops', err);
                }

                modal.find('.modal-body').append(data.html);
                modal.modal('show');
            })
        })

        modal.on('hidden.bs.modal', function (event) {
            // do something...
            Modale.find('.modal-body').html('');
        })

        function createFormFromAjax(objectInterface, callback) {
            $.ajax({
                    'method': 'POST',
                    url: Route('forms.ajax'),
                    data: objectInterface,
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .done((data) => {
                    if(typeof callback == 'function') {
                        callback(null, data);
                    }
                })
                .fail((err) => {
                    if(typeof callback == 'function') {
                        callback(err, null);
                    }
                })
        }
    })
}