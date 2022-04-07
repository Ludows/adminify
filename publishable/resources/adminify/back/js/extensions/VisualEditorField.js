export default function VisualEditorInit(fields) {
    $.each(fields, function(i, el) {

        let btn = $(el).find('.js-toggle-visual');

        btn.on('click', function(e) {
            e.preventDefault();
            btn.next().attr('hidden', function(_, attr){ return !attr})
        })

        
        Editor.defineElement();
    })
}
