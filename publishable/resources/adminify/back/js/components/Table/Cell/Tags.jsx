import React, { forwardRef, useEffect, createRef } from "react";
import useTranslations from "../../../hooks/useTranslations";

const Tags = forwardRef((props, ref) => {

    const { get } = useTranslations();

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    const renderContent = (array) => {
        let tags = array.map((tag, index, array) => { return tag.title });

        if(tags.length == 0) {
            tags = get('admin.table.modules.listings.no_entity');
        }

        return typeof tags == 'string' ? tags : tags.join(',');
    }

    return <>
        <td ref={ref}>
            {renderContent(props.data.model['tags'])} 
        </td>
    </>


});

export default Tags;