export default function LarabergInititalization(fields) {
    $.each(fields, function (i, el) {
        let textarea = $('#' + el.selector + ' textarea');
        let laraberg = Laraberg.init(textarea.attr('id'), el.options);

        let modal = $(window.modalAjaxLaraberg);
        let type = null;

        let Interfaces = {
            'select-tpl' : {
                'namespace' : 'App\\Adminify\\Forms\\SelectTemplate',
                'form-attributes' : {
                    'method' : 'POST',
                    'url' : Route('templates.setcontent')
                }
            },
            'save-tpl' : {
                'namespace' : 'App\\Adminify\\Forms\\SaveTemplate',
                'form-attributes' : {
                    'method' : 'POST',
                    'url' : Route('templates.store')
                }
            },
        }

        let titles = {
            'select-tpl' : __('admin.modal_title'),
            'save-tpl' : __('admin.modal_title')
        }

        modal.on('submit', 'form', function(e) {
            e.preventDefault();

            console.log('logged')

            let obj = Interfaces[type];
            let form = $(this).get(0);

            if(type == 'save-tpl') {
                let content = Laraberg.getContent();
                $(form).find('[name="content"]').val(content);
            }

            let formValues = $(form).serializeFormJSON();
            obj.values = formValues;
            console.log('obj', obj)
            makeProcess(Interfaces[type], function(err, data) {
                console.log('data', data)
                if(err != null) {
                    console.log(err)
                    $(form).find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON);
                }

                $(form).clearValues();
                if(data != null) {
                    $(modal).modal('hide');
                }

                if(type == 'select-tpl') {
                    Laraberg.setContent(data.html)
                }
            });
        })

        $("#" + el.selector).on('click', '.js-call-modal-laraberg', function (e) {
            e.preventDefault();

            type =  $(this).attr('data-type');

            createFormFromAjax(Interfaces[type], function(err, data) {
                if(err != null) {
                    throw new Error('whoops', err);
                }
                modal.find('.modal-title').text( titles[type] );
                modal.find('.modal-body').append(data.html);
                modal.modal('show');
            })
        })



        modal.on('hidden.bs.modal', function (event) {
            // do something...
            modal.find('.modal-body').html('');
        })

        function makeProcess(objectInterface, callback) {

            let route = objectInterface['form-attributes'].url;
            let method = objectInterface['form-attributes'].method;

            $.ajax({
                'method': method,
                url: route,
                data: objectInterface.values,
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
