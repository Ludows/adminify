import Sortable, {
    MultiDrag,
    Swap
} from 'sortablejs';
import swal from 'sweetalert2';

jQuery(document).ready(function ($) {
    const menuBuilder = $('#menuBuilder');
    const menuSwitcher = menuBuilder.find('.menu-switcher-area form');
    const menuSwitcherSubmit = menuSwitcher.find('button[type="submit"]');
    const sidebarForms = menuBuilder.find('.sidebar-area form');
    const FormMenuThree = menuBuilder.find('.menu-three-area form').first();
    const NestedLists = menuBuilder.find('.nested_sortable');

    menuSwitcher.attr('action', '');
    menuSwitcherSubmit.attr('disabled', 'disabled');
    sidebarForms.find('button[type="submit"]').attr('disabled', 'disabled')


    var sortableElement = document.getElementById('sortable');
    var sortable = createSortable(sortableElement);

    if (NestedLists.length > 0) {
        $.each(NestedLists, function (i, NestedList) {
            let id_n = document.getElementById($(NestedList).attr('id'));
            let n_sortable = createSortable(id_n);
        })
    }



    FormMenuThree.on('click', 'button[type="submit"]', function (e) {
        e.preventDefault();
        let menuThree = $(sortableElement).first().menuThree();
        console.log(menuThree);
        $('input[name="menuthree"]').val(JSON.stringify(menuThree));
        // console.log($(this))
        $($(this).get(0).form).submit()
    })

    FormMenuThree.on('blur keyup', '.js-change-title', function (e) {
        e.preventDefault();
        let v = $(this).val();
        let ds = $(this).attr('data-sel');
        if (v.length > 0) {
            $(ds).text(v);
        } else {
            $(ds).text($(ds).attr('data-replace'));
        }
    })

    // call_media = $(htmlLi).find('.call_media');

    function createSortable(element, opts = {}) {

        let defaults = {
            invertSwap: true,
            group: 'nested',
            fallbackOnBody: false,
            animation: 150,
            // filter: ".nested_sortable",
            swapThreshold: 0.65,
            dragoverBubble: true,
            handle: ".handle",
            onStart: function (evt) {
                $('.nested_sortable').css({
                    'border-color': 'blue',
                    'border-style': 'dashed',
                    'height': '50px'
                })
            },
            onEnd: function ( /**Event*/ evt) {
                console.log(evt)
                console.log(evt.oldIndex, evt.newIndex)
                $('.nested_sortable').css({
                    'border-color': 'transparent',
                    'height': ''
                })
            },
        }

        return Sortable.create(element, {
            ...defaults,
            ...opts
        })
    }

    sidebarForms.on('change', 'input, select', function (e) {
        let btnSubmit = $($(this).get(0).form).find('button[type="submit"]');
        let formHTMLNative = $(this).get(0).form;
        let dataType = $(formHTMLNative).attr('data-type-form');
        if (dataType != 'custom') {
            let haveChecked = $(formHTMLNative).find('.form-control option:selected');
            if (haveChecked.length > 0) {
                btnSubmit.removeAttr('disabled');
            } else {
                btnSubmit.prop('disabled', true);
            }
        } else {
            let hasAnyVal = false;
            let serializeForm = $(formHTMLNative).serializeFormJSON();
            let serializeFormObjectKeys = Object.keys(serializeForm);
            $.each(serializeFormObjectKeys, function (i, val) {
                // console.log(val)
                if (val != '_token' && hasAnyVal == false) {
                    serializeForm[val].length > 0 ? hasAnyVal = true : hasAnyVal = false;
                }
            })

            if (hasAnyVal) {
                btnSubmit.removeAttr('disabled');
            } else {
                btnSubmit.prop('disabled', true);
            }

        }

    })

    sidebarForms.on('click', 'button[type="submit"]', function (e) {
        e.preventDefault();
        let the_form = $(this).get(0).form;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: $(the_form).attr('method'),
            url: $(the_form).attr('action'),
            data: $(the_form).serializeFormJSON(),
            success: function (data) {
                console.log(data)
                let htmlLis = generateLiSortableElements(data);

                $.each(htmlLis, function (i, htmlLi) {
                    $(sortableElement).append(htmlLi);

                    let nested_sortable = $(htmlLi).find('.nested_sortable').attr('id');
                    let el_id_sortable = document.getElementById(nested_sortable);
                    // console.log(el_id_sortable);
                    createSortable(el_id_sortable);


                    $(the_form).find('.select2-hidden-accessible').val(null).trigger('change');
                });
                if (data.type == 'custom') {
                    $(the_form).clearValues();
                }



                // MediaLibraryInitFunction(call_media);
            },
            error: function (err) {
                console.log('err', err)
            }
        })
    })

    menuBuilder.on('click', '.js-suppress', function (e) {
        e.preventDefault();
        let $data_el = $(this).attr('data-el');
        let check = $('#' + $data_el).find('[menu-three-key="delete"]');
        if (check.length === 0) {
            $('#' + $data_el).remove();
        } else {
            // swal(
            Swal.fire({
                title: 'Are you sure?',
                text: "Voulez vous supprimer cet item ? @trad",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui @trad'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    $('#' + $data_el).css({'display': 'none'});
                    check.val(1);
                }
            })
        }

    })

    menuBuilder.on('click', '.js-close', function (e) {
        e.preventDefault();
        let $data_el = $(this).attr('data-el');
        $('#' + $data_el).collapse('hide');
    })

    menuBuilder.on('click', '.handle-click-collapse', function (e) {
        e.preventDefault();
        let li = $(this).parent();
        let $data_el = li.attr('data-target');
        let collapseEl = $($data_el);

        collapseEl.collapse(collapseEl.is(':visible') ? 'hide' : 'show');
    })

    menuSwitcher.on('change', '.form-control', function (e) {
        let valueSel = $(this).val();
        let editRoute = '';
        menuSwitcherSubmit.attr('disabled', 'disabled');
        if (parseInt(valueSel) != 0) {
            editRoute = Route('menus.edit', {
                menu: $(this).val()
            })
            menuSwitcherSubmit.removeAttr('disabled');
        }

        menuSwitcher.attr('action', editRoute);
    })

    function PasswordGenerator() {
        return Math.random().toString(36).slice(2);
    }

    function generateLiSortableElements(datas = []) {
        let htmls = [];
        let lang = $('html').attr('lang');
        $.each(datas.items, function (i, item) {
            let identifier = 'list-group-item-' + PasswordGenerator();
            let html = `<li class="list-group-item" id="${identifier}" data-target="#collapse-${datas.multilang && datas.type != 'custom' ? item.slug[lang] : item.slug}" aria-expanded="false" aria-controls="collapse-${datas.multilang && datas.type != 'custom' ? item.slug[lang] : item.slug}">
                        <span data-replace="${datas.multilang && datas.type != 'custom' ? item.title[lang] : item.title}" class="handle handle-click-collapse d-block">${datas.multilang && datas.type != 'custom' ? item.title[lang] : item.title}</span>
                        <div class="collapse js-collapse" id="collapse-${datas.multilang && datas.type != 'custom' ? item.slug[lang] : item.slug}">
                            <div class="card card-body">
                                ${ item.id ? '<input type="hidden" menu-three-key="id" value="'+ item.id +'"/>': ''}
                                <input type="hidden" menu-three-key="type" value="${datas.type}"/>
                                <input type="hidden" menu-three-key="title" value="${datas.multilang && datas.type != 'custom' ? item.title[lang] : item.title}"/>
                                <input type="hidden" menu-three-key="slug" value="${datas.multilang && datas.type != 'custom' ? item.slug[lang] : item.slug}"/>
                                <div class="form-group">
                                    <label for="title_nav_${identifier}">Titre de navigation @todo trad</label>
                                    <input type="text" menu-three-key="overwrite_title" data-sel="#${identifier} .handle-click-collapse" value="${datas.type == 'custom' ? item.title : ''}" class="form-control js-change-title" id="title_nav_${identifier}">
                                </div>
                                <div class="call_media" id="media-${identifier}">
                                    <div class="row row-selection"></div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary">Call Media @trad</button>
                                        <input type="hidden" menu-three-key="media_src" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input ${datas.type == 'custom' && item.open_new_tab ? 'checked="checked"' : ''} menu-three-key="open_new_tab" class="form-check-input" type="checkbox" value="" id="openOnglet_${identifier}">
                                        <label class="form-check-label" for="openOnglet_${identifier}">
                                            Ouvrir dans un autre onglet ? @trad
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="classes_${identifier}">Classes @todo trad</label>
                                    <input menu-three-key="class" type="text" class="form-control" id="classes_${identifier}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="#" data-el="${identifier}" class="text-underline js-suppress text-danger">Supprimer @trad</a>
                                <a href="#" data-el="collapse-${datas.multilang && datas.type != 'custom' ? item.slug[lang] : item.slug}" class="text-underline js-close text-default">Fermer @trad</a>
                            </div>
                        </div>
                        <div style="width:80%; border: 1px solid transparent;" id="nested-sortable-${identifier}" class="nested_sortable list-group"></div>
                    </li>
                    <script>
                        lfmInitFunction([{
                            selector: "media-${identifier}",
                            options: [],
                            multilang: ${datas.multilang},
                            currentLang: '${lang}'
                        }]);
                    </script>

                    `;
            htmls.push(html);
        })

        return htmls;
    }
})
