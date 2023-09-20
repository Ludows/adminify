import React, {useContext, useEffect, useState} from 'react';
import Pagination from 'react-bootstrap/Pagination';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function Paginate(props) {
    const [links, setLinks] = useState(props.links ?? []);
    const [activeItem, setActiveItem] = useState(1);
    const [on, off, emit] = useContext(EmitterContext);

    const handleResults = (datas) => {
        // console.log('update paginate', datas);
        // // setRows(datas.result.rows);
        // if(datas.payload.search.length > 0 && previousPayload.current && previousPayload.current.search != datas.payload.search) {
        //     setActiveItem(1);
        // }
        // setLinks(datas.result.paginator.links);
        // previousPayload.current = datas.payload;
    }

    const doNavigate = (isActive = false, linkObject) => {
        if(isActive) {
            return false;
        }

        let number = parseInt(linkObject.label);

        setActiveItem( number );

        emit('adminify:mediapicker:search', {
            page : number
        })
    }

    useEffect(() => {
        on('adminify:mediapicker:results', handleResults);
        console.log('Paginate.jsx onMounted', props);
        return () => {
            off('adminify:mediapicker:results', handleResults);
        }
    }, [])

    return <Pagination>
                {links.map((link, index) => {
                    let try_to_force_in_number = parseInt(link.label);
                    if(!isNaN(try_to_force_in_number)) {
                        return <Pagination.Item key={index} onClick={() => { doNavigate(activeItem == try_to_force_in_number, link) }} active={activeItem == try_to_force_in_number}>{link.label}</Pagination.Item>
                    }
                })}
            </Pagination>
}
