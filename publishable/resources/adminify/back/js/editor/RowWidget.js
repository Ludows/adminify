$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    // console.log('Hello from Row Widget !')

    editor.on('editor:chooserbox:appended', function(e, details) {

        if(details.widgetType == 'RowWidget') {
            let chooserBox = getChooseBox(details.uuid);

            console.log('chooserBox Row', chooserBox)

            chooserBox.on('click', '[data-editor-choose]', function(e) {
                e.preventDefault();
                e.stopPropagation();

                renderCols( $(this) );

                editor.trigger('editor:chooserbox:remove', {
                    'uuid' : details.uuid
                })
            })
        }

    })

    function renderCols( elementScope ) {
        let $wId = getTheWidgetId( elementScope );

        let $wType = getTheWidgetType( elementScope );

        editor.trigger('editor:template:call', {
            element: elementScope,
            widget: elementScope.attr('data-widget'),
            datas: {
                config: {
                    child: true,
                    count : elementScope.attr('data-count'),
                    parent_uuid : $wId,
                    parent_widgetType: $wType,
                }
            }
        })
    }

});
