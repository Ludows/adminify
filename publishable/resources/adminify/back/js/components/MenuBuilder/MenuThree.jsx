import React, { forwardRef, createRef } from "react";
import BaseForm from "../BaseForm";
import MenuItemsRenderer from './MenuItemsRenderer';
 const MenuThree = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    return <div className="card">
                <BaseForm render={MenuItemsRenderer} form={props.forms.update_menu} />
           </div>
 })

 export default MenuThree;