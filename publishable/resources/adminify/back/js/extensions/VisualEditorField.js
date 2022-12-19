export default function VisualEditorInit(fields) {
    $.each(fields, function(i, el) {

        let btn = $('#'+el.selector).find('.js-toggle-visual');

        console.log('btn', btn, el);

        btn.on('click', function(e) {
            e.preventDefault();
            btn.next().attr('hidden', function(_, attr){ return !attr})
        })

        $(document).on('click', "#"+el.selector+' button[aria-label="Close"]', function(e) {
            e.preventDefault();
            btn.trigger('click');
        })

        
        Editor.defineElement();
    })
}
