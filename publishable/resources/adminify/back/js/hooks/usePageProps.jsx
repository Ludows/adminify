import React, { useRef, useCallback, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
export default function usePageProps() {
    const { page } = usePage();

    let getter = useCallback((propName) => {
        return page[propName] ? page[propName] : null;
    })
    return [getter];
}