export default function QuillEditorInititalization(fields) {
    var modalMediaLibrary = $('#modalMediaLibrary');
    $.each(fields, function(i, el) {

        var quill = new Quill(el.selector +' .editor', el.options);
        var hiddenField = $(el.selector).find('input[type="hidden"]');

        function UpdateHiddenField(el, delta) {
            el.val(JSON.stringify(delta))
        }
        if(hiddenField.val().length > 0) {
            quill.setContents(
                JSON.parse( hiddenField.val() )
            );
        }
        else {
            UpdateHiddenField(hiddenField, quill.getContents())
        }

        quill.getModule('toolbar').addHandler('image', () => {

            modalMediaLibrary.addClass('from-quill').modal('show')

        });

        modalMediaLibrary.on('makequillcontent', function(event, el) {
            const range = quill.getSelection();
            modalMediaLibrary.removeClass('from-quill');
            quill.insertEmbed(range.index, 'image', $(el).find('img').attr('src'));
            $(el).trigger('click')
        })

        quill.on('text-change', function() {
            var delta = quill.getContents();
            UpdateHiddenField(hiddenField, quill.getContents())
        });

    })


}
