$(document).on('editor:ready', function(e, details) {
    console.log('ready title', details)
    let editor = $(details.el);
    let previousCssClass = '';

    editor.on('change', '[data-editor-track="tag"]', function(e) {
       let val = $(this).val();
       let element = getVisualElement( $(this) )

       let format = formatAttributes( element );
       let strAttribs = renderAttributes(format);

       element.replaceWith('<'+ val +' '+ strAttribs +'>'+ element.html() +'</'+ val +'>');

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

        let format = formatAttributes( element );

        element.removeClass(previousCssClass.trim());

        if(!element.hasClass(val.trim())) {
            element.addClass(val);
        }

        previousCssClass = val;
        // element.attr('class', '');
        // element.attr('class', format.class);
     });

     editor.on('change', '[data-editor-track="color"]', function(e) {
        let val = $(this).val();

        let element = getVisualElement( $(this) )

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


     // breakpoints style based components

     let breakpointsKeys = Object.keys(window.editorConfig.breakpoints);

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


    $.each(breakpointsKeys, function(i, breakpoint) {

        editor.on('change', '[data-editor-track="fontsize_unit_'+ breakpoint +'"]', function(e) {

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="fontsize_'+ breakpoint +'"]').first();

            element.trigger('change');
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
