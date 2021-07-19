export default function summernoteInititalization(fields) {
    $.each(fields, function(i, el) {
        let textField = $('#'+el.selector+' .summernote_editor');
        let hiddenField = $('#'+el.selector+' input[type="hidden"]');
        let summernote = textField.summernote(el.options);

        if(hiddenField.val().length > 0) {
            textField.summernote('code', hiddenField.val());
        }
    })
}
