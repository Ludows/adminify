import flatpickr from "flatpickr";

export default function FlatpickrInititalization(fields) {
    $.each(fields, function(i, el) {
        var elScope = $(el.selector);
        var element = elScope.find(el.fieldName);
        flatpickrInstance = flatpickr(element, el.options);
    })
}
