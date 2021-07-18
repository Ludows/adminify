export default function select2Inititalization(fields) {

    $.each(fields, function(i, el) {
        var select2boxe = $(el.selector + '> .form-group > select');

        console.log('select2boxe', select2boxe);

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
                if(!datas.parent_id && datas.category != undefined) {
                    datas.parent_id = 0;
                }
                console.log(datas)
                $.ajax({
                    method: ModaleForm.attr('method'),
                    url: ModaleForm.attr('action'),
                    data: datas,
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        console.log(data)
                        $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax()
                        $(ModaleForm).clearValues();

                        if(el.multilang == 1) {
                            var newOption = new Option(data[1].title[el.currentLang], data[1].id, false, true);
                        }
                        else {
                            var newOption = new Option(data[1].title, data[1].id, false, true);
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
