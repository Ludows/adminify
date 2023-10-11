
import React, {useCallback, useRef} from 'react';
// import gsap from 'gsap';
import FadeIn from '../animations/FadeIn';
import FadeOut from '../animations/FadeOut';
import Sidebar from '../animations/Sidebar';

export default function useAnimations() {

    let registrarAnimations = useRef({
        'fadein' : FadeIn.fire,
        'fadeout' : FadeOut.fire,
        'sidebar' : Sidebar.fire,
    });
    let registrarConfigAnimations = useRef({
        'fadein' : FadeIn.config,
        'fadeout' : FadeOut.config,
        'sidebar' : Sidebar.config,
    });

    let registerCb = useCallback((name = '', fn = (toElement, config = {}, extraDatas = {}) => {}, config = {}) => {
        if(!registrarAnimations.current[name] && fn instanceof Function) {
            registrarAnimations.current[name] = fn;
            registrarConfigAnimations.current[name] = config;
        }
    }, []);

    let doCb = useCallback((name = '', mixed , overrideGsapConfig = {}, extraDatas = {}) => {
        if(!registrarAnimations.current[name]) {
            console.warn(`Animation name with ${name} not defined. Skipped.`);
            return false;
        }

        let config = {};

        if(registrarConfigAnimations.current[name]) {
            config = registrarConfigAnimations.current[name];
        }

        config = {...config, ...overrideGsapConfig};

        if(mixed) {
            registrarAnimations.current[name](mixed, config, extraDatas);
        }
    }, [])

    let methods = {
        register : registerCb,
        animate : doCb
    }

    return methods;
}
