export default function JoditField(fields) {

    $.each(fields, function(i, el) {
        Jodit.make(el.selector+' '+el.fieldName, {});
    });
}
