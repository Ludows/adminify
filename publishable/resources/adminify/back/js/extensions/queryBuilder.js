export default function queryBuilderInititalization(fields) {
    $.each(fields, function(i, el) {
        $('#'+ el.selector).queryBuilder({
            filters: []
        });
    })
}
