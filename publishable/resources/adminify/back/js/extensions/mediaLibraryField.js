export default function MediaLibraryInititalization(fields) {

    function GenerateSelection(el, modal, arraySelection) {
        var sel_wrapper = el.find('.selection_wrapper');
        if (el.allow_multiple_selection == false && sel_wrapper.children().length > 0) {
            sel_wrapper.html('');
        }
        $.each(arraySelection, function (i, selectionId) {
            var the_el = modal.find('.js-select-image[data-id="' + selectionId + '"]');
            var clonedEl = the_el.parent().clone(true);
            clonedEl.find('.js-select-image')
                .removeClass('js-select-image')
                .removeClass('selected')
                .addClass('js-selection')
                .removeAttr('data-action')
                .append('<a href="#" data-id="' + selectionId + '" class="close js-clear-selection">x</a>');

            sel_wrapper.append(clonedEl);
        })
    }

    function showAndClearFieldsUpdate(object, clear, el) {

        var objectKeys = Object.keys(object);

        objectKeys.forEach(function (key) {
            let jqueryCheck = el.find('[name="' + key + '"]');

            if (jqueryCheck) {
                if (jqueryCheck.val() && clear) {
                    jqueryCheck.val('');
                } else {
                    jqueryCheck.val(object[key]);
                }


            }

        })

    }

    $.each(fields, function (i, el) {

        var dropzoneOpts = {
            url: Route('medias.store'),
            dictDefaultMessage: '',
            paramName: 'src',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            acceptedFiles: 'image/*,video/*,audio/*',
            createImageThumbnails: false,
            sending: function (file, xhr, formData) {
                /* Maybe display some more file information on your page */
                formData.append('title', file.name);
            },
            success: function (data, server) {
                console.log(server)
                if (DropzoneElm.hasClass('default-start')) {

                    $.ajax({
                        method: 'GET',
                        url: Route('modale.content', {
                            name: 'modaleMediaLibrary'
                        }),
                        success: function (data) {
                            console.log(data)
                            ModalMediaLibrary.find('.modal-body')
                                .html('')
                                .append(data.html)
                            formUpdateMediaLibrary = ModalMediaLibrary.find('form');
                            DropzoneElm = ModalMediaLibrary.find('div.dropzone');
                            DropzoneJs = DropzoneElm.dropzone(dropzoneOpts);
                        },
                        error: function (err) {
                            console.log('whoops', err);
                        }
                    })

                }
            }
        };

        var mediaLibrary_container = $(el.selector);

        var btnCallModal = mediaLibrary_container.find('.form-group > .btn-primary');

        var cibledInput = mediaLibrary_container.find(' input[type="hidden"]')
        var ModalMediaLibrary = $('#modalMediaLibrary');
        var formUpdateMediaLibrary = ModalMediaLibrary.find('form');

        var DropzoneElm = ModalMediaLibrary.find('div.dropzone');
        var TriggerDropZone = ModalMediaLibrary.find('.js-trigger-dropzone');
        var DropzoneJs = DropzoneElm.dropzone(dropzoneOpts);
        mediaLibrary_container.on('click', '.js-selection', function (e) {
            e.preventDefault();
            ModalMediaLibrary.modal('show')
        })

        mediaLibrary_container.on('click', '.js-clear-selection', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $data = $(this).attr('data-id');
            if (el.allow_multiple_selection == false) {
                cibledInput.val('');
                $(this).parent().parent().remove()
                var the_el = ModalMediaLibrary.find('.js-select-image[data-id="' + $data + '"]');
                the_el.trigger('click');

                btnCallModal.css({
                    'display': ''
                })
            } else {

            }

        })

        ModalMediaLibrary.on('click', '.js-accept', function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) {
                return false;
            }
            if (!ModalMediaLibrary.hasClass('from-quill')) {
                var $data = $(this).attr('data-selection');

                cibledInput.val($data);

                GenerateSelection(mediaLibrary_container, ModalMediaLibrary, [$data]);
                btnCallModal.css({
                    'display': 'none'
                })
            } else {
                ModalMediaLibrary.trigger('makequillcontent', ModalMediaLibrary.find('.js-select-image.selected'));
            }


            ModalMediaLibrary.modal('hide');
        })

        ModalMediaLibrary.on('click', '.js-clear', function (e) {
            e.preventDefault();
            if (!ModalMediaLibrary.hasClass('from-quill')) {
                console.log(ModalMediaLibrary)
                var selectioned = ModalMediaLibrary.find('.js-select-image.selected');
                var acceptBtn = ModalMediaLibrary.find('.js-accept');

                selectioned.removeClass('selected');
                acceptBtn.attr({
                    'disabled': 'disabled'
                })
                acceptBtn.removeAttr('data-selection')
                acceptBtn.addClass('disabled')
                formUpdateMediaLibrary.removeAttr('action')
            }
        })

        ModalMediaLibrary.on('click', '.js-select-image', function (e) {
            e.preventDefault();
            var $data = $(this).attr('data-id');
            var sel = ModalMediaLibrary.find('.js-select-image');

            var acceptBtn = ModalMediaLibrary.find('.js-accept');
            var clearBtn = ModalMediaLibrary.find('.js-clear');

            var informations = JSON.parse($(this).attr('data-informations'));

            if (el.allow_multiple_selection == false) {
                sel.not($(this)).removeClass('selected');
                $(this).toggleClass('selected');

                var hasSelection = ModalMediaLibrary.find('.js-select-image.selected');
                if (hasSelection.length > 0) {
                    acceptBtn.removeAttr('disabled').removeClass('disabled')
                    acceptBtn.attr({
                        'data-selection': $data
                    })
                    formUpdateMediaLibrary.attr({
                        'action': $(this).attr('data-action')
                    })

                    showAndClearFieldsUpdate(informations, false, formUpdateMediaLibrary)
                } else {
                    acceptBtn.attr({
                        'disabled': 'disabled'
                    })
                    acceptBtn.removeAttr('data-selection')
                    acceptBtn.addClass('disabled')
                    formUpdateMediaLibrary.removeAttr('action')

                    showAndClearFieldsUpdate(informations, true, formUpdateMediaLibrary)
                }
            } else {
                //@todo
            }

        })



        ModalMediaLibrary.on('click', '.close', function (e) {

            var sel = ModalMediaLibrary.find('.js-select-image.selected');
            sel.trigger('click')

        })

        ModalMediaLibrary.on('blur', '.form-control', function (e) {
            if (formUpdateMediaLibrary.get(0).hasAttribute('action') === false) {
                return false;
            }

            let datas = formUpdateMediaLibrary.serializeFormJSON();

            $.ajax({
                method: 'POST',
                url: formUpdateMediaLibrary.attr('action'),
                data: datas,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    //console.log(data)
                    $('.js-select-image[data-id="' + data.media.id + '"]').attr({
                        'data-informations': JSON.stringify(data.media)
                    })
                },
                error: function (err) {
                    console.log('whoops', err)
                }
            })

        })


        if (el.autoremove != null && el.autoremove) {
            cibledInput.off();


            ModalMediaLibrary.on('hidden.bs.modal', function (e) {
                ModalMediaLibrary.off();
            mediaLibrary_container.off();
            formUpdateMediaLibrary.off();
            btnCallModal.off();
                    $(this).remove();

            })
        }

        if (cibledInput.val() > 0) {
            let selected = ModalMediaLibrary.find('.js-select-image[data-id="' + cibledInput.val() + '"]');
            console.log(selected)
            selected.trigger('click');
            ModalMediaLibrary.find('.js-accept').trigger('click');
            // GenerateSelection(mediaLibrary_container, ModalMediaLibrary, [ cibledInput.val() ]);
        }


        btnCallModal.on('click', function (e) {
            e.preventDefault();
            console.log('')
            if(el.callBy && el.callBy == 'ajax') {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                    method: 'GET',
                    url: Route('modale.getModale', {
                        name: 'modaleMediaLibrary'
                    }),
                    success: function(data) {
                        console.log('data', data)
                        $('body').append(data.html);
                        ModalMediaLibrary = $('#modalMediaLibrary');
                        formUpdateMediaLibrary = ModalMediaLibrary.find('form');
                        formUpdateMediaLibrary.removeAttr('action')
                        ModalMediaLibrary.modal('show');

                    },
                    error: function(err) {
                        console.log('err', err)
                    }
                })
            }
            else {
                formUpdateMediaLibrary.removeAttr('action')
                ModalMediaLibrary.modal('show');
            }
        })

        TriggerDropZone.on('click', function (e) {
            e.preventDefault();
            $(DropzoneElm).trigger('click')
        })
    })


}
