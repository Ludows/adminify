import React, { useEffect, useRef, useMemo } from 'react';
import useGlobalStore from '../store/global';
import Dropdown from 'react-bootstrap/Dropdown';
import { router } from '@inertiajs/react'
import Route from '@/commons/js/Route';

export default function DropdownUser(props) {

    const appData = useGlobalStore(state => state.getAppData);
    const getTranslation = useGlobalStore(state => state.getTranslation);
    const user = useMemo(() => {
        return appData('user');
    })
    const mainLinks = useMemo(() => {
        return {
            'edit' : {
                route : 'users.edit',
                label : 'admin.profile',
                data : {
                    user : user.id
                }
            },
            'profile_edit' : {
                route : 'users.profile.edit',
                label : 'admin.update_profile',
                data : {
                    user : user.id
                }
            },
            'settings' : {
                route : 'settings.index',
                label : 'admin.menuback.settings',
                data : {}
            },
            'logout' : {
                route : 'auth.logout',
                label : 'admin.logout',
                data : {}
            }
        }
    })

    const changeUrl = (routeKey, objectRoute) => {
        console.log('DropdownUser.jsx changeUrl()', objectRoute);
        let routePath = Route(objectRoute.route, objectRoute.data);
        if(routePath) {
            router.visit(routePath, {
                method : routeKey == 'logout' ? 'post' : 'get',
                data: {}
            })
        }
        
    } 

    const mainLinksKeys = useMemo(() => Object.keys(mainLinks));

    useEffect(() => {
        console.log('DropdownUser.jsx onMounted', user);
    }, [])

    return <>
        <Dropdown className='nav-item'>
            <Dropdown.Toggle className='nav-link pr-0 text-white' id="dropdown-basic">
                <div className="media align-items-center">
                    <span className="avatar avatar-sm rounded-circle">
                        <img alt={user.name} src={user.path} />
                    </span>
                    <div className="media-body ml-2 d-none d-lg-block">
                        <span className="mb-0 text-sm  font-weight-bold">{user.name}</span>
                    </div>
                </div>
            </Dropdown.Toggle>

            <Dropdown.Menu>
                {/* <Dropdown.ItemText>{{ __('admin.welcome') }}</Dropdown.ItemText> */}
                {mainLinksKeys.map((mainLinksKey, index) => {
                    return <Dropdown.Item key={index} as="li" onClick={() => {changeUrl(mainLinksKey, mainLinks[mainLinksKey])}}>{ getTranslation(mainLinks[mainLinksKey].label) }</Dropdown.Item>
                })}
                
            </Dropdown.Menu>
        </Dropdown>
    </>
}