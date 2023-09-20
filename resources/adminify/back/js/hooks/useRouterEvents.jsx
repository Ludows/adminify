import React, { useRef, useCallback, useEffect } from 'react';
export default function useRouterEvents() {
    // const { page } = usePage();

    // let getter = useCallback((propName) => {
    //     return page[propName] ? page[propName] : null;
    // })

    const onBefore = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:before", cb);
            return () => {
                document.removeEventListener("inertia:before", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onSuccess = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:success", cb);
            return () => {
                document.removeEventListener("inertia:success", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onStart = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:start", cb);
            return () => {
                document.removeEventListener("inertia:start", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onProgress = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:progress", cb);
            return () => {
                document.removeEventListener("inertia:progress", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onError = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:error", cb);
            return () => {
                document.removeEventListener("inertia:error", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onException = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:exception", cb);
            return () => {
                document.removeEventListener("inertia:exception", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onInvalid = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:invalid", cb);
            return () => {
                document.removeEventListener("inertia:invalid", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onFinish = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:finish", cb);
            return () => {
                document.removeEventListener("inertia:finish", cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onNavigate = useCallback((cb = (e) => {},  useEffectDeps = []) => {

        useEffect(() => {
            document.addEventListener("inertia:navigate", cb);
            return () => {
                document.removeEventListener("inertia:navigate", cb);
            }
        }, useEffectDeps)
        
    }, []);

    let methods = {
        onBefore,
        onSuccess,
        onStart,
        onProgress,
        onError,
        onException,
        onInvalid,
        onFinish,
        onNavigate
    };

    return methods;
}