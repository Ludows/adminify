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

    function loadSearchMedias(query = {}, cb = null) {
        let gallerySet = MediaTheque.find('#GallerySet');

        $.ajax({
            url: Route('mediasv2.listing'),
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
        loadSearchMedias(getQuerySearch());
    }

    function isDeleteGroupMode() {
        return MediaTheque.hasClass('is-delete-group');
    }

    function mapAttributestoForm(form, modelAttributes) {

        let formElements = form.find('.form-control');

        $.each(formElements, function(i, el) {
            let formName = $(el).attr('name');
            console.log('formName', formName)
            console.log('modelAttributes', modelAttributes)
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


            removerGroup.attr('data-ids', ids.join(','));

            if(ids.length > 0) {
                removerGroup.removeClass('disabled');
            }
            else {
                removerGroup.addClass('disabled');
            }
        }
    }


    function handleModalProcess(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

        toggleDeletesId(id);
        renderIfDeleteMassMode(id);
        if(isDeleteGroupMode()) {
            return false;
        }



        let modal = $('#modalDetails');
        let originalImage = $(this).attr('data-original');
        let model = $(this).attr('data-media');
        let image = modal.find('#imageOriginal');

        image.attr('src', originalImage);

        mapAttributestoForm(modal.find('form'), JSON.parse(model));

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

        image.on('load', () => {
            modal.modal('show');
            modal.find('form').attr('data-id', id);
            modal.find('.js-single-destroy-media').attr('data-id', id);
            modal.find('form').attr('action', Route('mediasv2.update', {
                'mediasv2' : id
            }) )
        })
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

    function handleMassDelete() {
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
            url: Route('mediasv2.destroy', { mediasv2: id }),
            method: 'DELETE',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            data : {},
            type: 'json'
        })
        .done((result) => {
            console.log(result);
            $('#modalDetails').modal('hide');
            if(withCallSearch) {
                callTheSearch();
            }
        })
        .fail((error) => {
            console.log('whoops', error);
        })
    }

    function renderIfDeleteMassMode(id = null) {
        let deletes = getDeletes();
        let notSelectorStr = [];
        if(!isDeleteGroupMode()) {
            $('.js-modal-details').removeClass('selected');
        }
        if(isDeleteGroupMode()) {
            deletes.forEach((deleteId) => {
                notSelectorStr.push('.js-modal-details[data-id="'+ deleteId +'"]')
            })

            console.log('notSelectorStr', notSelectorStr, deletes)

            $('.js-modal-details').not( notSelectorStr.join(',') ).removeClass('selected');

            let elm = $('.js-modal-details[data-id="'+ id +'"]');

            if(deletes.indexOf(id) > -1) {
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

        loadSearchMedias(query, function(err, result) {
            if(err) {
                throw err;
            }

            let deletes = getDeletes();
            deletes.forEach((deleteId) => {
                renderIfDeleteMassMode(deleteId);
            })
        });
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



        MediaTheque.on('click', '.js-open-dropzone', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $(this).parent().next().toggleClass('d-none');
        })

        MediaTheque.on('change', '.js-documents', callTheSearch);

        MediaTheque.on('change', '.js-date', callTheSearch);

        MediaTheque.on('keyup', '.js-search-media', debounce(callTheSearch, 300));

        MediaTheque.on('keyup', '.js-metadatas', debounce(performUpdate, 300));

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
                renderIfDeleteMassMode(deleteId);
            })

        })

        dropzone.on('complete', (file) => {
            dropzone.removeFile(file);
            callTheSearch();
        })

        MediaTheque.on('click', '.js-modal-details', handleModalProcess)

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
        let modal = $('#modalPicker');
        modal.modal('toggle');
    })





})
