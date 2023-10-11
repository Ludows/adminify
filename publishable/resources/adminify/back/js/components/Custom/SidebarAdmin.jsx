import React, { forwardRef, createRef, useRef } from 'react';
import usePageProps from '../../hooks/usePageProps';
import useHelpers from '../../hooks/useHelpers';
import useNativeEvent from '../../hooks/useNativeEvent';
// import useRoutes
const SidebarAdmin = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

   const { get } = usePageProps();
   const { event } = useHelpers();
   const sidebarRef = useRef({});
   const { listen } = useNativeEvent(sidebarRef);

   const basicClasses =  ['sidebar'];

   if(props.className) {
     basicClasses.push(props.className);
   }

   const handleMouse = (e) => {
        console.log("", e.type);
        let {current:sidebar} = sidebarRef;
        if(!sidebar.classList.contains('is-expanded')) {
            e.type == 'mouseenter' ? sidebar.classList.add('is-hovered') : sidebar.classList.remove('is-hovered');
        }
   }

   listen('transitionstart', (e) => {
      let {current:sidebar} = sidebarRef;
      sidebar.classList.add('is-running');
   }, false);

   listen('transitionend', (e) => {
      let {current:sidebar} = sidebarRef;
      sidebar.classList.remove('is-running');
   }, false);

   event('adminify:sidebar', (datas) => {
        console.log("", datas);

        let {current:sidebar} = sidebarRef;
        datas.isExpanded ? sidebar.classList.add('is-expanded') : sidebar.classList.remove('is-expanded');
        datas.isToggled ? sidebar.classList.add('is-toggled') : sidebar.classList.remove('is-toggled');
        
   }, [])
   

  return <div onMouseEnter={handleMouse} onMouseLeave={handleMouse} ref={sidebarRef} className={basicClasses.join(' ')}>
    <div className='logo fw-light px-4 py-4 mt-2 text-primary border-bottom border-light border-1 h5'>
        Adminify
    </div>
    <div className='m-3'>
        {props.children}
    </div>
  </div>
})

export default SidebarAdmin;