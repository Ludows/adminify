import React, { useEffect, useRef, useMemo } from 'react';
import Dropdown from 'react-bootstrap/Dropdown';
import Route from '@/back/js/libs/Route';
import useHelpers from '../../hooks/useHelpers';
import usePageProps from '../../hooks/usePageProps';
import useTranslations from '../../hooks/useTranslations';

export default function DropdownUser(props) {

    const { get } = usePageProps();
    const { get: getTranslation } = useTranslations();
    const user = useMemo(() => {
        return get('user');
    }, [props])
    const { navigate } = useHelpers();
    
    const mainLinks = useMemo(() => {
        return {
            'edit' : {
                route : 'admin.users.edit',
                label : 'admin.profile',
                data : {
                    user : user.id
                }
            },
            'profile_edit' : {
                route : 'admin.users.profile.edit',
                label : 'admin.update_profile',
                data : {
                    user : user.id
                }
            },
            'settings' : {
                route : 'admin.settings.index',
                label : 'admin.menuback.settings',
                data : {}
            },
            'logout' : {
                route : 'admin.auth.logout',
                label : 'admin.logout',
                data : {}
            }
        }
    }, [props])

    const changeUrl = (routeKey, objectRoute) => {
        console.log('DropdownUser.jsx changeUrl()', objectRoute);
        let routePath = Route(objectRoute.route, objectRoute.data);
        if(routePath) {
            navigate({
                method : routeKey == 'logout' ? 'post' : 'get',
                url : routePath
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
                    { user.avatar && 
                        <span className="avatar avatar-sm rounded-circle">
                            <img alt={user.name} src={user.path} />
                        </span>
                    }
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