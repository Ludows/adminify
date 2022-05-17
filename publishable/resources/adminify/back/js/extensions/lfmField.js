export default function LFMField(fields) {

    let selectedItems = [];
    let fields_id = window.siteSettings.medias.prefers_id_on;

    function getParamFromIframe(ifrUrl, name) {
        return (ifrUrl.split(name + '=')[1] || '').split('&')[0];
    }

    function GenerateSelection(el, arraySelection) {
        var sel_wrapper = el.find('.row-selection');
        sel_wrapper.html('');

        let count = arraySelection.length;
        let class_to_apply = 'col-12 js-selection';
        if(count > 1) {
            class_to_apply = 'js-selection col-12 '+' col-lg-'+ (12 / count);
        }

        $.each(arraySelection, function (i, selection) {
            let tpl = `
                <div class="${class_to_apply}">
                    <img class="img-fluid" src="${selection.url}" alt="${selection.name}" />
                    <span class="clear-selection js-clear-selection">x</span>
                </div>
            `;
            sel_wrapper.append(tpl);
        })
    }

    function requestMedia(selecteds, callback) {

        // console.log('selecteds', selecteds);

        let o = {};

        selecteds.forEach((selected) => {
            o['src'] = selected.name;

            $.ajax({
                method: 'POST',
                url: Route('finder', { type : 'medias' }),
                data: o,
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    if(typeof callback == 'function') {
                        callback(null, data);
                    }
                },
                error: function(err) {
                    console.log('whoops', err);
                    if(typeof callback == 'function') {
                        callback(err, null);
                    }
                }
            })
        })


    }

    function getIndexFromLfm(ifr , name) {
        let realIndex = 0;
        let itemsHtml = ifr.contents().find('#content > a');
        $.each(itemsHtml, function(i, it) {
            if(name == $(it).find(".info .item_name").text()) {
                realIndex = parseInt($(it).attr('data-id'));
                return false;
            }
        })

        return realIndex;
    }

    function getSelection(ifr) {
        let items = ifr[0].contentWindow.getSelectedItems();
        let itemsHtml = ifr.contents().find('#content > a');
        items.forEach(item => {
            // if(item.name == )
            $.each(itemsHtml, function(i, it) {
                if(item.name == $(it).find(".info .item_name").text()) {
                    item.id = parseInt($(it).attr('data-id'))
                }
            })
        });
        // console.log(items);
        return items;
    }

    function updateStyle(ifr) {
        selectedItems.forEach(function (item, index) {
          let $it = $(ifr).contents().find('[data-id=' + item.id + ']')
          let $square = $it.find('.square');

          $square.hasClass('selected') ? $($square).removeClass('selected') : $($square).addClass('selected');
          $square.trigger('click');


        });
        ifr[0].contentWindow.toggleActions();
    }

    function findIndexFromName(ifr, strName) {
        let $id = null;
        $.each(ifr[0].contentWindow.items, function(i, item) {
            if(item.name == strName) {
                $id = i;
                return false;
            }
        })
        return $id;
    }

    function generateListenersIframe(ifr, datas = {}) {
        let ifr_content = ifr.contents();

        let multiple = ifr_content.find('#multi_selection_toggle');

        // console.log('options', datas.option);
        if(datas.option.multiple == false) {
            multiple.css({
                'display': 'none'
            });
        }

        $(ifr_content).on('click', '#actions a[data-action="use"]', function() {
            console.log(datas)
            updateFieldProcess(datas);
        })
    }

    function loadListenersModale(modale, datas = {}) {
        modale.on('show.bs.modal', function(e) {
            let ifr = modale.find('iframe');
            if(selectedItems.length == 0) {
                let $id = getIndexFromLfm( ifr,  datas.hidden.attr('data-src') );

                selectedItems = [
                    {
                        id : $id,
                    }
                ];
            }
            if(datas.hidden.val().length > 0) {
                selectedItems[0].id = findIndexFromName(ifr, fields_id.indexOf(datas.hidden.attr('name')) ? datas.hidden.attr('data-src') :  datas.hidden.val())
                updateStyle(ifr);
            }
        })
    }

    function updateFieldProcess(ObjectInterface) {

        selectedItems = getSelection(ObjectInterface.ifr);
        // console.log('TEST>>', ObjectInterface)

        if(!ObjectInterface.option.disable_selection_preview) {
            GenerateSelection(ObjectInterface.el_wrapper, selectedItems);
        }
        if(selectedItems.length > 0 && ObjectInterface.fromMediaEntity == 0) {
            requestMedia(selectedItems, function(err, d) {
                if(err != null) {
                    console.log('whoops', err);
                    return false;
                }
                if(d.models.length > 0) {
                    if(ObjectInterface.option.multiple) {
                        console.log('a 1')

                        let ValueInput = ObjectInterface.hidden.val().split(', ').filter(n => n);
                        let m = d.models[0];

                        console.log(ValueInput);

                        fields_id.indexOf(ObjectInterface.hidden.attr('name')) > -1 ? ValueInput.push(m.id) : ValueInput.push(m.src);
                        // $.each(d.models, function(i, m) {
                        //     fields_id.indexOf(ObjectInterface.hidden.attr('name')) > -1 ? values.push(m.id) : values.push(m.src);
                        // });

                        console.log(ValueInput);

                        ObjectInterface.hidden.val( ValueInput.join(', ') );

                    }
                    else {
                        // console.log('a 2')
                        fields_id.indexOf(ObjectInterface.hidden.attr('name')) > -1 ? ObjectInterface.hidden.val(d.models[0].id) : ObjectInterface.hidden.val(d.models[0].src);
                    }
                }
                else {
                    // console.log('b')
                    // by defaults fallback to current name and mime type
                    selectedItems.forEach((sel) => {
                        ObjectInterface.hidden.val(sel.name);
                    })
                }
            })
        }
        else {
            // console.log('c')

            selectedItems.forEach((sel) => {
                ObjectInterface.hidden.val(sel.name);
            })
        }

        ObjectInterface.hidden.trigger('change');
        ObjectInterface.el.css({
            'display': 'none'
        });

        if(selectedItems.length > 0) {
            ObjectInterface.hidden.trigger('lfm:shareSelectedItems', {
                items : selectedItems
            });
        }

        ObjectInterface.modale.modal('hide');
    }

    function callJajax(ObjectInterface, callback) {
        $.ajax({
            'method': ObjectInterface.method,
            url: ObjectInterface.route,
            data: ObjectInterface.values,
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



    $.each(fields, function(i, el) {
        let $el_wrapper = $('#'+el.selector);
        let $el = $('#'+el.selector +' [type="button"]');
        let $hidden = $el_wrapper.find('[type="hidden"]');

        if($hidden.val().length > 0) {

            if(!el.options.disable_selection_preview) {
                GenerateSelection($el_wrapper, [
                    {
                        url : $hidden.attr('data-path'),
                        name: $hidden.val()
                    }
                ]);

                $el.css({
                    'display': 'none'
                });
            }

        }

        $($el_wrapper).on('click', '.js-clear-selection', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $($el_wrapper).find('.js-selection').remove();
            $hidden.val(null);
            $hidden.trigger('change');

            $el.css({
                'display': ''
            });

        })



        $($el_wrapper).on('click', '.js-selection', function(e) {
            e.preventDefault();
            $el.trigger('click');
        });

        $el.on('click', function(e) {
            e.preventDefault();
            // $(this).prop('disabled', 'disabled');

                callJajax({
                    'method' : 'POST',
                    'route' : Route('content.ajax'),
                    'values' : {
                        'view_name' : 'adminify::layouts.admin.modales.modaleFileManager',
                        'view_vars' : {
                            "tata": 'toto'
                        }
                    }
                }, function(err, datas) {

                    if(err != null) {
                        throw new Error(err);
                    }

                    let modale = $(datas.html);
                    let modaleId = modale.attr('id');
                    $('body').append(modale);

                    // console.log('modaleId', modaleId)

                    console.log('modale', modale)
                    let ifr = modale.find('iframe');

                    ifr.get(0).addEventListener('load', function(e) {
                        console.log('iframe loaded');

                        generateListenersIframe(ifr, {
                            ifr : ifr,
                            el_wrapper : $el_wrapper,
                            fromMediaEntity : getParamFromIframe(ifr.attr('src'), 'fromMediaCreate'),
                            hidden : $hidden,
                            modale : modale,
                            el : $el,
                            option : el.options
                        });

                        loadListenersModale(modale, {
                            hidden : $hidden
                        })

                        modale.modal('show')

                        modale.on('hidden.bs.modal', function(e) {
                            modale.remove();
                        })


                    })

                })

        })
    })
}
