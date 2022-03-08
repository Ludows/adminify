jQuery(document).ready(function ($) {
    console.log('hello from metas !')
    $('.js-conditions-block-or > .form-group').remove();
    handleButtonsRemove($('.js-conditions-block'))

    $(document).on('click', '.js-add-prototype', function(e) {
        e.preventDefault();

        let d = $(this).attr('data-prototype');
        let triggerBlock = $('.js-conditions-block');
        let length = triggerBlock.find(' > .form-group').length
        d = d.replace(/__NAME__/g, length);

        triggerBlock.append(d);

        handleButtonsRemove($('.js-conditions-block'))
    })

    $(document).on('click', '.js-add-prototype-or', function(e) {
        e.preventDefault();

        let d = $(this).attr('data-prototype');
        let triggerBlock = $('.js-conditions-block-or');
        let length = triggerBlock.find(' > .form-group').length
        d = d.replace(/__NAME__/g, length);

        triggerBlock.append(d);

        handleButtonsRemove($('.js-conditions-block-or'))
    })

    $(document).on('click', '.js-remove-prototype', function(e) {
        e.preventDefault();

        $(this).parent().remove();

        makeTri($('.js-conditions-block'));

        handleButtonsRemove($('.js-conditions-block'))
    })


    $(document).on('change', '.js-typed-data', function(e) {
        let data = $(this).val();

        // console.log('data', data)

        let o = formatObjectSearch($(this), data)

        // console.log('o',o)

        if(o.SendToAjax) {
            makeSearch(o, (err, data) => {
                if(err) {
                    console.log('whoops', err)
                    return false;
                }

                console.log(data.models instanceof Array);

                if(data.models instanceof Array) {
                    console.log('todo the formater')
                }


                hydrateSelect2( $(this).parent().parent().parent().find('select').last(), data.models, data.labelToShow ?? 'title');

                // console.log(data)
            })
        }

    })

    function handleButtonsRemove(jQuerySelector) {
        let childs = jQuerySelector.children('.form-group');

        if(childs.length > 1) {
            jQuerySelector.find('.js-remove-prototype').removeClass('d-none');
        }
        else {
            jQuerySelector.find('.js-remove-prototype').addClass('d-none');
        }
    }

    function makeTri(jQuerySelector) {

        let childs = jQuerySelector.children('.form-group');

        $.each(childs, function(i, child) {

            let inputs = $(child).find('select');

            $.each(inputs, (k, input) => {

                let inp = $(input);
                let lbl =  inp.prev();
                let lbl_for = lbl.attr('for');
                let inp_name = inp.attr('name');
                let inp_id = inp.attr('id');
                lbl_for = lbl_for.replace(/\[\d+\]/g, '['+ i +']');
                inp_name = inp_name.replace(/\[\d+\]/g, '['+ i +']');
                inp_id = inp_id.replace(/\[\d+\]/g, '['+ i +']');

                lbl.attr('for', lbl_for);
                inp.attr('name', inp_name);
                inp.attr('id', inp_id);
            })


        })
    }


    function hydrateSelect2(JquerySelector, datas, LabelToShow = 'title') {

        // Prevent unwanted options
        JquerySelector.children().remove();
        let isArrayCollection = Array.isArray(datas);
        console.log('datas hydrateSelect2', datas);
        $.each(datas, (key, value) => {

            var data = {
                id:  !isArrayCollection ? key : value.id,
                text: !isArrayCollection ? value : value[LabelToShow]
            };

            var newOption = new Option(data.text, data.id, false, false);
            JquerySelector.append(newOption).trigger('change');
        })

    }

    // $(document).on('change', '.js-select-value', function(e) {
    //     let parent = $(this).parent().parent().parent()
    //     let sel = parent.find('select').first();
    //     sel.trigger('change');
    // })

    function formatObjectSearch(jQuerySelector, data) {
        let o = {};

        o.data = {};
        o.SendToAjax = true;

        // console.log('jQuerySelector', jQuerySelector)
        // console.log('hasClass js-typed-data', jQuerySelector.hasClass('js-typed-data'))

        let parent = jQuerySelector.parent().parent().parent()
        let trigger = null;

        if(jQuerySelector.hasClass('js-typed-data') == true) {
            trigger = parent.find('select').last()
        }
        else {
            trigger = parent.find('select').first()
        }

        if(data == 'content_type_model') {
            o.url = Route('finder.contentTypes', {});
        }
        else {

            let theVal = jQuerySelector.val();
            theVal = theVal.replace('model:', '').trim()

            o.url = Route('finder', {
                type: theVal
            });
        }

        return o;
    }

    function makeSearch(object, callback) {

        // console.log('selecteds', selecteds);

        $.ajax({
            method: 'POST',
            url: object.url,
            data: object.data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (typeof callback == 'function') {
                    callback(null, data);
                }
            },
            error: function (err) {
                // console.log('whoops', err);
                if (typeof callback == 'function') {
                    callback(err, null);
                }
            }
        })

    }
});
