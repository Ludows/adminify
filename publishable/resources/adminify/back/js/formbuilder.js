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

    function onAddToAccordion(evt) {
        console.log(evt);
        let noFieldsTextSpan = $('#noFieldsText');
        let cloned_btn = $(evt.item).find('.btn');
        let FieldAccordion = $(evt.to);

        console.log(noFieldsTextSpan)
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

                var count = FieldAccordion.children('.card').length;
                var proto = $('#prototypeField').data('proto').replace(/__NAME__/g, count);

                // var previewHydrated = $(proto).find('#PreviewComponent'+count).append(data.html);

                $(evt.item).replaceWith(proto);

                let previewContainer = $('#card'+count).find('#PreviewComponent'+count);

                previewContainer.append(data.html);

                previewContainer.find('.form-control').removeAttr('name');

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
