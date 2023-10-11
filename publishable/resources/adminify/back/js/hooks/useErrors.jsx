import React, { useRef, useState, useEffect, useContext } from 'react';
import { AdminifyContext } from '../contexts/AdminifyContext';
export default function useErrors(fieldName) {

    const [error, setError] = useState(null);
    const [stateField, setStateField] = useState(false);
    const Name = useRef(fieldName ?? '');
    const {on, off, emit} = useContext(AdminifyContext);

    useEffect(() => {
        let listener = (data) => {
          if(data[Name.current]) {
            setError(data[Name.current]);
          }
            setStateField(data[Name.current]);
          
        }
        on('adminify:datas:errors', listener);
        return () => {
          off("adminify:datas:errors", listener);
        }
        // if (on) {}
      }, [])
    
    return [stateField, error];
}