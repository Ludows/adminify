function getTheWidgetId(mixed) {

    let widgetId = null;
    if(mixed.get(0).hasAttribute('data-visual-element')) {
        widgetId = mixed.attr('data-visual-element');
    }
    else {
        let theForm = mixed.get(0).form;

        widgetId = $(theForm).find('[name="widget_uuid"]').val();
    }


    return widgetId;
}

function getChooserBox(formElement) {}

function createSortableZone(elm, options) {
   return new Sortable(elm, options);
}

function isVisualElement(element) {
    return element.get(0).hasAttribute('data-visual-element');
}

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
        $.each(response.data, function(i, data) {
            editor.trigger('editor:widget:new', {
                el : editor,
                config : data
            })
        })
        // console.log('last')
        setTimeout(() => {
            $('#pills-blocs-settings-tab').trigger('click');
        }, 200)

    })
    .fail((err) => {
        console.log(err)
    })
}

function getTheWidgetType(mixed) {

    let widgetType = null;
    if(mixed.get(0).hasAttribute('data-type')) {
        widgetType = mixed.attr('data-type');
    }
    else {
        let theForm = mixed.get(0).form;

        widgetType = $(theForm).find('[name="widget_type"]').val();
    }

    return widgetType;
}

function getVisualElement(formElement) {
    let val = formElement.val();

    let wId = getTheWidgetId( formElement );

    let element = $('[data-visual-element="'+ wId +'"]');

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
window.createSortableZone = createSortableZone;
window.isVisualElement = isVisualElement;
