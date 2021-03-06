export default function select2Inititalization(fields) {

    $.each(fields, function(i, el) {
        var select2boxe = $(el.selector + ' select.form-control');

        // console.log('select2boxe', select2boxe);
        // console.log('el select2', el);

        if(el.withCreate) {
            var btnCallModal = $(el.selector+ ' .js-handle-form-create');
            var Modale = $('#'+el.modal_attributes.id);

            btnCallModal.on('click', function(e) {
                e.preventDefault();
                if(Modale.length > 0) {
                    Modale.modal('show');
                }
            })

            if(el.dynamic_modal) {
                callAjaxForForm(Modale.find('.modal-body'), Object.keys(el.form).length > 0 ? el.form.namespace : '', el.form.attributes, el, select2boxe);

                Modale.on('show.bs.modal', function (event) {
                    // do something...
                    if(Modale.find('.modal-body').children().length == 0) {
                        callAjaxForForm(Modale.find('.modal-body'), Object.keys(el.form).length > 0 ? el.form.namespace : '', el.form.attributes, el, select2boxe);
                    }
                })
                Modale.on('hidden.bs.modal', function (event) {
                    // do something...
                    Modale.find('.modal-body').html('');
                })
            }
            else {
                loadDefaultProcess(Modale, el, select2boxe);
            }

        }



        select2boxe.select2(el.options);
    })

    function callAjaxForForm(context, namedForm = 'medias', datas = {}, el, select2boxe) {
        $.ajax({
            method: 'POST',
            url: Route('forms.ajax'),
            data: {
                'namespace' : namedForm,
                'form-attributes' : datas
            },
            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                context.append(data.html)
                // console.log(context.parents('.modal'));
                loadDefaultProcess(context.parents('.modal'), el, select2boxe);
            },
            error: function(err) {
                console.log('whoooops', err);
            }
        })
    }

    function loadDefaultProcess(Modale, el, select2boxe) {
        var ModaleForm = Modale.find('form');

        ModaleForm.on('click', '[type="submit"]', function(e) {
            e.preventDefault();

            var datas = ModaleForm.serializeFormJSON();

            // console.log(datas)
            $.ajax({
                method: ModaleForm.attr('method'),
                url: ModaleForm.attr('action'),
                data: datas,
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    console.log(data)

                    let keys = Object.keys(data);

                    $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax()
                    $(ModaleForm).clearValues();
                    // console.log(data[0])
                    if(el.multilang == 1) {
                        var newOption = new Option(data['model'].title[el.currentLang], data['model'].id, false, true);
                    }
                    else {
                        var newOption = new Option(data['model'].title, data['model'].id, false, true);
                    }


                    select2boxe.append(newOption).trigger('change');


                    Modale.modal('hide');
                    // select2boxe.select2('open');
                },
                error: function(err) {
                    console.log('whoops', err)
                    $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON)

                }
            })
        })
    }


}
