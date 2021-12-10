$(document).on('editor:ready', function(e, details) {
    console.log('ready title', details)
    let editor = $(details.el);
    let previousCssClass = '';

    editor.on('change', '[data-editor-track="tag"]', function(e) {
       let val = $(this).val();
       let element = getVisualElement( $(this) )

       let format = formatAttributes( element );
       let strAttribs = renderAttributes(format);

       let sInstance = Sortable.get( element.get(0) );

       // destroy the instance of the sortable
       sInstance.destroy()

       element.replaceWith('<'+ val +' '+ strAttribs +'>'+ element.html() +'</'+ val +'>');

       // update element due to dom structure update..
       element = getVisualElement( $(this) )

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

        // generateCss({
        //     uuid : getTheWidgetId( $(this) ),
        //     widgetType: getTheWidgetType( $(this) ),
        //     breakpoint : false, // set as false when no breakpoint css generation is needed,
        //     rule : {
        //         property : 'text-transform',
        //         value : val
        //     }
        // });
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
