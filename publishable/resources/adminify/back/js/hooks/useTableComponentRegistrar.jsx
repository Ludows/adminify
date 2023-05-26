
import React, {useEffect, useMemo, useCallback} from 'react';
import TableSearch from '@/back/js/components/Table/TableSearch';
import TableTitle from '@/back/js/components/Table/TableTitle';
import TableStatuses from '@/back/js/components/Table/TableStatuses';

import Media from '@/back/js/components/Table/Cell/Media';
import Content from '@/back/js/components/Table/Cell/Content';
import User from '@/back/js/components/Table/Cell/User';
import Status from '@/back/js/components/Table/Cell/Status';
import Tags from '@/back/js/components/Table/Cell/Tags';
import Categories from '@/back/js/components/Table/Cell/Categories';
import Actions from '@/back/js/components/Table/Cell/Actions';

export default function useTableComponentRegistrar(props = {}, registerCb = null) {

    let areas = useMemo(() => props.areas, [props]);

    let internals = useMemo(() => {
        let Components = {
            'listing' : {},
            'areas' : {},
            'actions' : {}
        }
        let registered_components = {};
        let listed_components = {};

        let coreAreasComponents = {
            'search' : TableSearch,
            'title' : TableTitle,
            'statuses' : TableStatuses
        }

        let coreTableComponents = {
            'media-id' : Media,
            'content' : Content,
            'user-id' : User,
            'status-id' : Status,
            'has-tags' : Tags,
            'categories-id' : Categories,
            'actions' : Actions
        }

        let coreTableActions = {
            
        }

        

        if(registerCb && typeof registerCb === "function") {
            let results_register_components = registerCb(props);
            if(results_register_components && typeof results_register_components === "object") {
                registered_components = results_register_components;
            }
        }

        listed_components = Object.assign({}, {
            'listing' : coreTableComponents,
            'areas' : coreAreasComponents,
            'actions' : coreTableActions
        }, registered_components);

        

        let areaKeys = Object.keys(areas);
        areaKeys.forEach(areaKey => {
            Components['areas'][areaKey] = [];

            let componentsKeyByArea = Object.keys(areas[areaKey]);

            componentsKeyByArea.forEach(componentKey => {
                if(!listed_components['areas'][componentKey]) {
                    console.warn('Whoops Component '+ componentKey + 'was registered ?');
                }
                else {
                    Components['areas'][areaKey].push({
                        Vars : areas[areaKey][componentKey],
                        Component: listed_components['areas'][componentKey],
                        Global : props
                    })
                }
            })
        })

        Components['listing'] = {...Components['listing'], ...listed_components.listing};
        Components['actions'] = {...Components['actions'], ...listed_components.actions};
        
        return Components;
    }, [areas])

    let getInternalsCallback = useCallback(() => {
        return internals;
    }, [])

    useEffect(() => {
        // console.log('useComponentRegistrar.jsx onMounted', internals);
    }, [])
    
    return [internals, getInternalsCallback];
}
