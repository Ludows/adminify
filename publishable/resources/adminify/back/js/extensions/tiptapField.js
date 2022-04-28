import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'

export default function tiptapInititalization(fields) {
    $.each(fields, function(i, el) {
        let check = $('#'+el.selector);

        if(check.length > 0) {
            let textField = $('#'+el.selector+' .tiptap_editor');
            let hiddenField = $('#'+el.selector+' input[type="hidden"]');
            
            let editor = new Editor({
                element: textField.get(0),
                extensions: [
                  StarterKit,
                ],
                content: hiddenField.val() ?? '',
                autofocus: true,
                editable: true,
                injectCSS: true,
              })

            // console.log('hiddenField', hiddenField, $('#'+el.selector))

            let form = hiddenField.closest("form");

            // if(hiddenField.val().length > 0) {
            //     textField.summernote('code', hiddenField.val());
            // }

            form.on('submit', function(e) {
                let code = editor.getText();
                hiddenField.val(code);
            })
        }

    })
}
