$(document).on('editor:ready', function(e, details) {
   console.log('ready title', details)
   let editor = $(details.el);

   editor.on('change', '[name="tag"]', function(e) {
      let val = $(this).val();
      let element = getVisualElement( $(this) )

      element.replaceWith('<'+ val +' class="'+ element.attr('class') +'">'+ element.html() +'</'+ val +'>');

   });

   editor.on('change', '[name="textTransform"]', function(e) {
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

    editor.on('change', '[name="line_height_unit"]', function(e) {

       let form = $(this).get(0).form;

       let element = $(form).find('[name="line_height"]').first();

       element.trigger('change');
   });

    editor.on('change', '[name="alignment"]', function(e) {
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

   editor.on('keyup', '[name="cssClasses"]', function(e) {
       let val = $(this).val();

       let element = getVisualElement( $(this) )

       element.attr('class', '');
       element.addClass(val).addClass(getTheWidgetId( $(this) ));
    });

    editor.on('change', '[name="color"]', function(e) {
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

       $(document.head).append(styleBlock);


    });


    // breakpoints style based components

    let breakpointsKeys = Object.keys(window.editorConfig.breakpoints);

    editor.on('change', '[name="fontsize_unit"]', function(e) {

       let form = $(this).get(0).form;

       let element = $(form).find('[name="fontsize"]').first();

       element.trigger('change');
   });

   editor.on('change keyup', '[name="fontsize"]', function(e) {
       let val = $(this).val();

       let form = $(this).get(0).form;

       let element = $(form).find('[name="fontsize_unit"]').first();

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

   editor.on('change keyup', '[name="line_height"]', function(e) {
       let val = $(this).val();

       let form = $(this).get(0).form;

       let element = $(form).find('[name="line_height_unit"]').first();

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

       editor.on('change', '[name="fontsize_unit_'+ breakpoint +'"]', function(e) {

           let form = $(this).get(0).form;

           let element = $(form).find('[name="fontsize_'+ breakpoint +'"]').first();

           element.trigger('change');
       });

       editor.on('change', '[name="alignment_'+ breakpoint +'"]', function(e) {
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

        editor.on('change', '[name="line_height_unit_'+ breakpoint +'"]', function(e) {

           let form = $(this).get(0).form;

           let element = $(form).find('[name="line_height_'+ breakpoint +'"]').first();

           element.trigger('change');
       });

        editor.on('change keyup', '[name="line_height_'+ breakpoint +'"]', function(e) {
           let val = $(this).val();

           let form = $(this).get(0).form;

           let element = $(form).find('[name="line_height_unit_'+ breakpoint +'"]').first();

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

       editor.on('change keyup', '[name="fontsize_'+ breakpoint +'"]', function(e) {
           let val = $(this).val();

           let form = $(this).get(0).form;

           let element = $(form).find('[name="fontsize_unit_'+ breakpoint +'"]').first();

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
