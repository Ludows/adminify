import React, { useEffect, useMemo, forwardRef, createRef } from 'react';
import MenuSwitcher from './MenuBuilder/MenuSwitcher';
import MenuSidebar from './MenuBuilder/MenuSidebar';
import MenuThree from './MenuBuilder/MenuThree';
import MenuCard from './MenuBuilder/MenuCard';
import usePageProps from '../hooks/usePageProps';

const MenuBuilder = forwardRef((props, ref) => {

    if(!ref) {
        ref = createRef({});
    }

    const { get } = usePageProps();
    let datas = useMemo(() => { return get() }, [props])
    useEffect(() => {
        console.log('from menu builder', datas)
    }, [])

    return <div ref={ref} className="container-fluid" id="menuBuilder">
            { datas.isEdit &&
                <div className='row'>
                    <div className='col-12'>
                        <MenuSwitcher form={datas.menubuilder.forms.switcher}/>
                    </div>
                </div>   
            }
            <div className="row">
                { datas.isEdit &&
                    <div className='col-lg-4 col-12'>
                        <MenuSidebar deleteForm={datas.menubuilder.forms.delete_crud} flush defaultActiveKey="0" forms={datas.menubuilder.sidebar_forms}/>
                    </div> 
                }
                <div className={`${datas.isEdit ? 'col-lg-8': 'col-lg-12'} col-12`}>
                    {datas.isEdit ? <MenuThree forms={datas.menubuilder.forms} /> : <MenuCard form={datas.menubuilder.forms.create_menu}/>} 
                    {/* @include('adminify::layouts.admin.menubuilder.menu-three', ['mediaMode' => $canAttachMedia]) */}
                </div>
            </div>
        </div>
});

export default MenuBuilder;