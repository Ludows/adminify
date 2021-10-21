jQuery(document).ready(function ($) {

    const Accordion_zone = $('#Accordion_zone #formBuilderAccordion');
    const Fields_zone = $('#Fields_zone');
    const noFieldText = __('admin.formbuilder.noFields');

    window.formfields = {};

    const allowed_for_checked = [
        'choice',
        'checkbox',
        'radio'
    ];

    const allowed_choice_field_types = [
        'select',
        'select2',
        'choice',
        'choice.select:single',
        'choice.select:multiple',
        'choice.checkbox',
        'choice.radio'
    ];

    const not_allowed_to_classic_fields = [
        'choice.select:single',
        'choice.select:multiple',
        'choice.checkbox',
        'choice.radio',
        'select2',
        'static'
    ];

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

    $(document.body).on('keyup', '.js-value', function(e) {
        e.preventDefault();
        let val = $(this).val();
        let id = $(this).attr('data-functional');
        let el = $('#example_'+id);

        if(val.length > 0) {
            el.attr('value', val);
        }
        else {
            el.removeAttr('value');
        }
    });

    $(document.body).on('change', '.js-show-label', function(e) {
        e.preventDefault();

        let isChecked = $(this).is(':checked');
        let id = $(this).attr('data-functional');
        let el = $('label[for="example_'+id+'"]');

        if(isChecked) {
            el.css('display', 'none');
            el.css('display', 'none');
        }
        else {
            el.css('display', '');
            el.css('display', '');
        }

    })

    $(document.body).on('change', '.js-check-checked', function(e) {
        e.preventDefault();

        let isChecked = $(this).is(':checked');
        let id = $(this).attr('data-functional');
        let el = $('#example_'+id);

        if(isChecked) {
            el.attr('checked', 'checked');
        }
        else {
            el.removeAttr('checked');
        }

    })

    function generateBlocks(config) {

        let helpBlock = `<${config.preview_form_options[0].help_block.tag} id="${config.preview_form_options[0].help_block.attr.id}" class="${config.preview_form_options[0].help_block.attr.class}">${config.preview_form_options[0].help_block.text}</${config.preview_form_options[0].help_block.tag}>`;
        let errorsBlock = `<div id="${config.preview_form_options[0].errors.id}" class="${config.preview_form_options[0].errors.class}">${config.preview_form_options[0].errors.text}</div>`;

        let previewContainer = $('#PreviewComponent'+config.uuid_field_key+ ' #example_'+config.uuid_field_key);
        // console.log(previewContainer)
        $(errorsBlock).insertAfter(previewContainer)
        $(helpBlock).insertAfter(previewContainer)
    }

    function formatAttributes(value) {
        let breaks = value.split(',');
        let o = {};
        // console.log('breaks', breaks);

        $.each(breaks, function(i, breakableVal) {
            breaks[i] = breakableVal.trim();
        })

        $.each(breaks, function(i, breakableVal) {
            let breakables = breakableVal.trim().split(':');
            if(breakables.length > 0) {
                o[ breakables[0] ] = breakables[1];
            }
        })

        return o;
    }

    function hydrateSelectedField(attribs, uuid) {
        let selected_select = $('#selected_'+uuid+' select');
        let AttribsKeys = Object.keys(attribs);

        selected_select.children().remove();

        $.each(AttribsKeys, function(i, Attrib) {
            selected_select.append('<option value="'+ Attrib +'">'+ attribs[Attrib] +'</option>');
        })

        selected_select.children().first().attr('selected', 'selected');
    }

    $(document.body).on('blur', '.js-choices', function(e) {
        e.preventDefault();

        let id = $(this).attr('data-functional');
        let type = getTypeField(id);
        let previewContainer = $('#PreviewComponent'+id);
        let val = $(this).val() ?? null;

        if(val != null && val.length > 0) {
            let attributes = formatAttributes( val );
            let AttribsKeys = Object.keys(attributes);
            let el = null;
            let label_for_el = null;

            if(AttribsKeys.length > 0) {
                // 'choice.select:single',
                // 'choice.select:multiple',
                // 'choice.checkbox',
                // 'choice.radio'
                switch (type) {
                    case 'select':
                    case 'select2':
                    case 'choice.select:single':
                    case 'choice.select:multiple':
                        el = previewContainer.find('select');
                        el.children().remove();
                        $.each(AttribsKeys, function(i, Attrib) {
                            el.append('<option value="'+ Attrib +'">'+ attributes[Attrib] +'</option>');
                        })
                        break;
                    case 'choice.checkbox':
                    case 'choice.radio':
                        el = previewContainer.find('input').first().clone(true);
                        label_for_el = previewContainer.find('input').first().next().clone(true);

                        let elements = previewContainer.find('.form-group').children().not('label:eq(0)');
                        let block = previewContainer.find('.form-group');
                        elements.remove();
                        $.each(AttribsKeys, function(i, Attrib) {

                            el = el.clone(true);
                            label_for_el = label_for_el.clone(true);
                            console.log('log')
                            el.attr('value', Attrib);
                            el.attr('id', 'example_'+ id +'_example-'+i+'')
                            label_for_el.text(attributes[Attrib]);
                            label_for_el.attr('for', 'example_'+ id +'_example-'+i+'');

                            block.append(el)
                            block.append(label_for_el);
                        })

                        break;
                }

                hydrateSelectedField(attributes, id);
            }
        }

    })

    $(document.body).on('blur', '.js-attrs', function(e) {
        e.preventDefault();

        let id = $(this).attr('data-functional');
        let previewContainer = $('#PreviewComponent'+id);
        let location = $(this).attr('data-location');
        let val = $(this).val() ?? null;

        let el = previewContainer.find(location);

        if(val != null && val.length > 0) {
            let attributes = formatAttributes( val );
            let AttribsKeys = Object.keys(attributes);

            if(AttribsKeys.length > 0) {

                $.each(AttribsKeys, function(i, Attrib) {
                    el.removeAttr(Attrib);
                    el.attr(Attrib, attributes[Attrib]);
                })
            }
        }
    })

    $(document.body).on('change', '.js-max-length', function(e) {

        let val = parseInt($(this).val());
        let id = $(this).attr('data-functional');
        let el = $('#example_'+id);
        if(!isNaN(val)) {
            el.attr('maxlength', val);
        }
        else {
            el.removeAttr('maxlength');
        }

    });

    $(document.body).on('keyup', '.js-error-message', function(e) {
        e.preventDefault();
        let val = $(this).val().trim();
        let id = $(this).attr('data-functional');
        let el = $('#errors_'+id);

        if(val.length > 0) {
            el.removeClass('d-none').text(val);
        }
        else {
            el.addClass('d-none').text('');
        }
    })



    $(document.body).on('click', '.js-delete', function(e) {
        e.preventDefault();
        let hasFieldId = $(this).attr('data-field-id') ? true : false;
        let id = $(this).attr('data-functional');
        let el = $('#card'+id);

        if(hasFieldId) {
            alert('todo');
        }
        else {
            el.fadeOut('slow', function() {
                el.remove();
                if(Accordion_zone.children('.card').length == 0) {
                    generateSpanNoFields();
                }
            });
        }
    })

    $(document.body).on('click', '.js-dupplicate', function(e) {
        e.preventDefault();

        let type = $(this).attr('data-type');

        let fakeItem = $('<div class=""><button data-name="'+ type +'" class="btn"></button></div>');
        Accordion_zone.append(fakeItem);
        //fake event
        onAddToAccordion({
            item : fakeItem.get(0),
            to : Accordion_zone.get(0)
        })

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
                $(formEl).next('label').attr('for', theDataPattern)
            })
        })
    }

    function onEndWithinFields(evt) {
        Accordion_zone.trigger('arrange:fields');
    }

    function getTypeField(uuid) {
        return $('#card'+uuid+' .js-dupplicate').attr('data-type');
    }

    function conditionalFields(check, list, selector, condional = 'equal') {

        if(condional == 'diff') {
            condional = eval(list.indexOf(check) != -1);
        }
        else {
            condional = eval(list.indexOf(check) == -1);
        }

        if(condional) {
            $(selector).css('display' ,'none');
        }
    }

    function generateSpanNoFields() {
        Accordion_zone.append('<span id="noFieldsText">'+ noFieldText +'</span>');
    }
    // function get

    function onAddToAccordion(evt) {
        console.log(evt);
        let noFieldsTextSpan = $('#noFieldsText');
        let cloned_btn = $(evt.item).find('.btn');
        let FieldAccordion = $(evt.to);
        let dataName = cloned_btn.attr('data-name');



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
                    'type' : dataName
                }
            })
            .done((data) => {
                console.log('success', data);

                var proto = $('#prototypeField').data('proto').replace(/__NAME__/g, '__REPLACE__');
                proto = proto.replace(/__FUNCTIONAL__/g, data.uuid_field_key);
                proto = proto.replace(/__TOREPLACE__/g, dataName);

                // var previewHydrated = $(proto).find('#PreviewComponent'+count).append(data.html);

                $(evt.item).replaceWith(proto);

                let previewContainer = $('#card'+data.uuid_field_key).find('#PreviewComponent'+data.uuid_field_key);

                // setting up type field
                $('#card'+data.uuid_field_key+' .js-dupplicate').attr('data-type', dataName);

                // if(allowed_choice_field_types.indexOf(dataName) == -1) {
                //     $('#card'+data.uuid_field_key).find('#choices_'+data.uuid_field_key).css('display' ,'none');
                // }
                conditionalFields(dataName, allowed_choice_field_types, '#card'+data.uuid_field_key+ ' #choices_'+data.uuid_field_key);
                conditionalFields(dataName, allowed_choice_field_types, '#card'+data.uuid_field_key+ ' #selected_'+data.uuid_field_key);
                conditionalFields(dataName, allowed_for_checked, '#card'+data.uuid_field_key+ ' #checked_'+data.uuid_field_key);


                conditionalFields(dataName, not_allowed_to_classic_fields, '#card'+data.uuid_field_key+ ' #max_length_'+data.uuid_field_key, 'diff');
                conditionalFields(dataName, not_allowed_to_classic_fields, '#card'+data.uuid_field_key+ ' #value_'+data.uuid_field_key, 'diff');
                conditionalFields(dataName, not_allowed_to_classic_fields, '#card'+data.uuid_field_key+ ' #default_value_'+data.uuid_field_key, 'diff');

                previewContainer.append(data.html);

                generateBlocks(data);

                previewContainer.find('.form-control').removeAttr('name');

                Accordion_zone.trigger('arrange:fields');


                $('#card'+data.uuid_field_key).fadeIn(function() {

                })


            })
            .fail((err) => {
                console.log(err)
            })


        }
        else {
            generateSpanNoFields();
        }
    }

});
