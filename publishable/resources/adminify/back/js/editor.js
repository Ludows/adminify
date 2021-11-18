$(document).ready(function($) {
    let editors = $('.adminify_editor');

    $.each(editors, function(i, editor) {

        console.log('editor>>>', editor)

        let sidebar_widgets = $(editor).find('.sidebar_widgets')
        let sidebar_controls = $(editor).find('.sidebar_controls')

        let sortable_widgets = sidebar_widgets.find('.widget_zone');
        let sortable_renderer = $(editor).find('#renderZoneWidgets');

        let sortable_widgets_js = new Sortable(sortable_widgets.get(0), {
            handle: '.js-handle',
            group: {
                name: 'shared',
                pull: 'clone',
                put: false // Do not allow items to be put into this list
            },
            animation: 150,
            sort: false // To disable sorting: set sort to false
        });

        let sortable_renderer_js = new Sortable(sortable_renderer.get(0), {
            group: 'shared',
            animation: 150,
            onAdd: onAddToRenderer,
        });


        sidebar_controls.on('click', '[data-visual-element]', function(e) {
            e.preventDefault();
        })

    })


    function onAddToRenderer(evt) {
        console.log(evt)

        $.ajax({
            'method' : 'POST',
            'url' : Route('editor.addWidget', {
                'widget' : 'titleWidget'
            }),
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'data' : {}
        })
        .done((data) => {
            console.log(data)
        })
        .fail((err) => {
            console.log(err)
        })
    }

});
