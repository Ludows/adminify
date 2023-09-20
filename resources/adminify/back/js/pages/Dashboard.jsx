import React, { useEffect } from 'react';
import usePageProps from '../hooks/usePageProps';
import DashboardCard from '../components/Cards/DashboardCard';
export default function Dashboard() {

    const { get } = usePageProps();
    const datas = get('blocks');
    
    useEffect(() => {
        console.log('Dashboard.jsx onMounted', datas);
    }, [])

    return <div className='row'>
                {Object.keys(datas).map((key, index, array) => {
                    return <div key={index} className='col-12 col-lg-4 mb-3'>
                        <DashboardCard namedBloc={key} singleParam={ datas[key]['singleParam'] } labelShow={ datas[key]['labelShow'] } data={datas[key]['model']} />
                    </div>
                    
                })}
            </div>
}