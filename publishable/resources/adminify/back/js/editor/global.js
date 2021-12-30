$(document).on('editor:register:actions', function(e, details) {
    let editor = $(details.el);

    registerAction('gotoparent', function(editor, visual, widgetId, actionEl) {
        visual.parent().trigger('click');
    });

    // registerAction('deletecolumn', function(editor, visual, widgetId, actionEl) {
    //     removeWidget(widgetId);
    // });

    registerAction('delete', function(editor, visual, widgetId, actionEl) {
        removeWidget(widgetId);
    });

    registerAction('morecolumn', function(editor, visual, widgetId, actionEl) {

        var childrens = visual.parent().children();
            if(childrens.length < window.editorConfig.patterns.max_columns) {
                actionEl.removeAttr('disabled');

                addWidget(editor, 'ColumnWidget', {
                    config : {
                        child : true,
                        parent_uuid : getTheWidgetId(visual.parent()),
                        parent_widgetType : getTheWidgetType(visual.parent())
                    }
                });
            }

            doAction('check-morecolumn', widgetId, actionEl)

    });

    registerAction('sidebar-open:sidebar_domthree', function(editor, visual, widgetId, actionEl) {
        let List = getListDomThree();
        let rendererList = getDomThreeHtml(List);
        // console.log('list render', rendererList);

        editor.find('.sidebar_domthree').html('').html(rendererList)
    })

    registerAction('sidebar-close:sidebar_domthree', function(editor, visual, widgetId, actionEl) {
        console.log('sidebar-close:sidebar_domthree')
    })

    registerAction('make-tooltip', function(editor, visual, widgetId, actionEl) {
        actionEl.tooltip({
            html : true,
            trigger: 'hover'
        });
    })

    registerAction('check-morecolumn', function(editor, visual, widgetId, actionEl) {
        var childrens = visual.parent().children();
            // console.log('childrens', childrens, actionEl)
            if(childrens.length < window.editorConfig.patterns.max_columns) {
                actionEl.removeAttr('disabled');
            }
            if(childrens.length >= window.editorConfig.patterns.max_columns) {
                actionEl.attr('disabled', 'disabled');
            }
    })

    registerAction('moreblock', function(editor, visual, widgetId, actionEl) {
        let handle = ".sidebar_widgets";

        let sibling = $(editor).find('.editor-topbar .js-sidebar[data-handle="'+ handle +'"]');

        sibling.trigger('click');

        editor.find('#renderZoneWidgets').trigger('click')
    });

    registerAction('modify', function(editor, visual, widgetId, actionEl) {

        let dataTemplate = $(visual).attr('data-template');
        console.log('dataTemplate', dataTemplate)

        let r = Route('templates.edit', {
            'template' : dataTemplate
        })

        window.open(r, '_blank');

    })

    registerAction('duplicate', function(editor, visual, widgetId, actionEl) {
        console.log('duplicate todo');
    })

    registerAction('preview', function(editor, visual, widgetId, actionEl) {
        console.log('preview todo');
    })

})

