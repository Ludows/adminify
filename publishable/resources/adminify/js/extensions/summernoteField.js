export default function summernoteInititalization(fields) {
    $.each(fields, function(i, el) {
        let textField = $('#'+el.selector+' .summernote_editor');
        let summernote = textField.summernote(el.options);
    })
}
