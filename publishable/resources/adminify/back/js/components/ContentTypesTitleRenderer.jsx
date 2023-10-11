import React, { forwardRef, createRef } from 'react';
import InputGroup from 'react-bootstrap/InputGroup';
import Button from 'react-bootstrap/Button';

const ContentTypesTitleRenderer = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

   const { isEdit, field, model, renderField } = props;

   const handleClick = () => {
        window.open(model.front_url, '_blank');
   }


  return isEdit ? <InputGroup className="">
    {renderField(0, field)}
    {model.front_url && 
        <Button variant="outline-secondary" onClick={handleClick} id="button-addon2">
            <i class="bi bi-box-arrow-up"></i>
        </Button>
    }
    
    </InputGroup> : renderField(0, field);
})

export default ContentTypesTitleRenderer;