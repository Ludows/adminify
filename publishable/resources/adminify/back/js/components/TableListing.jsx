import React, {useMemo, useEffect} from 'react';

import TableBase from '@/back/js/components/TableBase';
import TableSearch from '@/back/js/components/TableSearch';
import TableTitle from '@/back/js/components/TableTitle';
import TableStatuses from '@/back/js/components/TableStatuses';

export default function TableListing(props) {

    let areas = useMemo(() => props.datas.areas, [props]);
    let components = useMemo(() => {
        let o = {};
        let registered_components = {};
        let listed_components = {};

        let coreTableFeatures = {
            'search' : TableSearch,
            'title' : TableTitle,
            'statuses' : TableStatuses
        }

        if(props.datas.registerComponents && typeof props.datas.registerComponents === "function") {
            let results_register_components = props.datas.registerComponents(props.datas);
            if(results_register_components && typeof results_register_components === "object") {
                registered_components = results_register_components;
            }
        }

        listed_components = Object.assign({}, coreTableFeatures, registered_components);

        console.log('Avalaibles components', listed_components);


        let areaKeys = Object.keys(areas);
        areaKeys.forEach(areaKey => {
            o[areaKey] = [];

            let componentsKeyByArea = Object.keys(areas[areaKey]);

            componentsKeyByArea.forEach(componentKey => {
                if(!listed_components[componentKey]) {
                    console.warn('Whoops Component '+ componentKey + 'was registered ?');
                }
                else {
                    o[areaKey].push({
                        Vars : areas[areaKey][componentKey],
                        Component: listed_components[componentKey],
                        Global : props.datas
                    })
                }
            })
        })
        
        return o;
    }, [areas])
    // let components

    useEffect(() => {
        console.log('TableListing.jsx onMounted', areas, components);
    }, [])

    return <>
        <div className='card'>
            <div className='card-header'>
                <div className='row'>
                    {components['top-left'].length > 0 && 
                        <div className='col'>
                            {components['top-left'].map(({Component, Vars, Global}) => (
                                <Component global={Global} datas={Vars} />
                            ))}
                        </div>
                    }
                    {components['top-right'].length > 0 && 
                        <div className='col'>
                            {components['top-right'].map(({Component, Vars, Global}) => (
                                <Component global={Global} datas={Vars} />
                            ))}
                        </div>
                    }
                </div>
            </div>
            <div className='card-body'>
                <TableBase hover striped bordered datas={props.datas} />
            </div>
            {components['bottom-left'].length > 0 || components['bottom-right'].length > 0 &&
                <div className='card-footer'>
                    <div className='row'>
                        {components['bottom-left'].length > 0 && 
                            <div className='col'>
                                {components['bottom-left'].map(({Component, Vars, Global}) => (
                                    <Component global={Global} datas={Vars} />
                                ))}
                            </div>
                        }
                        {components['bottom-right'].length > 0 && 
                            <div className='col'>
                                {components['bottom-right'].map(({Component, Vars, Global}) => (
                                    <Component global={Global} datas={Vars} />
                                ))}
                            </div>
                        }
                    </div>
                </div>
            }
        </div>
    </>
}