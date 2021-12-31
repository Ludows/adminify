$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    console.log('Hello from Template Widget !')

    editor.on('editor:chooserbox:appended', function(e, details) {

        if(details.widgetType != 'TemplateWidget') {
            return false;
        }

        let chooserBox = getChooseBox(details.uuid);

        // console.log('chooserBox Row', chooserBox)

        chooserBox.on('input', '[data-editor-choose]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            renderTpl( $(this),  chooserBox );

            editor.trigger('editor:chooserbox:remove', {
                'uuid' : details.uuid
            })
        })


    })


    function renderTpl( elementScope, ChooseBox ) {

        let $wId = getTheWidgetId( elementScope );

        let $wType = getTheWidgetType( elementScope );
        let visual = getVisualElement( $wId );

        let inp = ChooseBox.find('[name="chooseTpl"]');
        // addTemplate(editor, )
        addTemplate(editor, inp.val() , {
            datas: {
                config: {
                    child: true,
                    parent_uuid : $wId,
                    parent_widgetType: $wType,
                }
            }
        })

        visual.attr('data-template', inp.val());
    }

});
