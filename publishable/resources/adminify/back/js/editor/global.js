$(document).on('editor:ready', function(e, details) {
    console.log('ready title', details)
    let editor = $(details.el);

    editor.on('change', '[name="tag"]', function(e) {
       let val = $(this).val();
       let element = getVisualElement( $(this) )
       let style = element.attr('style');

       let styleAttr = '';

       if(style != null) {
            styleAttr = 'style="'+ style +'"';
       }

       element.replaceWith('<'+ val +' '+ styleAttr +'>'+ element.html() +'</'+ val +'>');

    });

    editor.on('keyup', '[name="cssClasses"]', function(e) {
        let element = getVisualElement( $(this) )

        element.attr('class', '');
        element.addClass(val);
     });

     editor.on('change', '[name="color"]', function(e) {
        let val = $(this).val();

        let element = getVisualElement( $(this) )

        let styledComponent = formatStyleAsObject(element);

        // element.removeAttr('style');

        styledComponent.color = val;

        // console.log(styledComponent);

        element.css(styledComponent);

     });
});
