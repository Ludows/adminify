export default function summernoteInititalization(fields) {
    $.each(fields, function(i, el) {
        let check = $('#'+el.selector);

        if(check.length > 0) {
            let textField = $('#'+el.selector+' .summernote_editor');
            let hiddenField = $('#'+el.selector+' input[type="hidden"]');
            let summernote = textField.summernote(el.options);

            // console.log('hiddenField', hiddenField, $('#'+el.selector))

            let form = hiddenField.closest("form");

            if(hiddenField.val().length > 0) {
                textField.summernote('code', hiddenField.val());
            }

            form.on('submit', function(e) {
                let code = textField.summernote('code');
                hiddenField.val(code);
            })
        }

    })
}
