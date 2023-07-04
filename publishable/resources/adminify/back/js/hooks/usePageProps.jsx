import React, { useRef, useCallback, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
export default function usePageProps() {
    const globalProps = usePage();

    let getter = useCallback((propName) => {
        return globalProps.props[propName] ? globalProps.props[propName] : globalProps.props;
    })

    let methods = {
        get : getter
    }

    return methods;
}