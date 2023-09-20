import React, { useEffect } from 'react';
import useTranslations from '../../hooks/useTranslations';
import useRoute from '../../hooks/useRoute';
import useHelpers from '../../hooks/useHelpers';
import { Button } from 'react-bootstrap';
export default function DashboardCard(props) {
    const { get } = useTranslations();
    const { navigate } = useHelpers();
    const { namedBloc, data, singleParam, labelShow, as = 'admin' } = props;

    const getName = (name) => {
        if(as.length > 0) {
            return as+'.'+name
        }
        return name;
    }

    const { get:getRoute, has } = useRoute();
    let namedEdit = getName(namedBloc+'.edit');
    let namedCreate = getName(namedBloc+'.create');
    let namedIndex = getName(namedBloc+'.index');

    const hasEdit = has( namedEdit ); 
    const hasCreate = has( namedCreate ); 

    

    const handleEditClick = (model) => {

        let o = {};
        o[singleParam] = model.id;

        navigate({
            url : getRoute(namedEdit, o),
            method: 'get',
        })
    }
    const handleCreateClick = () => {
        navigate({
            url : hasCreate ? getRoute( namedCreate ) : getRoute( namedIndex ),
            method: 'get',
        })
    }

    return <>
        <div className='card  h-100'>
            <div className='card-header'>
                <div className='d-flex align-items-center flex-column flex-lg-row justify-content-lg-between'>
                    <div className=''>
                        {get('dashboard.'+namedBloc)}
                    </div>
                    <div className=''>
                        <Button variant="primary" onClick={handleCreateClick}>{hasCreate ? get('global.create') : get('global.index')}</Button>
                    </div>
                </div>
                
            </div>
            <div className='card-body'>
               {data.map((model, index, array) => {
                    return <div className='d-flex w-100 flex-lg-row flex-column justify-content-lg-between align-items-lg-center mb-3'>
                        <div className=''>
                            {model[labelShow]}
                        </div>
                        <div className=''>
                            {hasEdit && 
                                <Button variant="primary" onClick={() => { handleEditClick(model) }}>{get('global.edit')}</Button>
                            }
                        </div>
                    </div>
               })}
            </div>
        </div>
    </>
}