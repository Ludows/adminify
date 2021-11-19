function getTheWidgetId(formElement) {
    let theForm = formElement.get(0).form;

    let widgetId = $(theForm).find('[name="widget_uuid"]')

    return widgetId.val();
}

function getVisualElement(formElement) {
    let val = formElement.val();

    let wId = getTheWidgetId( formElement );

    let element = $('[data-visual-element="'+ wId +'"]').children().first();

    return element;
}

function formatStyleAsObject(element) {
    var style = element.attr('style');
    var o = {}

    if(style == null) {
        return {};
    }

    var stylespl = style.split(';');

    $.each(stylespl, function(i, styleStr) {

        let localStyleSpl = styleStr.split(':');

        o[localStyleSpl[0].trim()] = localStyleSpl[1].trim();
    })

    return o;
}

window.formatStyleAsObject = formatStyleAsObject
window.getVisualElement = getVisualElement
window.getTheWidgetId = getTheWidgetId
