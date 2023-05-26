import React, { forwardRef, useEffect, createRef, useMemo } from "react";
import Dropdown from 'react-bootstrap/Dropdown';
import BaseForm from '@/back/js/components/BaseForm';
import useHelpers from '@/back/js/hooks/useHelpers';
import useTranslations from '@/back/js/hooks/useTranslations';

const Actions = forwardRef((props, ref) => {

    const actions = useMemo(() => props.actions, [props]);
    const { navigate } = useHelpers();
    const { get } = useTranslations();

    // if(!props.renderAs) {
    //     props.renderAs = 'dropdown';
    // }

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    const doNavigate = (vars) => {
        // console.log(vars)
        navigate(vars);
    }

    const renderContent = (array) => {
        // let tags = array.map((tag, index, array) => { return tag.title });

        // if(tags.length == 0) {
        //     tags = get('admin.table.modules.listings.no_entity');
        // }

        // return typeof tags == 'string' ? tags : tags.join(',');

        return <Dropdown>
        <Dropdown.Toggle variant="success" id="dropdown-basic">
            <i class="bi bi-stack"></i>
        </Dropdown.Toggle>
  
        <Dropdown.Menu>
            {array.map(({Component, Vars}, index, array) => {
                if(Vars.form) {
                    return <Dropdown.Item>
                        <BaseForm form={Vars.form} />
                    </Dropdown.Item>
                }

                return <Dropdown.Item onClick={(e) => { doNavigate(Vars) }}>{get(`admin.${Vars.name}`)}</Dropdown.Item>
            })}
        </Dropdown.Menu>
      </Dropdown>
    }

    return <>
        <td ref={ref}>
            {renderContent(props.data.dropdown)} 
        </td>
    </>


});

export default Actions;