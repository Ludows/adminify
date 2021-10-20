jQuery(document).ready(function ($) {

    const Accordion_zone = $('#Accordion_zone #formBuilderAccordion');
    const Fields_zone = $('#Fields_zone');
    const noFieldText = __('admin.formbuilder.noFields');

    const Accordion_zone_Sortable = new Sortable(Accordion_zone.get(0), {
        group: {
            name: 'shared',
            pull: 'clone' // To clone: set pull to 'clone'
        },
        animation: 150,
        onAdd: onAddToAccordion,
        onEnd:onEndWithinFields,
        handle: '.js-handle'
    });

    const Fields_zone_Sortable = new Sortable(Fields_zone.get(0), {
        group: {
            name: 'shared',
            pull: 'clone',
            put: false // Do not allow items to be put into this list
        },
        sort: false,
        animation: 150,
    });

    Accordion_zone.on('arrange:fields', arrangeFields);

    $(document.body).on('keyup', '.js-labelize', function(e) {
        e.preventDefault();

        let theval = $(this).val().trim();
        let identifier = $(this).attr('data-functional');
        let el = $('#titleChange'+identifier);
        let el_label = $('label[for="example_'+identifier+'"]')

        if(theval.length > 0) {
            el.text(theval);
            el_label.text(theval);
        }
        else {
            el.text( el.attr('data-original-label') );
            el_label.text( el_label.next().attr('data-original-label') );
        }
    })


    function arrangeFields() {
        let cards = Accordion_zone.children('.card');
        console.log('ARRANGE>>', cards)

        $.each(cards, function(i, card) {
            let form_els = $(card).find('[data-replace]');

            $.each(form_els, function(k, formEl) {
                let theDataPattern = $(formEl).attr('data-replace');
                theDataPattern = theDataPattern.replace('__REPLACE__', i);
                $(formEl).attr('name', theDataPattern);
                $(formEl).attr('id', theDataPattern);
                $(formEl).prev('label').attr('for', theDataPattern)
            })
        })
    }

    function onEndWithinFields(evt) {
        Accordion_zone.trigger('arrange:fields');
    }

    // function get

    function onAddToAccordion(evt) {
        console.log(evt);
        let noFieldsTextSpan = $('#noFieldsText');
        let cloned_btn = $(evt.item).find('.btn');
        let FieldAccordion = $(evt.to);
        let dataName = cloned_btn.attr('data-name');

        let allowed_choice_field_types = [
            'select',
            'checkbox',
            'radio',
            'choice'
        ];

        // console.log(noFieldsTextSpan)
        if(Accordion_zone.children().length > 0) {
            if(noFieldsTextSpan.length > 0) {
                noFieldsTextSpan.remove();
            }

            console.log('cloned_btn', cloned_btn.attr('data-name'), cloned_btn)

            $.ajax({
                'method' : 'POST',
                'url' : Route('forms.addField'),
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data' : {
                    'type' : cloned_btn.attr('data-name')
                }
            })
            .done((data) => {
                console.log('success', data);

                var proto = $('#prototypeField').data('proto').replace(/__NAME__/g, '__REPLACE__');
                proto = proto.replace(/__FUNCTIONAL__/g, data.uuid_field_key);

                // var previewHydrated = $(proto).find('#PreviewComponent'+count).append(data.html);

                $(evt.item).replaceWith(proto);

                let previewContainer = $('#card'+data.uuid_field_key).find('#PreviewComponent'+data.uuid_field_key);

                if(allowed_choice_field_types.indexOf(dataName) == -1) {
                    $('#card'+data.uuid_field_key).find('#choices_'+data.uuid_field_key).css('display' ,'none');
                }

                previewContainer.append(data.html);

                previewContainer.find('.form-control').removeAttr('name');

                Accordion_zone.trigger('arrange:fields');



            })
            .fail((err) => {
                console.log(err)
            })


        }
        else {
            Accordion_zone.append('<span id="noFieldsText">'+ noFieldText +'</span>');
        }
    }

});
