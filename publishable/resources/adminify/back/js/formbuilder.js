jQuery(document).ready(function ($) {

    const Accordion_zone = $('#Accordion_zone');
    const Fields_zone = $('#Fields_zone');

    const Accordion_zone_Sortable = new Sortable(Accordion_zone.get(0), {
        group: {
            name: 'shared',
            pull: 'clone' // To clone: set pull to 'clone'
        },
        animation: 150
    });

    const Fields_zone_Sortable = new Sortable(Fields_zone.get(0), {
        group: {
            name: 'shared',
        },
        animation: 150
    });

});