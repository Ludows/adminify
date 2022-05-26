// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";

// If you are using an older version than Dropzone 6.0.0,
// then you need to disabled the autoDiscover behaviour here:
Dropzone.autoDiscover = false;

jQuery(document).ready(() => {
    console.log('hello from mediatheque !')

    const MediaTheque = $('.js-mediatheque');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function loadSearchMedias(query = {}) {
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
        })
        .fail((error) => {
            console.log('whoops', error);
        })
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

        // trigger init
        loadSearchMedias({});
    }


    $(document).on('click', '.js-modal-details', function(e) {
        e.preventDefault();
        let modal = $('#modalDetails');
        let originalImage = $(this).attr('data-original');
        let image = modal.find('#imageOriginal');

        image.attr('src', originalImage);

        image.on('load', () => {
            modal.modal('toggle');
        })
    })

    $(document).on('click', '.js-modal-picker', function(e) {
        e.preventDefault();
        let modal = $('#modalPicker');
        modal.modal('toggle');
    })





})
