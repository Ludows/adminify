let defaults = {
    allow_multiple_selection: false,
    multilang: $('html').attr('lang') ? true : false,
    currentLang: $('html').attr('lang'),
    autoremove: false,
    callBy: 'ajax',
    callUrl: Route('modale.getModale', {
        name: 'modaleMediaLibrary'
    }),
    contextListener: window,
    modalId: '#modalMediaLibrary'
}
export default class MediaLibraryAbstract {
    constructor(options = {}) {
        this.options = {
            ...defaults,
            ...options
        };
        this.ModalBinded = false;
        this.hooks = {
            init: function (instance) {},
            addSelection: function (instance) {},
            removeSelection: function (instance) {},
            select: function (instance) {}
        }
        this.generateModalSetup();
        this.start();
    }
    generateModalSetup() {
        let options = this.getOptions();
        let localSetup = {
            form: `${options.modalId} form`,
            formInputs: `${options.modalId} form .form-control`,
            dropzone: `${options.modalId} div.dropzone`,
            triggerDropzone: `${options.modalId} .js-trigger-dropzone`,
            btnCall: '.btn-primary',
            selection : '.js-selection',
            clearSelection: '.js-clear-selection',
            selWrapper: '.selection_wrapper',
            mediaSelectionInput: 'input[type="hidden"]',
            acceptModal: `${options.modalId} .js-accept`,
            declineModal: `${options.modalId} .js-clear`,
            selectImage: `${options.modalId} .js-select-image`,
            closeModal: `${options.modalId} .close`

        };
        this.options.setup = {...localSetup, ...options.setup}
        return this;
    }
    getOptions() {
        return this.options;
    }
    getModalId() {
        return this.options.ModalId;
    }
    setModalActivate(boolean = false) {
        this.ModalBinded = boolean;
        return this;
    }
    makeDropzone() {
        let options = this.getOptions();

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
                if ($(options.setup.dropzone).hasClass('default-start')) {

                    $.ajax({
                        method: 'GET',
                        url: Route('modale.content', {
                            name: 'modaleMediaLibrary'
                        }),
                        success: function (data) {
                            console.log(data)
                            $(options.modalId).find('.modal-body')
                                .html('')
                                .append(data.html)
                        },
                        error: function (err) {
                            console.log('whoops', err);
                        }
                    })

                }
            }
        };

        this.dropzone = $(options.setup.dropzone).dropzone(dropzoneOpts);
    }
    setModalListeners() {
        let options = this.getOptions();
        let self = this;

        $('body').on('click', options.setup.acceptModal, function (e) {
            e.preventDefault();
            if ($(this).hasClass('disabled')) {
                return false;
            }
            if (!$(options.modalId).hasClass('from-quill')) {
                var $data = $(this).attr('data-selection');

                $( options.setup.mediaSelectionInput ).val($data);

                self.generateSelection([$data]);
                $(options.contextListener).find(options.setup.btnCall).css({
                    'display': 'none'
                })
            } else {
                $(options.modalId).trigger('makequillcontent', $(options.modalId).find('.js-select-image.selected'));
            }


            $(options.modalId).modal('hide');
        })

        $('body').on('click', options.setup.declineModal, function (e) {
            e.preventDefault();
            if (!$(options.modalId).hasClass('from-quill')) {
                var selectioned = $(options.modalId).find('.js-select-image.selected');
                var acceptBtn = $(options.modalId).find('.js-accept');

                selectioned.removeClass('selected');
                $(options.setup.acceptModal).attr({
                    'disabled': 'disabled'
                })
                $(options.setup.acceptModal).removeAttr('data-selection')
                $(options.setup.acceptModal).addClass('disabled')
                $(options.setup.form).removeAttr('action')
            }
        })

        $('body').on('click', options.setup.selectImage, function (e) {
            e.preventDefault();
            var $data = $(this).attr('data-id');
            var sel = $(options.modalId).find('.js-select-image');

            var acceptBtn = $(options.modalId).find('.js-accept');
            var clearBtn = $(options.modalId).find('.js-clear');

            var informations = JSON.parse($(this).attr('data-informations'));

            if (options.allow_multiple_selection == false) {
                sel.not($(this)).removeClass('selected');
                $(this).toggleClass('selected');

                var hasSelection = $(options.modalId).find('.js-select-image.selected');
                if (hasSelection.length > 0) {
                    acceptBtn.removeAttr('disabled').removeClass('disabled')
                    acceptBtn.attr({
                        'data-selection': $data
                    })
                    $(options.setup.form).attr({
                        'action': $(this).attr('data-action')
                    })

                    self.showAndClearFieldsUpdate(informations, false)
                } else {
                    acceptBtn.attr({
                        'disabled': 'disabled'
                    })
                    acceptBtn.removeAttr('data-selection')
                    acceptBtn.addClass('disabled')
                    $(options.setup.form).removeAttr('action')

                    self.showAndClearFieldsUpdate(informations, true)
                }
            } else {
                //@todo
            }

        })

        $('body').on('click', options.setup.closeModal, function (e) {
            var sel = $(options.modalId).find('.js-select-image.selected');
            sel.trigger('click')
        })

        $('body').on('blur',  options.setup.formInputs, function (e) {
            if (  $(options.setup.form).get(0).hasAttribute('action') === false) {
                return false;
            }

            let datas = $(options.setup.form).serializeFormJSON();

            self.performRequest({
                method: 'POST',
                url: $(options.setup.form).attr('action'),
                data: datas,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }, function (err, data) {
                if (err != null) {
                    throw new Error(err);
                }

                $('.js-select-image[data-id="' + data.media.id + '"]').attr({
                    'data-informations': JSON.stringify(data.media)
                })

            })
        })

        if (options.autoremove != null && options.autoremove) {

            $(document).on('hidden.bs.modal', options.modalId ,function (e) {
                // self.dropzone.disable();
                let dropjs = Dropzone.forElement(self.dropzone.get(0));
                $(dropjs.hiddenFileInput).remove()
                $(this).remove();
            })
        }

        $('body').on('click', options.setup.triggerDropzone, function (e) {
            e.preventDefault();
            $(options.setup.dropzone).trigger('click')
        })
    }
    generateSelection(arraySelection) {
        let options = this.getOptions();
        var sel_wrapper = $(options.contextListener).find(options.setup.selWrapper);
        if (options.allow_multiple_selection == false && sel_wrapper.children().length > 0) {
            sel_wrapper.html('');
        }
        $.each(arraySelection, function (i, selectionId) {
            var the_el = $(options.modalId).find('.js-select-image[data-id="' + selectionId + '"]');
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
    showAndClearFieldsUpdate(object ,clear) {
        let objectKeys = Object.keys(object);
        let options = this.getOptions();
        let el = $(options.setup.form);

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
    performRequest(options = {}, callback) {
        $.ajax(options)
            .done(function (data) {
                callback(null, data)
            })
            .fail(function (err) {
                callback(err, null)
            })
        return this;
    }
    setListeners() {
        let self = this;
        let options = this.getOptions();


        $(options.contextListener).on('click', options.setup.btnCall, function (e) {
            e.preventDefault();

            if (options.callBy == "ajax") {
                self.performRequest({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'GET',
                    url: options.callUrl,
                }, function (err, data) {
                    if (err != null) {
                        throw new Error(err);
                    }

                    $('body').append(data.html);


                    setTimeout(() => {
                        $(options.setup.form).removeAttr('action')
                        self.makeDropzone();
                        $(options.modalId).modal('show');
                    }, 200)

                })
            } else {
                $(options.setup.form).removeAttr('action')
                self.makeDropzone();
                $(options.modalId).modal('show');
            }

        })

        $(options.contextListener).on('click', options.setup.selection, function (e) {
            e.preventDefault();
            if (options.callBy == "ajax") {
                let $btnCall = $(options.contextListener).find(options.setup.btnCall);
                $btnCall.trigger('click');
                setTimeout(() => {
                    $(options.modalId).find('.js-select-image[data-id="' + $btnCall.attr('data-id') + '"]').trigger('click')
                }, 300)

            }
            else {
                $(options.modalId).modal('show')
            }
        })

        $(options.contextListener).on('click', options.setup.clearSelection, function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $data = $(this).attr('data-id');
            if (options.allow_multiple_selection == false) {
                $(options.contextListener).find( options.setup.mediaSelectionInput ).val('');
                $(this).parent().parent().remove()
                var the_el = $(options.modalId).find('.js-select-image[data-id="' + $data + '"]');
                the_el.trigger('click');

                $(options.contextListener).find(options.setup.btnCall).css({
                    'display': ''
                })
            } else {

            }

        })

        this.setModalListeners();
        let v = $(options.contextListener).find( options.setup.mediaSelectionInput );
        if (v.val() > 0) {
            let selected = $(options.modalId).find('.js-select-image[data-id="' + v.val() + '"]');
            selected.trigger('click');
            $(options.modalId).find('.js-accept').trigger('click');
        }

    }
    start() {
        console.log(this)
        this.hooks.init(this);
        this.setListeners();
    }
}
