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

function registerAction(name, func) {
    if(actions[name] == null) {
        actions[name] = func;
    }
}


function getDomThreeHtml(domThreeObject) {
    let checkThree = Object.keys(domThreeObject);
    let ret = null;
    if(checkThree.length > 0) {
        ret = renderDomThree(domThreeObject);
    }
    else {
        ret = `<div class="alert alert-info" role="alert">
                ${ __('admin.editor.noItemsInDom') }
               </div>`;
    }
    return ret;
}

function renderDomThree(domThreeObjectItem, isChild = false) {

    let html = isChild ? '<div class="control_stage is-child">' : '<div class="control_stage">';

    let oKeys = Object.keys(domThreeObjectItem);

    $.each(domThreeObjectItem, function(i, domThree) {
        html += '<div class="control_stage_block">'+ domThree.html.clone(true).prop('outerHTML');
        if(domThree.childs.length > 0) {
            let a = renderDomThree(domThree.childs, true);
            html += a;
        }
        html += '</div>';
    });

    html += '</div>';

    return html;
}

function getListDomThree() {
    let o = {};

    let editor = $(document).find('[data-editor]').first();

    let renderer = editor.find('#renderZoneWidgets');
    let childrens = renderer.children();

    if(childrens.length > 0) {
        $.each(childrens, function(i, children) {
           let representation = parseThree($(children));
           o[i] = representation;
        })
    }

    console.log('o', o)

    return o;
}

function getPresentationBlock(uuid) {
    return $('.media[data-visual-element="'+ uuid +'"');
}

function getChooseBox(uuid) {
    return $('.js-choose-box[data-ref="'+ uuid +'"]');
}

function parseThree(parentElement) {

    let wId = getTheWidgetId(parentElement);

    let o = {
        type : getTheWidgetType( parentElement ),
        wId: wId,
        html : getPresentationBlock( wId ),
        childs : {}
    };

    let check = parentElement.children('.visual_element_block');

    if(check.length > 0) {
        $.each(check, function(i, c) {
            let d = parseThree( $(c) );
            if(o['type'] != 'TemplateWidget') {
                o.childs[i] = d;
            }
        })
    }

    o.childs.length = Object.keys(o.childs).length;

    return o;
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

function removeWidget(uuid) {
    let visual = getVisualElement(uuid);

    visual.remove();

    let settingBlock = getSettingBlock(uuid);

    $('#renderZoneWidgets').trigger('click');

    settingBlock.remove();
}

function getSettingBlock(uuid) {
    return $('.block_settings[data-uuid="'+ uuid +'"');
}

function createSortableZone(elm, options) {
   return new Sortable(elm, options);
}

function isVisualElement(element) {
    return element.get(0).hasAttribute('data-visual-element');
}

function addTemplate(editor, tplId, datas = {}) {

    let $d = $.extend(true, {
        config : {
            newWidget : false,
            settings : false
        }
    }, datas);

    $.ajax({
        'method' : 'POST',
        'url' : Route('editor.getTemplate', {
            'id' : tplId
        }),
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'data' : {}
    })
    .done((response) => {
        console.log(response, $d.datas.config.parent_uuid)

        let visual = getVisualElement($d.datas.config.parent_uuid);
        console.log('visual', visual)

        visual.append( response.data.content );

    })
    .fail((err) => {
        console.log(err)
    })
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

    let visual = widgetId != null ? getVisualElement(widgetId) : null;
    let editor = visual != null ? visual.parents('[data-editor]').first() : $(document).find('[data-editor]').first();

    if(actions[actionName]) {
        // do the registered action
        actions[actionName](editor, visual, widgetId, actionEl);
    }
    else {
        console.log('action not recognized : '+actionName);
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
    let val = undefined;
    // we say the if as string..
    if(typeof mixed == 'string') {
        val = mixed;
    }
    //test if element is child element of a form.
    val = typeof mixed == 'string' ? mixed : mixed;

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
        html : getHtmlRendered(),
        css : getRuleSets(),
        js : ''
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
window.removeWidget = removeWidget;
window.createSortableZone = createSortableZone;
window.isVisualElement = isVisualElement;
window.agregateForPublish = agregateForPublish;
window.getRuleSets = getRuleSets;
window.getHtmlRendered = getHtmlRendered;
window.getFormDatas = getFormDatas;
window.findToolbar = findToolbar;
window.doAction = doAction;
window.getActionNames = getActionNames;
window.getSettingBlock = getSettingBlock;
window.getListDomThree = getListDomThree;
window.getDomThreeHtml = getDomThreeHtml;
window.parseThree = parseThree;
window.getPresentationBlock = getPresentationBlock;
window.registerAction = registerAction;
window.addTemplate = addTemplate;
window.getChooseBox = getChooseBox;

