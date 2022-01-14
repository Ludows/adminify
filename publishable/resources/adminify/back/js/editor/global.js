const { data } = require("jquery");

$(document).on('editor:register:actions', function(e, details) {
    let editor = $(details.el);
    window.activeParent = null;

    registerAction('gotoparent', function(editor, visual, widgetId, actionEl, datas) {
        visual.parent().trigger('click');
    });

    registerAction('moregalleryitem', function(editor, visual, widgetId, actionEl, datas) {
        addWidget(editor, 'ImageWidget', {
            config : {
                child : true,
                parent_uuid : getTheWidgetId(visual),
                parent_widgetType : getTheWidgetType(visual)
            }
        });
    });

    registerAction('delete', function(editor, visual, widgetId, actionEl, datas) {
        removeWidget(widgetId);
    });

    registerAction('changesrc', function(editor, visual, widgetId, actionEl, datas) {
        let settingBlock = getSettingBlock(widgetId);
        let imgSrc = settingBlock.find('[data-editor-track="imageSrc"]');

        imgSrc.prev().trigger('click');
    })

    registerAction('dochangesrc', function(editor, visual, widgetId, actionEl, datas) {
        actionEl.attr('src', datas.src);
    })

    registerAction('morecolumn', function(editor, visual, widgetId, actionEl, datas) {

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

    });

    registerAction('sidebar-open:sidebar_domthree', function(editor, visual, widgetId, actionEl, datas) {
        let List = getListDomThree();
        let rendererList = getDomThreeHtml(List);
        // console.log('list render', rendererList);

        editor.find('.sidebar_domthree').html('').html(rendererList)
    })

    registerAction('sidebar-close:sidebar_domthree', function(editor, visual, widgetId, actionEl, datas) {
        console.log('sidebar-close:sidebar_domthree')
    })

    registerAction('make-tooltip', function(editor, visual, widgetId, actionEl, datas) {
        actionEl.tooltip({
            html : true,
            trigger: 'hover'
        });
    })

    registerAction('check-morecolumn', function(editor, visual, widgetId, actionEl, datas) {
        var childrens = visual.parent().children();
            // console.log('childrens', childrens, actionEl)
            if(childrens.length < window.editorConfig.patterns.max_columns) {
                actionEl.removeAttr('disabled');
            }
            if(childrens.length >= window.editorConfig.patterns.max_columns) {
                actionEl.attr('disabled', 'disabled');
            }
    })

    registerAction('moreblock', function(editor, visual, widgetId, actionEl, datas) {
        let handle = ".sidebar_widgets";

        let sibling = $(editor).find('.editor-topbar .js-sidebar[data-handle="'+ handle +'"]');

        sibling.trigger('click');

        editor.find('#renderZoneWidgets').trigger('click')
    });

    registerAction('modify', function(editor, visual, widgetId, actionEl, datas) {

        let dataTemplate = $(visual).attr('data-template');

        let r = Route('templates.edit', {
            'template' : dataTemplate
        })

        window.open(r, '_blank');

    })

    registerAction('duplicate', function(editor, visual, widgetId, actionEl, datas) {
        console.log('duplicate todo', visual);

        let listInDupplicate = parseThree( visual );
        let TestParentVisual = visual.parent();
        let parentIsVisual = isVisualElement( TestParentVisual );

        let test = JSON.stringify(listInDupplicate);

        console.log('builded three', listInDupplicate, test)

        doAjax({
            method : 'POST',
            url : Route('editor.duplicate')
        }, function(err, datas) {
            if(err) {
                console.log('whoooops', err);
                return false;
            }

            console.log('datas')
        })

        // let o = {
        //     settingsBlockValues : listInDupplicate.settingsBlockFormValues,
        //     disable_choose : true,
        //     duplicate : false,
        //     url : listInDupplicate.imageSrc,
        //     tplContent : listInDupplicate.tplContent,
        //     tplId : listInDupplicate.tplId
        // }

        // if(parentIsVisual) {
        //     o['child'] = true;
        //     o['parent_uuid'] = getTheWidgetId( TestParentVisual );
        //     o['parent_widgetType'] = getTheWidgetType( TestParentVisual );
        // }


        // addWidget(editor, listInDupplicate.type, {
        //     config: o
        // }, function(response) {
        //     console.log('after first dupplicate response', response)

        //     if(listInDupplicate.childs.length > 0) {
        //         // do the loop overs childs
        //         theLoop(listInDupplicate.childs, 'childs', function(object) {

        //             window.activeParent = getActiveWidget();

        //             console.log('before childs', activeParent)
        //             // console.log('object>>>', object);
        //             addWidget(editor, object.type, {
        //                 config: {
        //                     child : true,
        //                     url : object.imageSrc,
        //                     tplContent : object.tplContent,
        //                     tplId : object.tplId,
        //                     parent_uuid : activeParent,
        //                     parent_widgetType :response.widgetType,
        //                     settingsBlockValues : object.settingsBlockFormValues,
        //                     disable_choose : true
        //                 }
        //             }, function(d) {
        //                 window.activeParent = d.uuid;
        //                 console.log('activeParent>>', activeParent)
        //                 // console.log('after child', activeParent, d)
        //             })
        //             // console.log('after childs', getActiveWidget())

        //         })
        //     }
        // })
    })

    registerAction('preview', function(editor, visual, widgetId, actionEl, datas) {
        console.log('preview todo');
    })

    registerAction('registerastemplate', function(editor, visual, widgetId, actionEl, datas) {
        console.log('registerastemplate todo');

        let content = visual.prop('outerHTML')
        // let representativeDom = parseThree(visual);


        function createModaleWithContent(content) {
            let tpl = `<div id="modaleRegisterTemplate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">${__('admin.modal_title')}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ${content}
                </div>
              </div>
            </div>
          </div>`;
            return tpl;
        }

        function getPrivateFields() {
            return `<input type="hidden" value="" name="_css" /><input type="hidden" value="" name="_js" /><input type="hidden" value="" name="_toolbars" /><input type="hidden" value="" name="_settings_blocks" />`;
        }

        doAjax({
            'method': 'POST',
            'url': Route('forms.ajax'),
            'data': {
                'namespace' : 'App\\Adminify\\Forms\\SaveTemplate',
                'form-attributes' : {
                    'method' : 'POST',
                    'url' : Route('templates.store')
                }
            },
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }, function(err, datas) {
            if (err) {
                console.log('whooooops', err)
                return false;
            }

            let modalHtml = createModaleWithContent(datas.html)
            let fieldsHtml = getPrivateFields();

            editor.append(modalHtml);

            let form = $('#modaleRegisterTemplate form');

            $('#modaleRegisterTemplate').modal('show');

            form.append(fieldsHtml);


            $('#modaleRegisterTemplate').find('[name="content"]').val(content)

            form.find('[name="_css"]').val( JSON.stringify( getRuleSets(widgetId) ) );
            form.find('[name="_js"]').val( JSON.stringify([]) );
            form.find('[name="content"]').val( content );
            form.find('[name="_toolbars"]').val( JSON.stringify( findToolbars(visual) ) );
            form.find('[name="_settings_blocks"]').val( getSettingBlocksOf(visual) )
        })





        // doAjax({
        //     'method' : 'POST',
        //     'url' : Route('templates.store'),
        //     'headers': {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        // }, function(err, datas) {
        //     if (err) {
        //         console.log('whooooops', err)
        //     }
        // })
    })

})

