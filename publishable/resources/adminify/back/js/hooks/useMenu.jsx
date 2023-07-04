
import React, { useCallback, useEffect, useRef, useContext } from 'react';
import { EmitterContext } from '../contexts/EmitterContext';

export default function useMenu(configObject = {}) {
    
    const [on, off, emit] = useContext(EmitterContext);
    
    const config = useRef({
        renderField : null,
        prototype : {},
        prototype_name : '',
        ...configObject
    })

    const onItemsCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:menu:items', fn);
            return () => {
                off('adminify:menu:items', fn);
            }
        }, useEffectDeps)
    }, [])

    const getMappedField = useCallback((field = {}, proto_name = '', wantedKey = '') => {
        let new_field = {...field};
        if(field.attr && field.attr.hasOwnProperty('id') && field.attr.id.indexOf(proto_name) > -1) {
            new_field.attr.id = new_field.attr.id.replace(proto_name, wantedKey)
        }
        if(field.name.indexOf(proto_name) > -1) {
            new_field.name = new_field.name.replace(proto_name, wantedKey)
        }
        return new_field;
    });

    const prototypeCb = useCallback((item, idx) => {
        let proto = config.current.prototype;
        let proto_name = config.current.prototype_name;
        
        let sanitized_fields = [];
        let fields = {...proto.fields};
        Object.keys(fields).forEach((key, localIndex) => {
            let f = getMappedField(fields[key], proto_name, idx);
            sanitized_fields.push( config.current.renderField(localIndex, f) )
        })

        return sanitized_fields;
    }, [])

    const itemCb = useCallback((obj = {}) => {
        let defaults = {
            items: {},
            type : ''
        }
        emit('adminify:menu:items', {...defaults, ...obj});
    }, [])

    // useEffect(() => {
    //     console.log('useMenu.jsx mounted', config.current);
    // }, [])

    let methods = {
        onItems: onItemsCb,
        items : itemCb,
        getMappedField,
        prototype: prototypeCb,
    }

    return methods;
}
