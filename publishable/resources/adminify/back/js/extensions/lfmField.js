import { get } from 'sortablejs';

const getMime = require('name2mime');

export default function LFMField(fields) {

    let selectedItems = [];

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

    function formatSourcesEntries(arraySelection) {
        var $sel = [];

        $.each(arraySelection, function (i, selection) {

            $sel.push({
                'name' : selection.name,
                'file' : {
                    'type': getMime(selection.name)
                }
            });
        })
        return $sel
    }

    function requestMedia($selecteds, callback) {

        let o = {};

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

    function findIndexFromName(ifr, json) {
        let $id = null;
        $.each(ifr[0].contentWindow.items, function(i, item) {
            if(item.name == json[0].name) {
                $id = i;
                return false;
            }
        })
        return $id;
    }

    

    $.each(fields, function(i, el) {
        let $el_wrapper = $('#'+el.selector);
        let $el = $('#'+el.selector +' [type="button"]');
        let modale = $('#modalFileManager');
        let ifr = modale.find('iframe');
        let $hidden = $el_wrapper.find('[type="hidden"]');
        let confirm = ifr.contents().find('#actions a[data-action="use"]');

        function updateFieldProcess() {
            selectedItems = getSelection(ifr);
            GenerateSelection($el_wrapper, selectedItems);
            console.log(selectedItems);
            if(selectedItems.length > 0) {
                requestMedia(selectedItems, function(err, d) {
                    if(err != null) {
                        console.log('whoops', err);
                        return false;
                    }
                    console.log('d', d);
                    if(d.models.length > 0) {
                        $hidden.val(d.models[0].id);
                    }
                    else {
                        $hidden.val(0);
                    }
    
                    modale.modal('hide');
                })
            }
        }

        $(document).on('click', '.js-clear-selection', function(e) {
            e.preventDefault();
            $('.js-selection').remove();
            $hidden.val(0);

            $el.css({
                'display': ''
            });

        })

        $(document).on('click', '.js-selection', function(e) {
            e.preventDefault();
            modale.modal('show');
        });

        $(ifr.contents()).on('click', '#actions a[data-action="use"]', function() {
            updateFieldProcess();
            $el.css({
                'display': 'none'
            });
        })

        $el.on('click', function(e) {
            e.preventDefault();
            modale.modal('show')
            if(selectedItems.length > 0) {
                updateStyle(ifr);
            }
        })

        modale.on('show.bs.modal', function(e) {
            if($hidden.val().length > 0 && $hidden.val() != '0') {
                selectedItems[0].id = findIndexFromName(ifr, JSON.parse($hidden.val()))
                updateStyle(ifr);
            }
        })
    })
}
