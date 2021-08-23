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

    const deleteMenuBtn = menuBuilder.find('#deleteMenuBtn');
    const deleteMenuForm = menuBuilder.find('#deleteMenu');

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


    deleteMenuBtn.on('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Voulez vous supprimer ce menu ? @trad",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui @trad'
        }).then((result) => {
            if (result.value) {

                let routeRedirect = Route('menus.index');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: deleteMenuForm.attr('method'),
                    url: deleteMenuForm.attr('action'),
                    data: {
                        '_method': 'DELETE'
                    },
                    success: function (data) {
                        console.log(data)
                        window.location.href = routeRedirect;
                    },
                    error: function (err) {
                        console.log('err', err)
                    }
                })


                
            }
        })

    })


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
                let htmlLis = data.html;

                $.each(htmlLis, function (i, htmlLi) {
                    $(sortableElement).append(htmlLi);

                    let nested_sortable = $(htmlLi).find('.nested_sortable').attr('id');
                    let el_id_sortable = document.getElementById(nested_sortable);
                    // console.log(el_id_sortable);
                    createSortable(el_id_sortable);
                    
                    let call_media = $(htmlLi).find('.call_media');
                    lfmInitFunction([{
                        selector: call_media.attr('id'),
                    }]);


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
        let self = $(this);
        let check = $('#' + $data_el).find('[menu-three-key="delete"]');
        if (parseInt(check.val()) === 1) {
            // is new , no records in db here
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

                    let removeRoute = Route('menus.removeItemsToMenu', {
                        id: self.attr('data-menuitem-id')
                    });

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: removeRoute,
                        data: {},
                        success: function (data) {
                            console.log(data)
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            $('#' + $data_el).remove();
                        },
                        error: function (err) {
                            console.log('err', err)
                        }
                    })


                    
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


    menuSwitcherSubmit.on('click', function(e) {
        e.preventDefault();

        menuSwitcher.get(0).reset();

        menuSwitcher.submit();
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
})
