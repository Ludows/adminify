import React, { forwardRef, useEffect, createRef } from "react";
import useTranslations from "../../../hooks/useTranslations";

const Categories = forwardRef((props, ref) => {

    const { get } = useTranslations();

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    const renderContent = (array) => {
        let categories = array.map((category, index, array) => { return category.title });

        if(categories.length == 0) {
            categories = get('admin.table.modules.listings.no_entity');
        }

        return typeof categories == 'string' ? categories : categories.join(',');
    }

    return <>
        <td ref={ref}>
            {renderContent(props.model['categories'])} 
        </td>
    </>


});

export default Categories;