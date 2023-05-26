import React, { useRef, createRef, forwardRef, useState } from 'react';
import Button from 'react-bootstrap/Button';
import useMediaPicker from '@/back/js/hooks/useMediaPicker';

const BtnSaveSelection = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef();
    }
    const { onSelectionUpdated, save, hide, onConfig } = useMediaPicker();
    let [isDisabled, setIsDisabled] = useState(true);
    const selection = useRef([]);
    const config = useRef({});

    const handleSaveSelection = (e) => {
          e.preventDefault();
          save({
            selection : selection.current,
            config: config.current
          });
          hide();
      }

      const onSelection = (datas) => {
        selection.current = datas;
        setIsDisabled(datas.length == 0);
      }

      const onConfigResolver = (datas) => {
        // console.log('onConfigResolver', datas);
        config.current = datas;
      }

      onConfig(onConfigResolver);
  
      onSelectionUpdated(onSelection);

      return <>
        <Button ref={ref} variant="primary" disabled={isDisabled} onClick={handleSaveSelection}>
            Save Changes
        </Button>
    </>

});
export default BtnSaveSelection;