$(document).on('editor:ready', function(e, details) {
    let editor = $(details.el);
    let MainForm = $(details.mainForm);
    let previousCssClass = '';
    let sortable_renderer_js = $(details.sortable_renderer);

    $(document).on('hidden.bs.modal', '#modaleRegisterTemplate', function() {
        $(this).remove()
    })

    $(document).on('submit', '#modaleRegisterTemplate form', function(e) {
        e.preventDefault();

        let form = $(this);
        let o = form.serializeFormJSON();

        doAjax({
            method : form.attr('method'),
            url : form.attr('action'),
            data : o,
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }, function(err, datas) {
            if (err) {
                console.log('whooooops', err)
                form.find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON);
                return false;
            }

            console.log(datas);

            $('#modaleRegisterTemplate').modal('hide');

            Swal.fire(datas.message, '', 'success')


        })
    })

    let checkAlreadyRenderedBlocks = sortable_renderer_js.find('.visual_element_block');

        if(checkAlreadyRenderedBlocks.length > 0) {
            $.each(checkAlreadyRenderedBlocks, function(i, checkAlreadyRenderedBlock) {
                $(editor).trigger('editor:create:sortable', {
                    element : $(checkAlreadyRenderedBlock)
                })
            })
        }

    let aReady = editor.find('#blocs-settings-tab').append(alreadyBlocks)


    let titleBlock = $(details.titleBlock);
    let titleForm = $(MainForm).find('[name="title"]');

    if(titleForm.hasClass('is-invalid')) {
        titleBlock.addClass('d-block').addClass('invalid-feedback').addClass('is-required');
        titleForm.next('.invalid-feedback').css({
            'display' : 'none'
        });

        editor.find('.js-sidebar[data-handle=".sidebar_controls"]').trigger('click');
    }

    editor.trigger('resize');

    editor.on('change', '[data-editor-track="tag"]', function(e) {
       let val = $(this).val();

       let wId = getTheWidgetId( $(this) );
       let element = getVisualElement( wId )

       let format = formatAttributes( element );
       let strAttribs = renderAttributes(format);

       let sInstance = Sortable.get( element.get(0) );

       // destroy the instance of the sortable
       if(sInstance != null) {
         sInstance.destroy()
       }

       element.replaceWith('<'+ val +' '+ strAttribs +'>'+ element.html() +'</'+ val +'>');

       // update element due to dom structure update..
       element = getVisualElement( wId )

       editor.trigger('editor:change:tag', {
           element : element
       });

    });


    editor.on('change', '[data-editor-track="textTransform"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'text-transform',
                value : val
            }
        });
     });

    //  editor.on('change', '[data-editor-track="imageSrc"]', function(e) {

    //     let val = $(this).parent().find('.img-fluid').attr('src') ?? '';
    //     let alt = $(this).parent().find('.img-fluid').attr('alt') ?? '';


    //     let visual = getVisualElement( $(this) );
    //     let img = visual.find('img');

    //     img.attr({
    //         'src' : val,
    //         'alt' : alt
    //     });

    //  })

     editor.on('input', '[data-editor-track="opacity"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'opacity',
                value : (parseInt(val) / 100)
            }
        });
     })

     editor.on('input', '[data-editor-track="radius"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'border-radius',
                value : val+'px'
            }
        });
    })


     editor.on('change', '[data-editor-track="bgImage"]', function(e) {
        let val = $(this).parent().find('.img-fluid').attr('src');

        let wType = getTheWidgetType( $(this) );
        let wId = getTheWidgetId( $(this) );

        if(val) {
            generateCss({
                uuid : wId,
                widgetType: wType,
                breakpoint : false, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'background-image',
                    value : 'url('+val+')'
                }
            });
        }
        else {
            removeStyledComponentStyles('.styled_components_block[data-rule="background-image"][data-breakpoint="false"][data-uuid="'+wId+'"][data-type="'+wType+'"]');
        }


     });

     editor.on('input', '[data-editor-track="column_width"]', function(e) {
        let val = $(this).val();

        let pattern = window.editorConfig.patterns.columns;
        let column_minimal =  window.editorConfig.patterns.column_minimal;
        let column_maximal =  window.editorConfig.patterns.column_maximal;
        let element = getVisualElement( $(this) )

        // on nettoie la classe courante globale

        for (let index = column_minimal; index <= column_maximal; index++) {

            let global_class_pattern = pattern.replace('-##BREAKPOINT##', '');
            global_class_pattern = global_class_pattern.replace('##WIDTH##', index);

            if(element.hasClass(global_class_pattern)) {
                element.removeClass(global_class_pattern);
            }
        }

        let new_class_pattern = pattern.replace('-##BREAKPOINT##', '');
        new_class_pattern = new_class_pattern.replace('##WIDTH##', val)

        element.addClass(new_class_pattern);

     });

     editor.on('input', '[data-editor-track="bgColor"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-color',
                value : val
            }
        });
     });

     editor.on('change', '[data-editor-track="bgPositionImage"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-position',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="contentPosition"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'justify-content',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="contentAlignPosition"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'align-items',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="bgSizeImage"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'background-size',
                value : val
            }
        });

     })

     editor.on('change', '[data-editor-track="bgType"]', function(e) {
        let val = $(this).val();
        let form = $(this).get(0).form;
        let selectors = [];
        let selectorsToHide = [];
        let rule_set = [];

        let wId = getTheWidgetId( $(this) );
        let wType = getTheWidgetType( $(this) );

        switch (val) {
            case 'no-bg':
                selectorsToHide = ['bgPositionImage', 'bgSizeImage', 'bgOtherSize', 'bgImage', 'bgColor'];
                rule_set = ['background-position', 'background-size', 'background-size', 'background-image', 'background-color'];
                break;
            case 'bg-color':
                selectors = ['bgColor'];
                selectorsToHide = ['bgPositionImage', 'bgSizeImage', 'bgOtherSize', 'bgImage'];
                rule_set = ['background-position', 'background-size', 'background-size', 'background-image'];
                break;
            case 'bg-image':
                selectors = ['bgPositionImage', 'bgSizeImage', 'bgImage'];
                selectorsToHide = ['bgColor'];
                rule_set = ['background-color'];
                break;
        }

        if(selectors.length > 0) {
            $.each(selectors, function(i, sel) {

                let _el = $(form).find('[data-editor-track="'+ sel +'"]');

                _el.parent().removeAttr('hidden');

                _el.trigger('input');
            })
        }

        if(selectorsToHide.length > 0) {
            $.each(selectorsToHide, function(i, sel) {
                let _el = $(form).find('[data-editor-track="'+ sel +'"]');

                _el.parent().attr('hidden', 'hidden');

                removeStyledComponentStyles('.styled_components_block[data-rule="'+ rule_set[i] +'"][data-breakpoint="false"][data-uuid="'+wId+'"][data-type="'+wType+'"]');
            })
        }
     });

     editor.on('change', '[data-editor-track="rowDirection"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'flex-direction',
                value : val
            }
        });
     });

     editor.on('change', '[data-editor-track="line_height_unit"]', function(e) {

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="line_height"]').first();

        element.trigger('change');
    });

     editor.on('change', '[data-editor-track="alignment"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'text-align',
                value : val
            }
        });
     });

    editor.on('keyup', '[data-editor-track="cssClasses"]', function(e) {
        let val = $(this).val();

        let element = getVisualElement( $(this) )

        element.removeClass(previousCssClass.trim());

        if(!element.hasClass(val.trim())) {
            element.addClass(val);
        }

        previousCssClass = val;
     });

     editor.on('input', '[data-editor-track="color"]', function(e) {
        let val = $(this).val();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed,
            rule : {
                property : 'color',
                value : val
            }
        });

        // $(document.head).append(styleBlock);


     });

     editor.on('change', '[data-editor-track="fontsize_unit"]', function(e) {

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="fontsize"]').first();

        element.trigger('change');
    });

    editor.on('change keyup', '[data-editor-track="fontsize"]', function(e) {
        let val = $(this).val();

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="fontsize_unit"]').first();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed
            rule : {
                property : 'font-size',
                value : val+element.val()
            }
        });

    });

    editor.on('change keyup', '[data-editor-track="line_height"]', function(e) {
        let val = $(this).val();

        let form = $(this).get(0).form;

        let element = $(form).find('[data-editor-track="line_height_unit"]').first();

        generateCss({
            uuid : getTheWidgetId( $(this) ),
            widgetType: getTheWidgetType( $(this) ),
            breakpoint : false, // set as false when no breakpoint css generation is needed
            rule : {
                property : 'line-height',
                value : val+element.val()
            }
        });
    });


    $(editor).on('click', '.js-btn-action', function(e) {
        e.preventDefault();

        let action = $(this).attr('data-action');
        let wId = $(this).attr('data-visual-element');
        $('.tooltip').remove();
        doAction(action, wId, $(this));


    });

     // breakpoints style based components

     let breakpointsKeys = Object.keys(window.editorConfig.breakpoints);

    $.each(breakpointsKeys, function(i, breakpoint) {

        editor.on('input', '[data-editor-track="column_width_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let pattern = window.editorConfig.patterns.columns;
            let column_minimal =  window.editorConfig.patterns.column_minimal;
            let column_maximal =  window.editorConfig.patterns.column_maximal;
            let element = getVisualElement( $(this) )

            // on nettoie la classe courante globale

            for (let index = column_minimal; index <= column_maximal; index++) {

                let global_class_pattern = pattern.replace('##BREAKPOINT##', breakpoint);
                global_class_pattern = global_class_pattern.replace('##WIDTH##', index);

                if(element.hasClass(global_class_pattern)) {
                    element.removeClass(global_class_pattern);
                }
            }

            let new_class_pattern = pattern.replace('##BREAKPOINT##', breakpoint);
            new_class_pattern = new_class_pattern.replace('##WIDTH##', val)

            element.addClass(new_class_pattern);

         });

        editor.on('change', '[data-editor-track="fontsize_unit_'+ breakpoint +'"]', function(e) {

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="fontsize_'+ breakpoint +'"]').first();

            element.trigger('change');
        });

        editor.on('input', '[data-editor-track="opacity_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'opacity',
                    value : (parseInt(val) / 100)
                }
            });
         })

         editor.on('input', '[data-editor-track="radius_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'border-radius',
                    value : val+'px'
                }
            });
        })

        editor.on('change', '[data-editor-track="rowDirection_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'flex-direction',
                    value : val
                }
            });
         });

         editor.on('change', '[data-editor-track="contentPosition_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'justify-content',
                    value : val
                }
            });
         });

         editor.on('change', '[data-editor-track="contentAlignPosition_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'align-items',
                    value : val
                }
            });
         });

        editor.on('change', '[data-editor-track="alignment_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed,
                rule : {
                    property : 'text-align',
                    value : val
                }
            });


         });

         editor.on('change', '[data-editor-track="line_height_unit_'+ breakpoint +'"]', function(e) {

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="line_height_'+ breakpoint +'"]').first();

            element.trigger('change');
        });

         editor.on('change keyup', '[data-editor-track="line_height_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="line_height_unit_'+ breakpoint +'"]').first();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed
                rule : {
                    property : 'line-height',
                    value : val+element.val()
                }
            });


        });

        editor.on('change keyup', '[data-editor-track="fontsize_'+ breakpoint +'"]', function(e) {
            let val = $(this).val();

            let form = $(this).get(0).form;

            let element = $(form).find('[data-editor-track="fontsize_unit_'+ breakpoint +'"]').first();

            generateCss({
                uuid : getTheWidgetId( $(this) ),
                widgetType: getTheWidgetType( $(this) ),
                breakpoint : breakpoint, // set as false when no breakpoint css generation is needed
                rule : {
                    property : 'font-size',
                    value : val+element.val()
                }
            });



        });

    });

});
