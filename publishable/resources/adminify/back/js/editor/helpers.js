function getTheWidgetId(formElement) {
    let theForm = formElement.get(0).form;

    let widgetId = $(theForm).find('[name="widget_uuid"]')

    return widgetId.val();
}

function getChooserBox(formElement) {}

function addWidget(editor, widgetType, datas = {}) {

    let $d = $.extend(true, {
        config : {
            newWidget : true,
            settings : true
        }
    }, datas);

    $.ajax({
        'method' : 'POST',
        'url' : Route('editor.addWidget', {
            'widget' : widgetType
        }),
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'data' : $d
    })
    .done((response) => {
        console.log(response)

        editor.trigger('editor:widget:new', {
            el : editor,
            config : response.data
        })

    })
    .fail((err) => {
        console.log(err)
    })
}

function getTheWidgetType(formElement) {
    let theForm = formElement.get(0).form;

    let widgetType = $(theForm).find('[name="widget_type"]')

    return widgetType.val();
}

function getVisualElement(formElement) {
    let val = formElement.val();

    let wId = getTheWidgetId( formElement );

    let element = $('[data-visual-element="'+ wId +'"]').children().first();

    return element;
}

function generateMediaQuery(breakpointsList, breakpoint, ruleSet, uuid, parentAncestor) {
    // console.log(breakpointsList, breakpoint, ruleSet)

    let breakpointsKeys = Object.keys(breakpointsList);
    let indexInBreakpoints = breakpointsKeys.indexOf(breakpoint);
    let ruleMedia = '';

    if(indexInBreakpoints == 0) {
        ruleMedia = `
            @media (max-width: ${breakpointsList[breakpoint]}px) {
                ${parentAncestor} .${uuid} {
                    ${ruleSet.property}:${ruleSet.value}
                }
            }
        `;
    }
    if(indexInBreakpoints > 0 && indexInBreakpoints < (breakpointsKeys.length - 1) ) {

        let firstkeyB = breakpointsKeys[indexInBreakpoints - 1];
        let lastkeyB =breakpointsKeys[indexInBreakpoints];
        ruleMedia = `
            @media (min-width: ${breakpointsList[firstkeyB]}px) and (max-width: ${breakpointsList[lastkeyB]}px) {
                ${parentAncestor} .${uuid} {
                    ${ruleSet.property}:${ruleSet.value}
                }
            }
        `;

    }
    if(indexInBreakpoints == (breakpointsKeys.length - 1)) {
        ruleMedia = `
            @media (min-width: ${breakpointsList[breakpoint]}px) {
                ${parentAncestor} .${uuid} {
                    ${ruleSet.property}:${ruleSet.value}
                }
            }
        `;
    }

    return ruleMedia;
}

function removeStyledComponentStyles(selector, objectOptions = {}) {
    let check = $(document.head).find(selector);
    if(check.length > 0) {
        check.remove();
        // '.styled_components_block[data-rule="'+ objectOptions.rule.property +'"][data-breakpoint="'+objectOptions.breakpoint+'"][data-uuid="'+objectOptions.uuid+'"][data-type="'+objectOptions.widgetType+'"]'
    }
}

function generateCss(objectOptions) {

    // console.log('objectOptions', objectOptions)
    // console.log('editor', editorConfig.breakpoints);
    let rule = '';
    let parentSelector = '';
    // [data-breakpoint="'+objectOptions.breakpoint+'"][data-uuid="'+objectOptions.uuid+'"]
    // console.log('check', check)
    removeStyledComponentStyles('.styled_components_block[data-rule="'+ objectOptions.rule.property +'"][data-breakpoint="'+objectOptions.breakpoint+'"][data-uuid="'+objectOptions.uuid+'"][data-type="'+objectOptions.widgetType+'"]', objectOptions);

    if(objectOptions.parentSelector && objectOptions.parentSelector != false) {
        parentSelector = objectOptions.parentSelector;
    }

    if(objectOptions.breakpoint != false) {
        rule = generateMediaQuery(editorConfig.breakpoints, objectOptions.breakpoint, objectOptions.rule, objectOptions.uuid,  parentSelector);
    }
    else {
        rule = `${parentSelector} .${objectOptions.uuid} {
            ${objectOptions.rule.property}:${objectOptions.rule.value}
        }`;
    }

    let styleBlock = `<style class="styled_components_block" data-rule="${objectOptions.rule.property}" data-breakpoint="${objectOptions.breakpoint}" data-type="${objectOptions.widgetType}" data-uuid="${objectOptions.uuid}">
        ${rule}
    </style>`;

    $(document.head).append(styleBlock);
}

function formatAttributes(element) {
    var el = $(element);
    var obj = {};
    $(el[0].attributes).each(function() {
        obj[this.nodeName] = this.nodeValue;
    });

    return obj;
}

function renderAttributes(object) {
    let str = '';
    let keys = Object.keys(object);

    $.each(keys, function(i, key) {
        str += ''+ key +'="'+ object[key] +'" ';
    });

    return str;
}

function formatStyleAsObject(element) {
    var style = element.attr('style');
    var o = {}

    if(style == null) {
        return {};
    }

    var stylespl = style.split(';');


    if(stylespl.length > 0) {
        $.each(stylespl, function(i, styleStr) {

            if(styleStr != '') {
                let localStyleSpl = styleStr.split(':');

                o[localStyleSpl[0].trim()] = localStyleSpl[1].trim();
            }

        })
    }



    return o;
}

window.formatStyleAsObject = formatStyleAsObject;
window.getVisualElement = getVisualElement;
window.getTheWidgetId = getTheWidgetId;
window.getTheWidgetType = getTheWidgetType;
window.generateCss = generateCss;
window.generateMediaQuery = generateMediaQuery;
window.formatAttributes = formatAttributes;
window.renderAttributes = renderAttributes;
window.removeStyledComponentStyles = removeStyledComponentStyles;
window.getChooserBox = getChooserBox;
window.addWidget = addWidget;
