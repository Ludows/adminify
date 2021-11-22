$(document).ready(function($) {
    let editors = $('.adminify_editor');

    $.each(editors, function(i, editor) {

        //console.log('editor>>>', editor)

        $(editor).attr('data-editor', i);

        let sidebar_widgets = $(editor).find('.sidebar_widgets')
        let sidebar_controls = $(editor).find('.sidebar_controls')

        let sortable_widgets = sidebar_widgets.find('.widget_zone');
        let sortable_renderer = $(editor).find('.render_zone .col-12').first();
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
            handle: '[data-visual-element]',
            group: 'shared',
            animation: 150,
            onAdd: onAddToRenderer,
        });


        sortable_renderer.on('click', '.visual_element_block', function(e) {
            e.preventDefault();
            let uuid = $(this).attr('data-uuid');

            console.log('data element', uuid)

            $(editor).trigger('editor:widget:show', {
                uuid : uuid
            });
        })


        $(editor).trigger('editor:ready', {
            el : editor,
            controls : sidebar_controls,
            widgets : sidebar_widgets,
            sortable_widgets_js: sortable_widgets_js,
            sortable_renderer_js: sortable_renderer_js
        });

        $(editor).on('editor:widget:show', function(e, detail) {

            let active_setting_block = $('.block_settings[data-uuid="'+ detail.uuid +'"]');
            let setting_blocks = $('.block_settings').not( active_setting_block );

            setting_blocks.addClass('d-none').removeClass('d-block');
            active_setting_block.removeClass('d-none').addClass('d-block');

        });

        $(editor).on('editor:widget:settings:create', function(e, detail) {
            let wrap = '<div class="block_settings d-block" data-uuid="'+detail.uuid+'">'+ detail.settings +'</div>';
            sidebar_controls.append(wrap);
        });

        $(editor).on('editor:widget:block:create', function(e, detail) {
            let nesting_html = '';
            if(detail.allowChildsNesting) {
                nesting_html = '<div data-uuid="'+detail.uuid+'" class="nesting_sortable"></div>';
            }

            let wrap = '<div data-visual-element="'+detail.uuid+'" class="visual_element_block" data-uuid="'+detail.uuid+'">'+ detail.render +'</div>'+nesting_html;
            sortable_renderer.append(wrap);
        });

        $(editor).on('editor:widget:new', function(e, detail) {
            // console.log('details', detail, e);
            $(e.target).trigger('editor:widget:settings:create', detail.config);
            $(e.target).trigger('editor:widget:block:create', detail.config);
            $(e.target).trigger('editor:widget:show', {
                uuid : detail.config.uuid
            })
        })



    })

    function onAddToRenderer(evt) {
        let editor = $(evt.to).parents('[data-editor]').first();


        let widgetType = $(evt.item).find('.js-handle').attr('data-widget');

        $(evt.item).remove()

        $.ajax({
            'method' : 'POST',
            'url' : Route('editor.addWidget', {
                'widget' : widgetType
            }),
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'data' : {
                'config' : {
                    'newWidget' : true,
                    'settings' : true
                }
            }
        })
        .done((response) => {
            console.log(response)

            editor.trigger('editor:widget:new', {
                el : editor,
                config : response.data
            })

        })
        .fail((err) => {
            console.log(err)
        })
    }

});
