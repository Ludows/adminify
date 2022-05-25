// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";

// If you are using an older version than Dropzone 6.0.0,
// then you need to disabled the autoDiscover behaviour here:
Dropzone.autoDiscover = false;

jQuery(document).ready(() => {
    console.log('hello from mediatheque !')

    const MediaTheque = $('.js-mediatheque');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
})
