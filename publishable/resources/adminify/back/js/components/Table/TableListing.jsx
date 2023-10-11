import React, {useMemo, useEffect, useRef, forwardRef, createRef, useContext} from 'react';

import TableBase from '../Table/TableBase';
import useTableComponentRegistrar from '../../hooks/useTableComponentRegistrar';
import useTableSearch from '../../hooks/useTableSearch';

const TableListing = forwardRef((props, ref) => {
    let areas = useMemo(() => props.datas.areas, [props]);
    let [components] = useTableComponentRegistrar(props.datas, props.registerComponents);
    let TableSearch = useTableSearch(props);

    if(!ref) {
        ref = createRef({});
    }

    useEffect(() => {
        console.log('TableListing.jsx onMounted', areas, components);
    }, [])

    return <>
        <div ref={ref} className='card'>
            <div className='card-header'>
                <div className='row align-items-center'>
                    {components['areas']['top-left'].length > 0 && 
                        <div className='col d-flex align-items-center'>
                            {components['areas']['top-left'].map(({Component, Vars, Global}, index) => (
                                <Component global={Global} datas={Vars} key={index} />
                            ))}
                        </div>
                    }
                    {components['areas']['top-right'].length > 0 && 
                        <div className='col'>
                            {components['areas']['top-right'].map(({Component, Vars, Global}, index) => (
                                <Component global={Global} datas={Vars} key={index} />
                            ))}
                        </div>
                    }
                </div>
            </div>
            <div className='card-body'>
                <TableBase hover  datas={props.datas} components={components.listing} actions={components.actions} />
            </div>
            {components['areas']['bottom-left'].length > 0 || components['areas']['bottom-right'].length > 0 &&
                <div className='card-footer'>
                    <div className='row'>
                        {components['areas']['bottom-left'].length > 0 && 
                            <div className='col'>
                                {components['areas']['bottom-left'].map(({Component, Vars, Global}, index) => (
                                    <Component global={Global} datas={Vars} key={index} />
                                ))}
                            </div>
                        }
                        {components['areas']['bottom-right'].length > 0 && 
                            <div className='col'>
                                {components['areas']['bottom-right'].map(({Component, Vars, Global}, index) => (
                                    <Component global={Global} datas={Vars} key={index} />
                                ))}
                            </div>
                        }
                    </div>
                </div>
            }
        </div>
    </>
})

export default TableListing;