import React, { useEffect, useMemo, createRef, forwardRef, useState } from 'react';
import useHelpers from '../hooks/useHelpers';
import useRouterEvents from '../hooks/useRouterEvents';
import { Button } from 'react-bootstrap';
import { useWindowSize } from 'usehooks-ts';

const Menu = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }
    const { navigate, createCustomRenderer, fire } = useHelpers();
    const [activeRoute, setActiveRoute] = useState(window.location.pathname);
    const { onNavigate } = useRouterEvents();
    const wSize = useWindowSize();
    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    let menu = useMemo(() => props.menu, [props]);
    let menuKeys = useMemo(() => Object.keys(menu), [menu]);


    useEffect(() => {
        console.log('Menu.jsx onMounted', menuKeys);
    }, [])

    onNavigate((e) => {
        setActiveRoute(window.location.pathname);
    }, []);

    
    // const manageActive = (target) => {
    //     let links = [...ref.current.querySelectorAll('.menu-item')];
    //     links.forEach((link) => {
    //         link.classList.remove('active');
    //         link.removeAttribute('disabled');
    //     })

    //     target.classList.add('active');
    //     target.setAttribute('disabled', 'disabled');
    // }

    const handleVisit = (e, menuItem) => {
        let target = e.target;
        console.log(menuItem)
        // manageActive(target);
        if(activeRoute != menuItem.url) {
            navigate(menuItem)
            if(wSize.width < 993) {
                fire('adminify:sidebar', {
                    isToggled : false,
                    isExpanded: false,
                    needClose : true,
                })
            }
        }
    }

    const renderIcon = (MenuItem) => {
        let iconClasses = [''];

        if(MenuItem.baseIconClass) {
            iconClasses.push(MenuItem.baseIconClass);
        }

        if(MenuItem.iconPrefix && MenuItem.icon) {
            iconClasses.push(MenuItem.iconPrefix+'-'+MenuItem.icon);
        }

        return <i className={`${iconClasses.join(' ')}`}></i>
    }
    
    return <>
        <ul ref={ref} className="nav flex-column menu">
            {menuKeys.map((menuKey, index) => {
                return <li key={index} className="nav-item mb-2">
                    {/* <Link replace href={menu[menuKey].url} className='nav-link'>{ menu[menuKey].label }</Link>  */}
                    <Button variant={null} className='w-100 menu-item p-3 btn-admin-menu' onClick={(e) => { handleVisit(e, menu[menuKey]) }} active={activeRoute === menu[menuKey].url }>
                        {renderIcon(menu[menuKey])}
                        <span className='menu-item-text'>{ menu[menuKey].label }</span>
                    </Button>
                </li>
            })}
        </ul>
    </>
})  
export default Menu;