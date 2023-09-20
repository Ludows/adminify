import React, { useEffect, useMemo, useRef, createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';

const Menu = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }
    const { navigate, createCustomRenderer } = useHelpers();
    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    let menu = useMemo(() => props.menu, [props]);
    let menuKeys = useMemo(() => Object.keys(menu), [menu]);


    useEffect(() => {
        console.log('Menu.jsx onMounted', menuKeys);
    }, [])

    
    const manageActive = (target) => {
        let links = [...ref.current.querySelectorAll('.menu-item')];
        links.forEach((link) => {
            link.classList.remove('active');
            link.removeAttribute('disabled');
        })

        target.classList.add('active');
        target.setAttribute('disabled', 'disabled');
    }

    const handleVisit = (e, menuItem) => {
        let target = e.target;
        manageActive(target);
        navigate(menuItem)
    }

    const renderIcon = (MenuItem) => {
        let iconClasses = [];

        if(MenuItem.baseIconClass) {
            iconClasses.push(MenuItem.baseIconClass);
        }

        if(MenuItem.iconPrefix && MenuItem.icon) {
            iconClasses.push(MenuItem.iconPrefix+'-'+MenuItem.icon);
        }

        return <i className={`${iconClasses.join(' ')}`}></i>
    }
    
    return <>
        <ul ref={ref} className="nav flex-column">
            {menuKeys.map((menuKey, index) => {
                return <li key={index} className="nav-item">
                    {/* <Link replace href={menu[menuKey].url} className='nav-link'>{ menu[menuKey].label }</Link>  */}
                    <button onClick={(e) => { handleVisit(e, menu[menuKey]) }} data-index={index} className='nav-link bg-transparent border-0 menu-item'>
                        {renderIcon(menu[menuKey])}
                        { menu[menuKey].label }</button> 
                </li>
            })}
        </ul>
    </>
})  
export default Menu;