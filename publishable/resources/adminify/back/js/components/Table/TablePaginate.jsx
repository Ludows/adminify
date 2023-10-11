import React,{ useState, useRef } from 'react';
import Pagination from 'react-bootstrap/Pagination';
import useHelpers from '../../hooks/useHelpers';

export default function TablePaginate(props) {
    const [activeItem, setActiveItem] = useState(1);
    const previousPayload = useRef({});
    const [links, setLinks] = useState(props.data.links ?? []);
    const { onTableResults, tableSearch } = useHelpers();


    const handleResults = (datas) => {
        console.log('update paginate', datas);
        // setRows(datas.result.rows);
        if(datas.payload.search.length > 0 && previousPayload.current && previousPayload.current.search != datas.payload.search) {
            setActiveItem(1);
        }
        setLinks(datas.result.paginator.links);
        previousPayload.current = datas.payload;
    }

    onTableResults(handleResults, [])


    const doNavigate = (isActive = false, linkObject) => {
        if(isActive) {
            return false;
        }

        let number = parseInt(linkObject.label);

        setActiveItem( number );

        tableSearch({
            page : number
        })
    }
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