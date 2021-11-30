$(document).ready(function($) {
    let editors = $('.adminify_editor');

    $.each(editors, function(i, editor) {

        //console.log('editor>>>', editor)

        $(editor).attr('data-editor', i);

        let sidebar_widgets = $(editor).find('.sidebar_widgets')
        let sidebar_controls = $(editor).find('.sidebar_controls')

        let sortable_widgets = sidebar_widgets.find('.widget_zone');
        let sortable_renderer = $(editor).find('.render_zone .col-12').last();
        let sidebars = $(editor).find('.js-sidebar');
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
            handle: '.visual_element_block',
            group: 'shared',
            animation: 150,
            onAdd: onAddToRenderer,
        });

        let titleBlock = $(editor).find('.title_zone');

        titleBlock.on('keyup', function(e) {
            e.preventDefault();
            let text = $(this).text();

            $('#global-settings-tab form > input[name="title"]').val(text);
        })


        sidebars.on('click', function(e) {
            e.preventDefault();
            let data = $(this).attr('data-handle');
            let sidebar = $(editor).find(data);

            if($(sidebar).hasClass('active')) {
                $(editor).trigger('editor:sidebar:hide', {
                    sidebar : sidebar,
                    btn: $(editor).find('.js-sidebar[data-handle="'+ data +'"]')
                })
            }
            else {
                $(editor).trigger('editor:sidebar:show', {
                    sidebar : sidebar,
                    btn: $(editor).find('.js-sidebar[data-handle="'+ data +'"]')
                })
            }


            $(editor).trigger('editor:render:redraw', {
                render_zone : $(editor).find('.render_zone')
            })

            // sidebar.toggleClass('active');

        })

        sortable_renderer.on('click', '.visual_element_block', function(e) {
            e.preventDefault();
            let uuid = $(this).attr('data-uuid');

            // console.log('data element', uuid)

            $(editor).trigger('editor:widget:show', {
                uuid : uuid
            });

            $(editor).trigger('editor:sidebar:show', {
                sidebar : $(editor).find('.sidebar_controls'),
                btn: $(editor).find('.js-sidebar[data-handle=".sidebar_controls"]')
            });

            $(editor).trigger('editor:render:redraw', {
                render_zone : $(editor).find('.render_zone'),
                uuid : uuid
            })

            $('#pills-blocs-settings-tab').trigger('click');

        })

        sortable_renderer.on('blur', '.visual_element_block', function(e) {


            let node = e.relatedTarget;
            if(e.relatedTarget == null) {
                node = sortable_renderer.get(0);
            }

            if(sortable_renderer.get(0).contains(node) == true) {
                $(editor).find('.js-no-bloc-selected').removeClass('d-none').addClass('d-block');
                $('#pills-global-settings-tab').trigger('click');
                $('.block_settings').addClass('d-none').removeClass('d-block')
            }

        });


        $(editor).trigger('editor:ready', {
            el : editor,
            controls : sidebar_controls,
            widgets : sidebar_widgets,
            sortable_widgets_js: sortable_widgets_js,
            sortable_renderer_js: sortable_renderer_js
        });

        $(editor).on('editor:render:redraw', function(i, detail) {

            // console.log('active', $(sidebar_widgets).hasClass('active'), detail)
            if($(sidebar_widgets).hasClass('active')) {
                detail.render_zone.css({
                    'padding-left' : $(sidebar_widgets).outerWidth(true)+'px'
                })
            }
            else {
                detail.render_zone.css({
                    'padding-left' : ''
                })
            }

            if($(sidebar_controls).hasClass('active')) {
                detail.render_zone.css({
                    'padding-right' : $(sidebar_controls).outerWidth(true)+'px'
                })
            }
            else {
                detail.render_zone.css({
                    'padding-right' : ''
                })
            }

        });

        $(editor).on('editor:sidebar:show', function(e, detail) {

            $(detail.sidebar).css({
                'top' : $(editor).find('.editor-topbar').outerHeight(true)+'px'
            })

            $(detail.sidebar).addClass('active');

            detail.btn.addClass('active');
        });

        $(editor).on('editor:sidebar:hide', function(e, detail) {
            $(detail.sidebar).removeClass('active');

            detail.btn.removeClass('active');
        });

        $(editor).on('editor:widget:show', function(e, detail) {

            let active_setting_block = $('.block_settings[data-uuid="'+ detail.uuid +'"]');
            let setting_blocks = $('.block_settings').not( active_setting_block );

            setting_blocks.addClass('d-none').removeClass('d-block');
            active_setting_block.removeClass('d-none').addClass('d-block');

            $(editor).find('.js-no-bloc-selected').addClass('d-none').removeClass('d-block');
        });

        $(editor).on('editor:widget:settings:create', function(e, detail) {
            let wrap = '<div class="block_settings d-block" data-uuid="'+detail.uuid+'">'+ detail.settings +'</div>';
            sidebar_controls.find('#blocs-settings-tab').append(wrap);

            sidebar_controls.find('#blocs-settings-tab form > .form-group').children().removeAttr('name')
        });

        $(editor).on('editor:widget:block:create', function(e, detail) {
            let wrap = '<div data-visual-element="'+detail.uuid+'" class="visual_element_block" data-uuid="'+detail.uuid+'">'+ detail.render +'</div>';
            sortable_renderer.append(wrap);
        });

        $(editor).on('editor:widget:new', function(e, detail) {
            // console.log('details', detail, e);
            $(e.target).trigger('editor:widget:settings:create', detail.config);
            $(e.target).trigger('editor:widget:block:create', detail.config);
            $(e.target).trigger('editor:widget:show', {
                uuid : detail.config.uuid
            })

            $(e.target).trigger('editor:sidebar:show', {
                sidebar : $(editor).find('.sidebar_controls'),
                btn: $(editor).find('.js-sidebar[data-handle=".sidebar_controls"]')
            });

            $(e.target).trigger('editor:sidebar:hide', {
                sidebar : $(editor).find('.sidebar_widgets'),
                btn : $(editor).find('.js-sidebar[data-handle=".sidebar_widgets"]')
            });

            $(editor).trigger('editor:render:redraw', {
                render_zone : $(editor).find('.render_zone'),
                uuid : detail.config.uuid
            })

            $('#pills-blocs-settings-tab').trigger('click');
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
