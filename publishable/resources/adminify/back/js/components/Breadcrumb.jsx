import React, { forwardRef, createRef, useMemo } from 'react';
import Breadcrumb from 'react-bootstrap/Breadcrumb';
import useTranslations from '../hooks/useTranslations';
import Route from '../libs/Route';
import useHelpers from '../hooks/useHelpers';
const BreadcrumbComponent = forwardRef((props, ref) => {

    const { items, currentRoute, model, singleParam } = props;
    const { get } = useTranslations();
    const { navigate, createCustomRenderer } = useHelpers();

   if(!ref) {
      ref = createRef({});
   }

   let customRender = createCustomRenderer(null, props, ref);

   const prepareItems = (items) => {
    let created_items = [];
    items.forEach((item, i) => {
        // Route(item);
        let o = {};
        if(item.endsWith('.create') || item.endsWith('.edit')) {
            o[singleParam] = model.id;
        }
        created_items.push(
            Route(item, o)
        )
        
    })
    return created_items;
   }

   const Items = prepareItems(items);

   const handleGo = (url, isActive) => {
        if(isActive) {
            return false;
        }

        navigate({
            url,
        })
   }

   let listPropsObject = {
        className: 'mb-0',
   }

   
   if(customRender) {
        return customRender;
   }


   return <Breadcrumb ref={ref} listProps={listPropsObject}>
        {Items.map((url, index, array) => {
            let label = get(items[index]);
            let isActive = (Items.length - 1) == index;
            return <Breadcrumb.Item key={index} active={isActive} onClick={() => handleGo(url, isActive)} as="li">{label}</Breadcrumb.Item>
        })} 
    </Breadcrumb>;
})

export default BreadcrumbComponent;