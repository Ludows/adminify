import React, { useState, useRef, forwardRef, createRef } from "react";
import BaseForm from './../BaseForm';

 const MenuCard = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }

    return <div ref={ref} className='card'>
                <div className='card-body'>
                    <BaseForm {...props}/>
                </div>
            </div>
    
 })

 export default MenuCard;