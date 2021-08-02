export default function LarabergInititalization(fields) {
    $.each(fields, function(i, el) {
        let textarea = $('#'+el.selector+' textarea');
        let laraberg =  Laraberg.init(textarea.attr('id'), el.options)
    })
}
