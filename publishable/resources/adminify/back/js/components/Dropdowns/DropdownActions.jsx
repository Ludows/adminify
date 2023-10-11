import React, { forwardRef, createRef, useEffect, useMemo } from 'react';
import Dropdown from 'react-bootstrap/Dropdown';
import ActionItem from '../ActionItem';
import useHelpers from '../../hooks/useHelpers';
const DropdownActions = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

   const actions = useMemo(() => { return props.actions ? props.actions : {} }, [props]);
   const { createCustomRenderer } = useHelpers();

   let customRender = createCustomRenderer(null, props, ref);

   if(!actions) {
        return null;
   }

    useEffect(() => {
    //   console.log('DropdownActions.jsx', props, ref);
    }, []);

    if(customRender) {
        return customRender;
    }

  return <Dropdown ref={ref}>
            <Dropdown.Toggle variant="outline-primary" id="dropdown-basic">
                <i class="bi bi-stack"></i>
            </Dropdown.Toggle>
    
            <Dropdown.Menu>
                {actions.map(({Component, Vars}, index, array) => {
                    return <ActionItem key={index} componentName={Component} label={`admin.${Vars.name}`} vars={Vars} />
                })}
            </Dropdown.Menu>
        </Dropdown>
})

export default DropdownActions;