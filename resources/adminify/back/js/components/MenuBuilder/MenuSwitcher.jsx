import React, { useState, useRef, forwardRef, createRef } from "react";
import BaseForm from './../BaseForm';

const MenuSwitcher = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }

    if(props.form && props.form.fields.menus.choices.length == 0) {
        return <></>;
    }
    
    return <div ref={ref} className='card'>
                <div className='card-body'>
                    <BaseForm {...props}/>
                </div>
            </div>
 })

 export default MenuSwitcher;