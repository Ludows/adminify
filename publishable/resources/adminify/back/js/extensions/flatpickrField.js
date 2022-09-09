import flatpickr from "flatpickr";

export default function FlatpickrInititalization(fields) {
    $.each(fields, function(i, el) {
        var elScope = $(el.selector);
        var element = elScope.find(el.fieldName);

        const Lang = require("flatpickr/dist/l10n/"+ el.currentLang +".js").default[el.currentLang];

        flatpickr.localize(flatpickr.l10ns[el.currentLang]);

        let flatpickrInstance = flatpickr(element, el.options);
    })
}
