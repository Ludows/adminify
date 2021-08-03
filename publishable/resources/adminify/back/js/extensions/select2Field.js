export default function select2Inititalization(fields) {

    $.each(fields, function(i, el) {
        var select2boxe = $(el.selector + ' select.form-control');

        console.log('select2boxe', select2boxe);
        console.log('el select2', el);

        if(el.withCreate) {
            var btnCallModal = $(el.selector+ ' .js-handle-form-create');
            var ModaleCreatedCat = $(el.modal_id);
            var ModaleForm = ModaleCreatedCat.find('form');

            btnCallModal.on('click', function(e) {
                e.preventDefault();
                if(ModaleCreatedCat.length > 0) {
                    ModaleCreatedCat.modal('show');
                }
            })

            ModaleForm.on('click', '[type="submit"]', function(e) {
                e.preventDefault();

                var datas = ModaleForm.serializeFormJSON();
                
                console.log(datas)
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
                            var newOption = new Option(data[keys[0]].title[el.currentLang], data[keys[0]].id, false, true);
                        }
                        else {
                            var newOption = new Option(data[keys[0]].title, data[keys[0]].id, false, true);
                        }


                        select2boxe.append(newOption).trigger('change');


                        ModaleCreatedCat.modal('hide');
                        // select2boxe.select2('open');
                    },
                    error: function(err) {
                        console.log('whoops', err)
                        $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON)

                    }
                })
            })
        }

        select2boxe.select2(el.options);
    })


}
