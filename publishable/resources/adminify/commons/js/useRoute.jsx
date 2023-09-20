import React, { useState, useEffect } from 'react';
import Route from './Route';
export default function useRoute(name, parameters = {}) {
    let [route, setRoute] = useState({});

    useEffect(() => {
        let matchedRoute = Route(name, parameters);
        setRoute(matchedRoute);
    }, [])
    
    return [route];
}