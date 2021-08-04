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

        if($hidden.val().length > 0 && $hidden.val() != '0') {
            let fieldList = [
                {
                    name : $hidden.val(),
                    'file' : {
                        'type': getMime($hidden.val())
                    },
                    url : $hidden.attr('data-path')
                }
            ];
            let json = formatSourcesEntries(fieldList);
            $hidden.val(JSON.stringify(json));
            selectedItems = fieldList
            GenerateSelection($el_wrapper, selectedItems);
        }

        $el.on('click', function(e) {
            e.preventDefault();
            modale.modal('show')
            if(selectedItems.length > 0) {
                updateStyle(ifr)
            }
            // window.filemanager();
            confirm = ifr.contents().find('#actions a[data-action="use"]');
            confirm.on('click', function(e) {
                selectedItems = getSelection(ifr);
                GenerateSelection($el_wrapper, selectedItems);
                let json = formatSourcesEntries(selectedItems);
                $hidden.val(JSON.stringify(json));
                modale.modal('hide')
            })

        })

        modale.on('show.bs.modal', function(e) {
            if($hidden.val().length > 0 && $hidden.val() != '0') {
                selectedItems[0].id = findIndexFromName(ifr, JSON.parse($hidden.val()))
                updateStyle(ifr)
            }
        })
    })
}