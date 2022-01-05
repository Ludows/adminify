$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    console.log('Hello from Gallery Widget !')

    editor.on('editor:chooserbox:appended', function(e, details) {

        // console.log(details)

        if(details.widgetType != 'GalleryWidget') {
            return false;
        }
        let uuid = details.uuid;
        let wType = details.widgetType;
        let chooserBox = getChooseBox(uuid);
        let settingBlock = getSettingBlock(uuid);
        let imgSrc = settingBlock.find('[data-editor-track="chooseGallery"]');
        // console.log('chooserBox Row', chooserBox)

        chooserBox.on('click', '[data-editor-choose]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            imgSrc.prev().trigger('click');
        })
    })

    editor.on('lfm:shareSelectedItems', function(e, details) {

        console.log(e);
        let wType = getTheWidgetType( $(e.target) )
        let uuid = getTheWidgetId( $(e.target) )

        if(wType != 'GalleryWidget') {
            return false;
        }

        let visual = getVisualElement(uuid);
        let activeWidgetId = editor.attr('data-active-widget');

        if(details.items.length > 0 && visual.children().length == 0) {

            $.each(details.items, function(i, item) {
                addWidget(editor, 'ImageWidget', {
                    'config': {
                        'child' : true,
                        'parent_uuid' : uuid,
                        'parent_widgetType' : wType,
                        'url' : item.url,
                        'disable_choose' : true
                    }
                });
            })

        }
        else {
            visual = getVisualElement(activeWidgetId);

            doAction('dochangesrc', activeWidgetId, visual.find('img'), {
                'src' : details.items[0].url
            })
        }

        // if(details.items.length > 0) {
        //     visual.find('img').removeAttr('src');
        //     visual.find('img').attr({
        //         'src' : details.items[0].url
        //     });
        // }

        editor.trigger('editor:chooserbox:remove', {
            'uuid' : uuid
        })
    })

});
