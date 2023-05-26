import React,{ useEffect, useState, useRef, useContext } from 'react';
import Table from 'react-bootstrap/Table';
import useGlobalStore from '@/back/js/store/global';
import Pagination from 'react-bootstrap/Pagination';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function TablePaginate(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);
    const [activeItem, setActiveItem] = useState(1);
    const previousPayload = useRef({});
    const [links, setLinks] = useState(props.data.links ?? []);
    const [on, off, emit] = useContext(EmitterContext);

    const handleResults = (datas) => {
        console.log('update paginate', datas);
        // setRows(datas.result.rows);
        if(datas.payload.search.length > 0 && previousPayload.current && previousPayload.current.search != datas.payload.search) {
            setActiveItem(1);
        }
        setLinks(datas.result.paginator.links);
        previousPayload.current = datas.payload;
    }

    const doNavigate = (isActive = false, linkObject) => {
        if(isActive) {
            return false;
        }

        let number = parseInt(linkObject.label);

        setActiveItem( number );

        emit('adminify:table:search', {
            page : number
        })

        // emit('adminify:ajax', {
        //     method: 'get',
        //     url : linkObject.url,
        //     data : {},
        //     config : {
        //         headers : { 'X-Inertia' : true, 'X-Inertia-Version' : 'version' },
        //     }
        // })
        
    }

    useEffect(() => {
        on('adminify:table:results', handleResults);
        console.log('TablePaginate.jsx onMounted', props);
        return () => {
            off('adminify:table:results', handleResults);
        }
    }, [])
    return <>
        <Pagination>
            {links.map((link, index) => {
                let try_to_force_in_number = parseInt(link.label);
                if(!isNaN(try_to_force_in_number)) {
                    return <Pagination.Item key={index} onClick={() => { doNavigate(activeItem == try_to_force_in_number, link) }} active={activeItem == try_to_force_in_number}>{link.label}</Pagination.Item>
                }
            })}
        </Pagination>
    </>
}