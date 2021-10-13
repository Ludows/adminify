jQuery(document).ready(function ($) {

    const Accordion_zone = $('#Accordion_zone #formBuilderAccordion');
    const Fields_zone = $('#Fields_zone');
    const noFieldText = __('admin.formbuilder.noFields');

    const Accordion_zone_Sortable = new Sortable(Accordion_zone.get(0), {
        group: {
            name: 'shared',
            pull: 'clone' // To clone: set pull to 'clone'
        },
        animation: 150,
        onAdd: onAddToAccordion,
    });

    const Fields_zone_Sortable = new Sortable(Fields_zone.get(0), {
        group: {
            name: 'shared',
            pull: 'clone',
            put: false // Do not allow items to be put into this list
        },
        sort: false,
        animation: 150,
    });

    function onAddToAccordion(evt) {
        console.log(evt);
        let noFieldsTextSpan = $('#noFieldsText');

        if(Accordion_zone.children() > 0) {
            if(noFieldsTextSpan.length > 0) {
                noFieldsTextSpan.remove();
            }
        }
        else {
            Accordion_zone.append('<span id="noFieldsText">'+ noFieldText +'</span>');
        }
    }

});
