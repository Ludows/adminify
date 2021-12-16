function getTheWidgetId(mixed) {

    let widgetId = null;
    if(typeof mixed == 'string') {
        widgetId = mixed;
    }
    else {
        if(mixed.get(0).hasAttribute('data-visual-element')) {
            widgetId = mixed.attr('data-visual-element');
        }
        else {
            let theForm = mixed.get(0).form;

            widgetId = $(theForm).find('[name="widget_uuid"]').val();
        }
    }

    return widgetId;
}

function findToolbar(uuid) {
    let ret = null;

    $.each(window.toolbars, function(i, toolbar) {
        if(toolbar.name === uuid) {
            ret = toolbar;
            return false;
        }
    });

    return ret;
}

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

function doAction(actionName, widgetId, actionEl = null) {

    let visual = getVisualElement(widgetId);
    let editor = visual.parents('[data-editor]').first();

    switch (actionName) {
        case 'gotoparent':
            visual.parent().trigger('click');
            break;
        case 'deletecolumn':
            break;
        case 'morecolumn':
            var childrens = visual.parent().children();
            if(childrens.length < window.editorConfig.patterns.max_columns) {
                actionEl.removeAttr('disabled');

                addWidget(editor, 'ColumnWidget', {
                    config : {
                        child : true,
                        parent_uuid : getTheWidgetId(visual.parent()),
                        parent_widgetType : getTheWidgetType(visual.parent())
                    }
                });
            }

            doAction('check-morecolumn', widgetId, actionEl)
            //update after creation

            break;
        case 'check-morecolumn':
            var childrens = visual.parent().children();
            // console.log('childrens', childrens, actionEl)
            if(childrens.length < window.editorConfig.patterns.max_columns) {
                actionEl.removeAttr('disabled');
            }
            if(childrens.length >= window.editorConfig.patterns.max_columns) {
                actionEl.attr('disabled', 'disabled');
            }
        break;
        default:
            console.log('action type not recongnized: '+actionName);
            break;
    }


}

function getActionNames(uuid) {

    let actionTypes = []
    let tollbar = $('.toolbar[data-visual-element="'+ uuid +'"]')
    let actions = tollbar.find('[data-action]');

    $.each(actions, function(i, action) {
        actionTypes.push( $(action).attr('data-action') )
    });

    return actionTypes;
}

function getVisualElement(mixed) {
    let val = typeof mixed == 'string' ? mixed : mixed.val();

    if(val == null) {
        val = mixed;
    }

    let wId = getTheWidgetId( val );

    let element = $('.visual_element_block[data-visual-element="'+ wId +'"]');

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

function agregateForPublish(object = {}) {


    return {
        formData : getFormDatas(),
        css : getRuleSets(),
        js : getDynamicJS()
    }
}

function getRuleSets() {
    let a = [];

    let keysBreakpoints = Object.keys(window.editorConfig.breakpoints);

    // false is to bind styles with no breakpoints
    let rules = [false, ...keysBreakpoints];

    $.each(rules, function(i, ruleName) {

        let styledComponents = $('.styled_components_block[data-breakpoint="'+ ruleName +'"]');

        if(styledComponents.length > 0) {
            $.each(styledComponents, function(k, styleBlock) {

                let _el = $(styleBlock);
                a.push({
                   rule : _el.attr('data-rule'),
                   breakpoint : _el.attr('data-breakpoint'),
                   uuid : _el.attr('data-uuid'),
                   uuid : _el.attr('data-uuid'),
                   widgetType: _el.attr('data-type'),
                   styles : _el.html()
                });
            });
        }

    })

    console.log('a', a);
    return a;
}
function getDynamicJS() {}
function getHtmlRendered() {
    return $('#renderZoneWidgets').html().trim();
}
function getFormDatas() {
    let the_form = $('#MainFormEditor');

    let o = the_form.serializeFormJSON();
    o.content = getHtmlRendered();

    return o;
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
window.addWidget = addWidget;
window.createSortableZone = createSortableZone;
window.isVisualElement = isVisualElement;
window.agregateForPublish = agregateForPublish;
window.getRuleSets = getRuleSets;
window.getDynamicJS = getDynamicJS;
window.getHtmlRendered = getHtmlRendered;
window.getFormDatas = getFormDatas;
window.findToolbar = findToolbar;
window.doAction = doAction;
window.getActionNames = getActionNames;
