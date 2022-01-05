const { after } = require("lodash");

$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    console.log('Hello from Image Widget !')

    editor.on('editor:chooserbox:appended', function(e, details) {

        // console.log(details)

        if(details.widgetType != 'ImageWidget') {
            return false;
        }
        let uuid = details.uuid;
        let wType = details.widgetType;
        let chooserBox = getChooseBox(uuid);
        let settingBlock = getSettingBlock(uuid);
        let imgSrc = settingBlock.find('[data-editor-track="imageSrc"]');
        // console.log('chooserBox Row', chooserBox)

        chooserBox.on('click', '[data-editor-choose]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            imgSrc.prev().trigger('click');
        })

    })

    editor.on('lfm:shareSelectedItems', function(e, details) {

        let wType = getTheWidgetType( $(e.target) )
        let uuid = getTheWidgetId( $(e.target) )

        if(wType != 'ImageWidget') {
            return false;
        }

        let visual = getVisualElement(uuid);

        console.log(visual)

        if(details.items.length > 0) {
            doAction('dochangesrc', getTheWidgetId(visual), visual.find('img'), {
                'src' : details.items[0].url
            })
        }

        editor.trigger('editor:chooserbox:remove', {
            'uuid' : uuid
        })
    })

    // editor.on('editor:click:childOfVisualElementBlock', function(e, details) {
    //     console.log('details', details);

    //     // let wId = getTheWidgetId(details.visual);
    //     // let settingBlock = getSettingBlock(wId);
    //     // let imgSrc = settingBlock.find('[data-editor-track="imageSrc"]');

    //     // if(details.widgetType != 'ImageWidget') {
    //     //     return false;
    //     // }

    //     // imgSrc.prev().trigger('click');

    // })

});
