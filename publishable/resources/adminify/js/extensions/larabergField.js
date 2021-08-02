export default function LarabergInititalization(fields) {
    $.each(fields, function(i, el) {
        let textarea = $('#'+el.selector+' textarea');
        let laraberg =  Laraberg.init(textarea.attr('id'), el.options);

        $("#"+el.selector).on('click', '.js-select-template', function(e) {
            e.preventDefault();
            $('#modalSelectTemplate').modal('show');
        })

        $("#"+el.selector).on('click', '.js-save-template', function(e) {
            e.preventDefault();
            $('#modalSaveTemplate').modal('show');
        })
    })
}