$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    let MainForm = $(details.mainForm);
    let previousCssClass = '';
    let sortable_renderer_js = $(details.sortable_renderer);

    let checkAlreadyRenderedBlocks = sortable_renderer_js.find('.visual_element_block');

        if(checkAlreadyRenderedBlocks.length > 0) {
            $.each(checkAlreadyRenderedBlocks, function(i, checkAlreadyRenderedBlock) {
                $(editor).trigger('editor:create:sortable', {
                    element : $(checkAlreadyRenderedBlock)
                })
            })
        }

    let aReady = editor.find('#blocs-settings-tab').append(alreadyBlocks)


    let titleBlock = $(details.titleBlock);
    let titleForm = $(MainForm).find('[name="title"]');

    if(titleForm.hasClass('is-invalid')) {
        titleBlock.addClass('d-block').addClass('invalid-feedback').addClass('is-required');
        titleForm.next('.invalid-feedback').css({
            'display' : 'none'
        });

        editor.find('.js-sidebar[data-handle=".sidebar_controls"]').trigger('click');
    }

    editor.trigger('resize');

    editor.on('change', '[data-editor-track="tag"]', function(e) {
       let val = $(this).val();

       let wId = getTheWidgetId( $(this) );
       let element = getVisualElement( wId )

       let format = formatAttributes( element );
       let strAttribs = renderAttributes(format);

       let sInstance = Sortable.get( element.get(0) );

       // destroy the instance of the sortable
       if(sInstance != null) {
         sInstance.destroy()
       }

       element.replaceWith('<'+ val +' '+ strAttribs +'>'+ element.html() +'</'+ val +'>');

       // update element due to dom structure update..
       element = getVisualElement( wId )

       editor.trigger('editor:change:tag', {
           element : element
       });

    });


    editor.on('change', '[data-editor-track="textTransform"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'text-transform',
                value : val
            }
        });
     });

     editor.on('change', '[data-editor-track="bgImage"]', function(e) {
        //alert(true)
        let val = $(this).parent().find('.img-fluid').attr('src');

        let wType = getTheWidgetType( $(this) );
        let wId = getTheWidgetId( $(this) );

        if(val) {
            generateCss({
                uuid : wId,
                widgetType: wType,
                breakpoint : false, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'background-image',
                    value : 'url('+val+')'
                }
            });
        }
        else {
            removeStyledComponentStyles('.styled_components_block[data-rule="background-image"][data-breakpoint="false"][data-uuid="'+wId+'"][data-type="'+wType+'"]');
        }


     });

     editor.on('input', '[data-editor-track="column_width"]', function(e) {
        let val = $(this).val();

        let pattern = window.editorConfig.patterns.columns;
        let column_minimal =  window.editorConfig.patterns.column_minimal;
        let column_maximal =  window.editorConfig.patterns.column_maximal;
        let element = getVisualElement( $(this) )

        // on nettoie la classe courante globale

        for (let index = column_minimal; index <= column_maximal; index++) {

            let global_class_pattern = pattern.replace('-##BREAKPOINT##', '');
            global_class_pattern = global_class_pattern.replace('##WIDTH##', index);

            if(element.hasClass(global_class_pattern)) {
                element.removeClass(global_class_pattern);
            }
        }

        let new_class_pattern = pattern.replace('-##BREAKPOINT##', '');
        new_class_pattern = new_class_pattern.replace('##WIDTH##', val)

        element.addClass(new_class_pattern);

     });

     editor.on('input', '[data-editor-track="bgColor"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-color',
                value : val
            }
        });
     });

     editor.on('change', '[data-editor-track="bgPositionImage"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-position',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="contentPosition"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'justify-content',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="contentAlignPosition"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'align-items',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="bgSizeImage"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-size',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="bgType"]', function(e) {
        let val = $(this).val();
        let form = $(this).get(0).form;
        let selectors = [];
        let selectorsToHide = [];
        let rule_set = [];

        let wId = getTheWidgetId( $(this) );
        let wType = getTheWidgetType( $(this) );

        switch (val) {
            case 'no-bg':
                selectorsToHide = ['bgPositionImage', 'bgSizeImage', 'bgOtherSize', 'bgImage', 'bgColor'];
                rule_set = ['background-position', 'background-size', 'background-size', 'background-image', 'background-color'];
                break;
            case 'bg-color':
                selectors = ['bgColor'];
                selectorsToHide = ['bgPositionImage', 'bgSizeImage', 'bgOtherSize', 'bgImage'];
                rule_set = ['background-position', 'background-size', 'background-size', 'background-image'];
                break;
            case 'bg-image':
                selectors = ['bgPositionImage', 'bgSizeImage', 'bgImage'];
                selectorsToHide = ['bgColor'];
                rule_set = ['background-color'];
                break;
        }

        if(selectors.length > 0) {
            $.each(selectors, function(i, sel) {

                let _el = $(form).find('[data-editor-track="'+ sel +'"]');

                _el.parent().removeAttr('hidden');

                _el.trigger('input');
            })
        }

        if(selectorsToHide.length > 0) {
            $.each(selectorsToHide, function(i, sel) {
                let _el = $(form).find('[data-editor-track="'+ sel +'"]');

                _el.parent().attr('hidden', 'hidden');

                removeStyledComponentStyles('.styled_components_block[data-rule="'+ rule_set[i] +'"][data-breakpoint="false"][data-uuid="'+wId+'"][data-type="'+wType+'"]');
            })
        }
     });

     editor.on('change', '[data-editor-track="rowDirection"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'flex-direction',
                value : val
            }
        });
     });

     editor.on('change', '[data-editor-track="line_height_unit"]', function(e) {

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="line_height"]').first();

        element.trigger('change');
    });

     editor.on('change', '[data-editor-track="alignment"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'text-align',
                value : val
            }
        });
     });

    editor.on('keyup', '[data-editor-track="cssClasses"]', function(e) {
        let val = $(this).val();

        let element = getVisualElement( $(this) )

        element.removeClass(previousCssClass.trim());

        if(!element.hasClass(val.trim())) {
            element.addClass(val);
        }

        previousCssClass = val;
     });

     editor.on('input', '[data-editor-track="color"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'color',
                value : val
            }
        });

        // $(document.head).append(styleBlock);


     });

     editor.on('change', '[data-editor-track="fontsize_unit"]', function(e) {

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="fontsize"]').first();

        element.trigger('change');
    });

    editor.on('change keyup', '[data-editor-track="fontsize"]', function(e) {
        let val = $(this).val();

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="fontsize_unit"]').first();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed
            rule : {
                property : 'font-size',
                value : val+element.val()
            }
        });

    });

    editor.on('change keyup', '[data-editor-track="line_height"]', function(e) {
        let val = $(this).val();

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="line_height_unit"]').first();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed
            rule : {
                property : 'line-height',
                value : val+element.val()
            }
        });
    });


    $(editor).on('click', '.js-btn-action', function(e) {
        e.preventDefault();

        let action = $(this).attr('data-action');
        let wId = $(this).attr('data-visual-element');
        $('.tooltip').remove();
        doAction(action, wId, $(this));


    });

     // breakpoints style based components

     let breakpointsKeys = Object.keys(window.editorConfig.breakpoints);

    $.each(breakpointsKeys, function(i, breakpoint) {

        editor.on('input', '[data-editor-track="column_width_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let pattern = window.editorConfig.patterns.columns;
            let column_minimal =  window.editorConfig.patterns.column_minimal;
            let column_maximal =  window.editorConfig.patterns.column_maximal;
            let element = getVisualElement( $(this) )

            // on nettoie la classe courante globale

            for (let index = column_minimal; index <= column_maximal; index++) {

                let global_class_pattern = pattern.replace('##BREAKPOINT##', breakpoint);
                global_class_pattern = global_class_pattern.replace('##WIDTH##', index);

                if(element.hasClass(global_class_pattern)) {
                    element.removeClass(global_class_pattern);
                }
            }

            let new_class_pattern = pattern.replace('##BREAKPOINT##', breakpoint);
            new_class_pattern = new_class_pattern.replace('##WIDTH##', val)

            element.addClass(new_class_pattern);

         });

        editor.on('change', '[data-editor-track="fontsize_unit_'+ breakpoint +'"]', function(e) {

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="fontsize_'+ breakpoint +'"]').first();

            element.trigger('change');
        });

        editor.on('change', '[data-editor-track="rowDirection_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'flex-direction',
                    value : val
                }
            });
         });

         editor.on('change', '[data-editor-track="contentPosition_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'justify-content',
                    value : val
                }
            });
         });

         editor.on('change', '[data-editor-track="contentAlignPosition_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'align-items',
                    value : val
                }
            });
         });

        editor.on('change', '[data-editor-track="alignment_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'text-align',
                    value : val
                }
            });


         });

         editor.on('change', '[data-editor-track="line_height_unit_'+ breakpoint +'"]', function(e) {

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="line_height_'+ breakpoint +'"]').first();

            element.trigger('change');
        });

         editor.on('change keyup', '[data-editor-track="line_height_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="line_height_unit_'+ breakpoint +'"]').first();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed
                rule : {
                    property : 'line-height',
                    value : val+element.val()
                }
            });


        });

        editor.on('change keyup', '[data-editor-track="fontsize_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="fontsize_unit_'+ breakpoint +'"]').first();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed
                rule : {
                    property : 'font-size',
                    value : val+element.val()
                }
            });



        });

    });

});
