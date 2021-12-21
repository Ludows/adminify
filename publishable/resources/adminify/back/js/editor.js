$(document).ready(function ($) {
    let editors = $('.adminify_editor');

    $.each(editors, function (i, editor) {

        //console.log('editor>>>', editor)

        $(editor).attr('data-editor', i);

        let sidebar_widgets = $(editor).find('.sidebar_widgets')
        let sidebar_controls = $(editor).find('.sidebar_controls')
        let render_zone = $(editor).find('.render_zone');

        let sortable_widgets = sidebar_widgets.find('.widget_zone');
        let sortable_renderer = $(editor).find('.render_zone .col-12').last();
        let sidebars = $(editor).find('.js-sidebar');
        let sortable_widgets_js = createSortableZone(sortable_widgets.get(0), {
            handle: '.js-handle',
            group: {
                name: 'shared',
                pull: 'clone',
                put: false // Do not allow items to be put into this list
            },
            animation: 150,
            sort: false // To disable sorting: set sort to false
        });

        let sortable_renderer_js = createSortableZone(sortable_renderer.get(0), {
            handle: '.visual_element_block',
            group: 'shared',
            animation: 150,
            onAdd: onAddToRenderer,
            fallbackOnBody: true,
		    swapThreshold: 0.65
        });

        let titleBlock = $(editor).find('.title_zone');

        titleBlock.on('keyup', function (e) {
            e.preventDefault();
            let text = $(this).text();

            $('#global-settings-tab form > input[name="title"]').val(text);
        })

        sidebars.on('click', function (e) {
            e.preventDefault();
            let data = $(this).attr('data-handle');
            let sidebar = $(editor).find(data);

            if ($(sidebar).hasClass('active')) {
                $(editor).trigger('editor:sidebar:hide', {
                    sidebar: sidebar,
                    btn: $(editor).find('.js-sidebar[data-handle="' + data + '"]')
                })
            } else {
                $(editor).trigger('editor:sidebar:show', {
                    sidebar: sidebar,
                    btn: $(editor).find('.js-sidebar[data-handle="' + data + '"]')
                })
            }


            $(editor).trigger('editor:render:redraw', {
                render_zone: $(editor).find('.render_zone')
            })

            // sidebar.toggleClass('active');

        })

        $(window).on('resize', function(e) {
            let topbar = $(editor).find('.editor-topbar');

            // let zoneToApply = $(editor).find('.render_zone');
            // console.log('before redraw', editor, topbar)
            $(editor).trigger('editor:render:redraw', {
                render_zone: $(editor).find('.render_zone'),
                topbar : topbar,
            })
            // console.log('after redraw', editor, topbar)

        })

        $(editor).on('click', '.js-publish', function(e) {
            e.preventDefault();

            let jsonAgregate = agregateForPublish();

            console.log('jsonAgregate', jsonAgregate)

            // localStorage.setItem('page-')
        });

        $(editor).on('click', '.js-choose-box [data-editor-choose]', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let $wId = getTheWidgetId( $(this) );
            let visual = getVisualElement( $wId );

            // console.log('$wId', $wId)

            $(editor).trigger('editor:template:call', {
                element: $(this),
                widget: $(this).attr('data-widget'),
                datas: {
                    config: {
                        child: true,
                        count : $(this).attr('data-count'),
                        parent_uuid : $wId,
                        parent_widgetType: getTheWidgetType( $(this) ),
                    }
                }
            })

            visual.removeClass('d-none');
            $('.js-choose-box[data-ref="'+ $wId +'"]').remove()
        });

        $(editor).on('keyup', '.js-search-widget', function(e) {
            e.preventDefault();

            console.log('editor')

            let blocks = $(this).parent().parent().next().find('.js-handle');
            let val = $(this).val().toLowerCase();

            console.log(blocks, val)

            $.each(blocks, function(i, block) {

                let blk = $(block);
                let text = blk.find('.text-muted').text();

                if(text.toLowerCase().indexOf(val) > -1) {
                    blk.parent().addClass('d-block').removeClass('d-none');
                }
                else {
                    blk.parent().removeClass('d-block').addClass('d-none')
                }
            });

        });

        $(editor).on('click', '#renderZoneWidgets', function(e) {

            // console.log('render widgets')

            let toolbar = $(editor).find('.toolbar-element');
            let uuid = getTheWidgetId( toolbar );

            let node = e.relatedTarget;
            if (e.relatedTarget == null) {
                node = sortable_renderer.get(0);
            }

            if (sortable_renderer.get(0).contains(node) == true) {
                $(editor).find('.js-no-bloc-selected').removeClass('d-none').addClass('d-block');
                $('#pills-global-settings-tab').trigger('click');
                $('.block_settings').addClass('d-none').removeClass('d-block')
            }

            // console.log('data element', uuid)
            $(editor).trigger('editor:toolbar:destroy', {
                uuid: uuid
            });

            $(editor).attr('data-active-widget', '');


        })

        sortable_renderer.on('click', '.visual_element_block', function (e) {
            e.preventDefault();

            $('.visual_element_block').not($(this)).removeClass('active-widget');
            if (e.target === e.currentTarget) {
                // do something
                e.stopPropagation();
            }

            $(this).addClass('active-widget');
            // console.log('visual block', e)
            let uuid = getTheWidgetId( $(this) );

            $(editor).attr('data-active-widget', uuid);

            // console.log('data element', uuid)
            $(editor).trigger('editor:toolbar:create', {
                uuid: uuid
            });

            $(editor).trigger('editor:widget:show', {
                uuid: uuid
            });

            $(editor).trigger('editor:sidebar:show', {
                sidebar: $(editor).find('.sidebar_controls'),
                btn: $(editor).find('.js-sidebar[data-handle=".sidebar_controls"]')
            });

            $(editor).trigger('editor:render:redraw', {
                render_zone: $(editor).find('.render_zone'),
                uuid: uuid
            })

            $('#pills-blocs-settings-tab').trigger('click');

        })

        $(editor).on('editor:render:redraw', function (i, detail) {


            // console.log('active', $(sidebar_widgets).hasClass('active'), detail)
            if ($(sidebar_widgets).hasClass('active')) {
                detail.render_zone.css({
                    'padding-left': $(sidebar_widgets).outerWidth(true) + 'px'
                })
            } else {
                detail.render_zone.css({
                    'padding-left': ''
                })
            }

            if(detail.topbar) {
                let wH = $(window).height();
                let hT = detail.topbar.outerHeight(true);
                detail.render_zone.css({
                    'padding-top' : hT+'px',
                });
            }

            if ($(sidebar_controls).hasClass('active')) {
                detail.render_zone.css({
                    'padding-right': $(sidebar_controls).outerWidth(true) + 'px'
                })
            } else {
                detail.render_zone.css({
                    'padding-right': ''
                })
            }

        });

        $(editor).on('editor:toolbar:create', function(e, detail) {

            let toolbar_obj = findToolbar( detail.uuid );
            // console.log(toolbar_obj, $(this));

            let check = $(this).find('.toolbar[data-visual-element="'+ toolbar_obj.name +'"]');

            $(this).find('.toolbar').not(check).remove();

            if(check.length == 0) {
                $(this).find('.render_zone .container').append(toolbar_obj.html);

                // update for css
                check = $(this).find('.toolbar[data-visual-element="'+ toolbar_obj.name +'"]');
                let visualElement = getVisualElement( toolbar_obj.name );
                let actions = getActionNames( detail.uuid );

                check.css({
                    top: (visualElement.offset().top  ) - ($('.title_zone').outerHeight(true) ),
                    left : visualElement.offset().left
                })

                $.each(actions, function(i, actionStr) {
                    doAction('check-'+actionStr, toolbar_obj.name , check.find('[data-action="'+ actionStr +'"]') )
                    doAction('make-tooltip', toolbar_obj.name, check.find('[data-action="'+ actionStr +'"]'))
                })
            }
        });

        $(editor).on('editor:toolbar:destroy', function(e, detail) {
            let toolbar_obj = findToolbar( detail.uuid );
            let check = $(this).find('.toolbar[data-visual-element="'+ toolbar_obj.name +'"]');
            if(check.length > 0) {
                $(this).find('.toolbar[data-visual-element="'+ toolbar_obj.name +'"]').remove();
            }
        });

        $(editor).trigger('editor:ready', {
            el: editor,
            controls: sidebar_controls,
            widgets: sidebar_widgets,
            sortable_widgets_js: sortable_widgets_js,
            sortable_renderer_js: sortable_renderer_js
        });



        $(editor).on('editor:template:call', function (e, detail) {
            // console.log('detail tpl', detail)
            addWidget( $(editor) , detail.widget, detail.datas);
        });

        $(editor).on('editor:sidebar:show', function (e, detail) {

            $(detail.sidebar).css({
                'top': $(editor).find('.editor-topbar').outerHeight(true) + 'px'
            })

            $(detail.sidebar).addClass('active');

            detail.btn.addClass('active');
        });

        $(editor).on('editor:sidebar:hide', function (e, detail) {
            $(detail.sidebar).removeClass('active');

            detail.btn.removeClass('active');
        });

        $(editor).on('editor:widget:show', function (e, detail) {

            let active_setting_block = $('.block_settings[data-uuid="' + detail.uuid + '"]');
            let setting_blocks = $('.block_settings').not(active_setting_block);

            setting_blocks.addClass('d-none').removeClass('d-block');
            active_setting_block.removeClass('d-none').addClass('d-block');

            $(editor).find('.js-no-bloc-selected').addClass('d-none').removeClass('d-block');
        });

        $(editor).on('editor:widget:settings:create', function (e, detail) {
            let wrap = '<div class="block_settings d-block" data-uuid="' + detail.uuid + '">' + detail.settings + '</div>';
            sidebar_controls.find('#blocs-settings-tab').append(wrap);

            sidebar_controls.find('#blocs-settings-tab form > .form-group').children().removeAttr('name')
        });

        $(editor).on('editor:widget:block:create', function (e, detail) {

            // console.log('editor:widget:block:create', detail)
            let chooseTpl = '';
            let element = sortable_renderer;
            if (detail.haveChooseTemplate) {
                chooseTpl = detail.choose;
            }

            let wrap = chooseTpl + '' + detail.render;

            if(detail.parent_uuid) {
                element = element.find('.visual_element_block[data-visual-element="'+ detail.parent_uuid +'"]');
            }
            element.append(wrap);
        });

        $(editor).on('editor:create:sortable', function(e, detail) {
            // console.log('detail from sortable', detail)

            let zone = detail.element ? detail.element : $(this).find('.visual_element_block[data-visual-element="'+ detail.uuid +'');

            // console.log(zone);
            let sortable = createSortableZone( zone.get(0) , {
                handle: '.visual_element_block',
                group: 'shared',
                animation: 150,
                onAdd: onAddToRenderer,
                fallbackOnBody: true,
		        swapThreshold: 0.65
            });
        });

        $(editor).on('editor:prepare:toolbar', function(e, detail) {

            window.toolbars.push({
                'name' : detail.uuid,
                'html' : detail.toolbar,
                'type' : detail.widgetType
            })

        })

        $(editor).on('editor:widget:new', function (e, detail) {
            // console.log('details', detail, e);
            $(e.target).trigger('editor:widget:settings:create', detail.config);
            $(e.target).trigger('editor:widget:block:create', detail.config);

            $(e.target).trigger('editor:prepare:toolbar', detail.config);
            $(e.target).trigger('editor:widget:show', detail.config)

            if(detail.config.allowChildsNesting) {
                $(e.target).trigger('editor:create:sortable', detail.config)
            }


            $(e.target).trigger('editor:sidebar:show', {
                sidebar: $(editor).find('.sidebar_controls'),
                btn: $(editor).find('.js-sidebar[data-handle=".sidebar_controls"]')
            });

            $(e.target).trigger('editor:sidebar:hide', {
                sidebar: $(editor).find('.sidebar_widgets'),
                btn: $(editor).find('.js-sidebar[data-handle=".sidebar_widgets"]')
            });


            $(editor).trigger('editor:render:redraw', {
                render_zone: $(editor).find('.render_zone'),
                uuid: detail.config.uuid
            })

        })

        $(editor).on('editor:change:tag', function(e, detail) {
            // console.log('tag')
            $(editor).trigger('editor:create:sortable', {
                element : detail.element
            })
        })



    })



    function onAddToRenderer(evt) {

        // console.log('add', evt);
        let editor = $(evt.to).parents('[data-editor]').first();


        let widgetType = $(evt.item).find('.js-handle').attr('data-widget');
        let isVisualElementBlock = isVisualElement( $(evt.to) );
        let o = {};

        if(isVisualElementBlock) {
            o.config = {
                child : true,
                parent_uuid : getTheWidgetId( $(evt.to) ),
                parent_widgetType: getTheWidgetType( $(evt.to) ),
            }
        }

        // console.log('o', o);

        $(evt.item).remove()

        addWidget(editor, widgetType, o);
    }

});
