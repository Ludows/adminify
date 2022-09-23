// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";
import { debounce } from "lodash";
import Swal from "sweetalert2";
// If you are using an older version than Dropzone 6.0.0,
// then you need to disabled the autoDiscover behaviour here:
Dropzone.autoDiscover = false;

jQuery(document).ready(() => {
    console.log('hello from mediatheque !')

    const MediaTheque = $('.js-mediatheque');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function loadSearchmedias(query = {}, cb = null) {
        let gallerySet = MediaTheque.find('#GallerySet');

        $.ajax({
            url: Route('medias.listing'),
            method: 'POST',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            data : query,
            type: 'json'
        })
        .done((result) => {
            console.log(result);

            gallerySet.html('')
            gallerySet.html(result.html)
            if(cb && typeof cb == 'function') {
                cb(null, result);
            }
        })
        .fail((error) => {
            console.log('whoops', error);
            if(cb && typeof cb == 'function') {
                cb(error, null);
            }
        })
    }

    function callTheSearch(e) {
        loadSearchmedias(getQuerySearch());
    }

    function isDeleteGroupMode() {
        return MediaTheque.hasClass('is-delete-group');
    }

    function isSelectionGroupMode() {
        return window.admin.modalPicker && MediaTheque.hasClass('is-selection');
    }

    function syncSelectionToModal(elm = null, modal = null, isSelection = false) {

        if(modal) {
            let hasSelector = elm.attr('data-selector');

            if(hasSelector) {
                modal.find('#config_picker_handle').val(elm.attr('data-selector'));

                const { config } = getSelection();
                const field = getField( config );

                // if(field.val().length > 0) {
                //     hydrateToField( config, field.val().trim());
                // }

            }


            // let deletes = null;
            // let selection = null;

            if(isSelection) {
                console.log(getSelection())
            }


        }

    }

    function getConfigPicker(configId) {
        let ret = null;

        $.each(window.admin.modalPicker, (i, object) => {
            if(object.selector == configId) {
                ret = object;
                return ret;
            }
        })

        return ret;
    }

    function getSelectionMode() {
        if(MediaTheque.hasClass('is-selection')) {
            return MediaTheque.hasClass('is-multiple') ? 'multiple' : 'single';
        }
        return null;
    }

    function setSelecteds(values) {
        let sel = MediaTheque.find('#media_selecteds_id')

        sel.val(values);

        return sel;
    }

    function getSelecteds() {
        let sel = MediaTheque.find('#media_selecteds_id')
        if(sel.length > 0) {
            return sel.val().split(',');
        }
        return null;
    }

    function getSelection() {
        let selecteds = getSelecteds();
        console.log('selecteds', selecteds)
        let html = '';
        let modal = getCurrentModal();
        let config = getConfigPicker( modal.find('#config_picker_handle').val() );

        selecteds.forEach((selectedId) => {
            let elm = MediaTheque.find('.js-modal-details[data-id="'+ selectedId +'"]').clone(true);
            elm.append('<span class="js-remove-selection clear" data-id="'+ selectedId +'">x</span>');
            html += elm.prop('outerHTML');
        })
        return {
            ids : selecteds,
            html : html,
            config
        };
    }

    function mapAttributestoForm(form, modelAttributes) {

        let formElements = form.find('.form-control');

        $.each(formElements, function(i, el) {
            let formName = $(el).attr('name');
            // console.log('formName', formName)
            // console.log('modelAttributes', modelAttributes)
            if(modelAttributes[formName]) {
                $(el).val(modelAttributes[formName]);
            }
            else {
                $(el).val('');
            }
        });
    }

    function updateMediaObject(id, object) {
        $('.js-modal-details[data-id="'+ id +'"]').attr('data-media', object);
    }


    function handleNavigation(e) {
        if($(this).attr('disabled')) {
            return false;
        }

        let id = $(this).attr('data-id');
        $('.js-modal-details[data-id="'+ id +'"]').trigger('click');
    }

    function getDeletes() {
        return $('.js-remove-image-group').attr('data-ids').split(',');
    }

    function toggleDeletesId($id) {
        let removerGroup = $('.js-remove-image-group');
        if(removerGroup.length > 0 && isDeleteGroupMode()) {
            let removerAttr = removerGroup.attr('data-ids');
            let ids = removerAttr.split(',');

            ids = ids.filter(n => n);

            let indexPos = ids.indexOf($id);
            if(indexPos > -1) {
                ids.splice(indexPos,1);
            } else {
                ids.push($id)
            }


            ids = ids.filter(n => n);

            removerGroup.attr('data-ids', ids.join(','));

            if(ids.length > 0) {
                removerGroup.removeClass('disabled');
            }
            else {
                removerGroup.addClass('disabled');
            }
        }
    }

    function manageSelectionMode(id = null) {
        let sel = MediaTheque.find('#media_selecteds_id');
        let modal = getCurrentModal();
        let selectMediaBtn = modal.find('.js-select-media');
        let previewBlock = modal.find('#previewBlock');
        let selectionMode = getSelectionMode();
        if(sel.length > 0) {
            let spl_values = getSelecteds();
            spl_values = spl_values.filter(n => n);

            if(selectionMode == 'single') {
                spl_values = [];
                spl_values.push(id);
            }
            else {
                let indexPos = spl_values.indexOf(id);
                if(indexPos > -1) {
                    spl_values.splice(indexPos,1);
                } else {
                    spl_values.push(id);
                }
            }

            sel.attr('value', spl_values.join(','));

            previewBlock.removeClass('invisible');

            if(spl_values.length > 0) {
                selectMediaBtn.removeClass('disabled');
            }
            else {
                selectMediaBtn.addClass('disabled');
                previewBlock.addClass('invisible');
            }


        }
        return [];
    }

    function isModal(selector) {
        let modal = getCurrentModal();
        return modal.is(selector);
    }

    function renderPreview(modal, model, originalUrl) {

        let typedData = null;
        let reverseTypedData = null;

        if(model.mime_type.startsWith('video/')) {
            typedData = modal.find('#videoOriginal');
            reverseTypedData = modal.find('.js-preview').not('#videoOriginal');
        }
        else if(model.mime_type.startsWith('audio/')) {
            typedData = modal.find('#audioOriginal');
            reverseTypedData = modal.find('.js-preview').not('#audioOriginal');
        }
        else if(model.mime_type.startsWith('image/')) {
            typedData = modal.find('#imageOriginal');
            reverseTypedData = modal.find('.js-preview').not('#imageOriginal');
        }
        else {
            typedData = modal.find('#iframeOriginal');
            reverseTypedData = modal.find('.js-preview').not('#iframeOriginal');
        }

        typedData.attr('src', originalUrl);

        typedData.removeClass('d-none');
        reverseTypedData.addClass('d-none');



        typedData.on(typedData.is('#audioOriginal') ? 'canplay' : 'load', () => {
            modal.modal('show');
            modal.find('form').attr('data-id', model.id);
            modal.find('.js-single-destroy-media').attr('data-id', model.id);
            modal.find('form').attr('action', Route('medias.update', {
                'media' : model.id
            }) )
        })
    }



    function handleModalProcess(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let typeAction = 'delete';
        let isSelectionMode = isSelectionGroupMode();
        let isDeleteMode = isDeleteGroupMode();
        let model = $(this).attr('data-media');
        let originalImage = $(this).attr('data-original');
        let modal = getCurrentModal();

        syncSelectionToModal($(this), modal, isSelectionMode);

        console.log(isDeleteMode, isSelectionMode);

        if(isDeleteMode) {
            toggleDeletesId(id);

        }
        if(isSelectionMode) {
            typeAction = 'selection';
            manageSelectionMode(id);
        }

        if(!isDeleteMode) {
            renderPreview(modal, JSON.parse(model), originalImage);
        }

        mapAttributestoForm(modal.find('form'), JSON.parse(model));

        renderActiveMedia(id, typeAction);

        if(isDeleteMode || isSelectionMode) {
            return false;
        }


        let nextMediaHandle = $(this).next('.js-modal-details');
        let previousMediaHandle = $(this).prev('.js-modal-details');

        let nextMediaModalHandle = $('.js-modal-detail[data-type="next"]');
        let previousMediaModalHandle = $('.js-modal-detail[data-type="previous"]');

        if(nextMediaHandle.length > 0) {
            nextMediaModalHandle.removeAttr('disabled');
            nextMediaModalHandle.attr('data-id', nextMediaHandle.attr('data-id'))
        }
        else {
            nextMediaModalHandle.removeAttr('data-id');
            nextMediaModalHandle.attr('disabled', 'disabled');
        }

        if(previousMediaHandle.length > 0) {
            previousMediaModalHandle.removeAttr('disabled');
            previousMediaModalHandle.attr('data-id', previousMediaHandle.attr('data-id'))
        }
        else {
            previousMediaModalHandle.removeAttr('data-id');
            previousMediaModalHandle.attr('disabled', 'disabled');
        }

        // console.log(nextMediaHandle, previousMediaHandle)


    }

    function UrlParser(url = null) {
        var url_string = url ? url : window.location.href;
        var url = new URL(url_string);
        return url;
    }

    function getParam(param = 'page', url = null) {
        return UrlParser(url).searchParams.get(param);
    }

    function getQuerySearch() {
        let o = {}

        let doc = MediaTheque.find('.js-documents')
        let date = MediaTheque.find('.js-date')
        let search = MediaTheque.find('.js-search-media')



        o.documents = doc.val()
        o.date = date.val()
        o.search = search.val(),
        o.page = getParam('page');

        return o;
    }

    function getCurrentModal() {
        let selector = '#modalDetails';
        let testSelector = $(selector);

        if(testSelector.length == 0) {
            selector = '#modalPicker'
            testSelector = $(selector);
        }

        return testSelector;
    }

    function handleMassDelete() {
        if($(this).hasClass('disabled')) {
            return false;
        }

        let ids = getDeletes();

        let sure = new Swal({
            title : __('admin.sureDeleteMedias'),
            text : __('admin.sureDeleteMediasText'),
            showCancelButton: true,
            confirmButtonText: __('admin.ok'),
            cancelButtonText: __('admin.no'),
        })
        .then((result) => {
            console.log(result);
            if(result.isConfirmed) {
                ids.forEach((id) => {
                    performDestroy(id, true);
                })

                $(this).attr('data-ids', '');
                $(this).next().trigger('click');
            }
        })
        .catch((error) => {
            console.log('whoops', error);
        })


    }

    function performUpdate(e) {
        let formNative = $(this).get(0).form;
        console.log(formNative);
        let objectSerialize = $(formNative).serializeFormJSON()
        console.log(objectSerialize);
        $.ajax({
            url: formNative.getAttribute('action'),
            method: 'PUT',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            data : objectSerialize,
            type: 'json'
        })
        .done((result) => {
            console.log(result);
            updateMediaObject( formNative.getAttribute('data-id') , JSON.stringify(result.model));
        })
        .fail((error) => {
            console.log('whoops', error);
        })
    }

    function performDestroy(id, withCallSearch = true) {
        $.ajax({
            url: Route('medias.destroy', { media: id }),
            method: 'DELETE',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            data : {},
            type: 'json'
        })
        .done((result) => {
            console.log(result);
            getCurrentModal().modal('hide');
            if(withCallSearch) {
                callTheSearch();
            }
        })
        .fail((error) => {
            console.log('whoops', error);
        })
    }

    function renderActiveMedia(id = null, mode = 'delete') {
        let source = mode == 'delete' ? getDeletes() : getSelecteds();
        let notSelectorStr = [];
        if(!isDeleteGroupMode() || !isSelectionGroupMode()) {
            $('.js-modal-details').removeClass('selected');
        }
        if(isDeleteGroupMode() || isSelectionGroupMode()) {
            source.forEach((sourceId) => {
                notSelectorStr.push('.js-modal-details[data-id="'+ sourceId +'"]')
            })

            // console.log('notSelectorStr', notSelectorStr, source)

            $('.js-modal-details').not( notSelectorStr.join(',') ).removeClass('selected');

            let elm = $('.js-modal-details[data-id="'+ id +'"]');

            if(source.indexOf(id) > -1) {
                elm.addClass('selected')
            }
            else {
                elm.removeClass('selected')
            }
            // elm.hasClass('selected') ? elm.removeClass('selected') : elm.addClass('selected');
        }


    }

    function handlePagination(e) {
        e.preventDefault();

        if($(this).parent().hasClass('disabled')) {
            return false;
        }

        let query = getQuerySearch();

        query.page = getParam('page', $(this).attr('href'));

        let urlPageValue = getParam('page');

        window.history.replaceState({}, '', window.location.href.replace('page='+urlPageValue, 'page='+query.page));

        loadSearchmedias(query, function(err, result) {
            if(err) {
                throw err;
            }

            let deletes = getDeletes();
            deletes.forEach((deleteId) => {
                renderActiveMedia(deleteId, 'delete');
            })
        });
    }

    function hydrateToField(config = null, value) {
        if(config) {
            $('#'+config.selector+' '+ config.fieldName).val(value);
        }
    }

    function getField(config = null) {
        if(config) {
            return $('#'+config.selector+' '+'[name="'+ config.fieldName +'"]');
        }
    }

    function handleDeleteInSelection(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).parent().remove();
        let selecteds_media = MediaTheque.find('#media_selecteds_id');

        let dataId = $(this).attr('data-id');

        let selecteds = getSelecteds();
        let selectionIndex = selecteds.indexOf( dataId );
        console.log(selectionIndex);
        if(selectionIndex > -1) {
            selecteds.splice( selectionIndex, 1)
            selecteds_media.val( selecteds );
        }
        let selection = getSelection();

        let selectionZone = $('#'+selection.config.selector).find('.row-selection');
        let childLength = selectionZone.children().length;

        if(childLength == 0) {
            $('#'+selection.config.selector).find('.js-modal-picker').removeClass('d-none');
        }

        hydrateToField(selection.config, selection.ids.join(','));


    }

    function handleSelectionProcess(e) {
        e.preventDefault();
        console.log($(this));
        let modal = getCurrentModal();
        if($(this).hasClass('disabled')) {
            return false;
        }

        let selection = getSelection();

        modal.modal('hide');

        console.log(selection.config.selector , $('#'+selection.config.selector).find('.row-selection'))

        $('#'+selection.config.selector).find('.row-selection').html( selection.html );

        $('#'+selection.config.selector).find('.js-modal-picker').addClass('d-none');

        console.log('selection', selection)

        hydrateToField(selection.config, selection.ids.join(','));
    }

    if(MediaTheque.length > 0) {
        let dropzone = new Dropzone('#dropzoneUploadFiles', {
            url : $('#dropzoneUploadFiles').attr('action'),
            paramName: window.siteSettings.media_library.paramName,
            acceptedFiles: window.siteSettings.media_library.allowed_mime_types.join(', '),
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
        })

        let modal = getCurrentModal();

        console.log('modal', modal)


        MediaTheque.on('click', '.js-open-dropzone', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $(this).parent().next().toggleClass('d-none');
        })

        MediaTheque.on('change', '.js-documents', callTheSearch);

        MediaTheque.on('change', '.js-date', callTheSearch);

        MediaTheque.on('keyup', '.js-search-media', debounce(callTheSearch, 300));

        $(document).on('keyup', '.js-metadatas-media', debounce(performUpdate, 300));

        MediaTheque.on('click', '.js-modal-detail', handleNavigation);

        MediaTheque.on('click', '.js-remove-image-group', handleMassDelete)

        MediaTheque.on('click', '.pagination .page-link', handlePagination)

        MediaTheque.on('click', '.js-toggle-selectgroup', function(e) {
            e.preventDefault();
            $(this).prev().toggleClass('d-none');
            MediaTheque.toggleClass('is-delete-group');
            MediaTheque.find('.filter-zone').toggleClass('d-none');

            let deletes = getDeletes();
            deletes.forEach((deleteId) => {
                renderActiveMedia(deleteId, 'delete');
            })

        })

        dropzone.on('complete', (file) => {
            dropzone.removeFile(file);
            callTheSearch();
        })

        MediaTheque.on('click', '.js-modal-details', handleModalProcess)
        $(document).on('click', '.row-selection .js-modal-details', handleModalProcess);
        $(document).on('click', '.row-selection .js-modal-details .js-remove-selection', handleDeleteInSelection);

        modal.on('click', '.js-select-media', handleSelectionProcess)

        // trigger init
        callTheSearch()
    }

    $(document).on('click', '.js-single-destroy-media', function(e) {
        e.preventDefault();
        let sure = new Swal({
            title : __('admin.sureDeleteMedia'),
            text : __('admin.sureDeleteMediaText'),
            showCancelButton: true,
            confirmButtonText: __('admin.ok'),
            cancelButtonText: __('admin.no'),
        })
        .then((result) => {
            console.log(result);
            if(result.isConfirmed) {
                performDestroy( $('.js-single-destroy-media').attr('data-id') );
            }
        })
        .catch((error) => {
            console.log('whoops', error);
        })
    })

    $(document).on('click', '.js-modal-picker', function(e) {
        e.preventDefault();
        let modal = getCurrentModal();
        console.log(modal);
        let selector = $(this).attr('data-selector');

        modal.find('#config_picker_handle').val(selector);

        modal.modal('toggle');
    })





})
