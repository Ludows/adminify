import React, { useRef, useCallback, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
export default function usePageProps() {
    const globalProps = usePage();

    let getter = useCallback((propName) => {
        return globalProps.props.hasOwnProperty(propName) ? globalProps.props[propName] : globalProps.props;
    })

    let hasCb = useCallback((propName) => {
        return globalProps.props.hasOwnProperty(propName);
    })

    let methods = {
        get : getter,
        has : hasCb
    }

    return methods;
}