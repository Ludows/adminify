import React, { useState } from 'react';
import ToastContainer from 'react-bootstrap/ToastContainer';
import Notification from './Notification';
import useHelpers from '../hooks/useHelpers';

export default function Notifications(props) {
    const [notifications, setNotifications] = useState([]);
    const { onNotify } = useHelpers();

    let handleNotifications = (datas) => {
        console.log('onNotify...', datas);
        let currentNotif = datas;
        setNotifications((notifs) => [...notifs, currentNotif]);
        if(currentNotif.useTimer) {
            setTimeout(() => {
                setNotifications((notifs) => notifs.filter((notif, index, array) => { return notif.uuid != currentNotif.uuid}));
            }, currentNotif.time)
        }
    }
    onNotify(handleNotifications, []);
   

    return <>
        <div
            aria-live="polite"
            aria-atomic="true"
            className="bg-transparent position-absolute"
            style={{ minHeight: '240px' }}
            >
            <ToastContainer position="bottom-end">
                {notifications.map((notification, index) => (
                    <Notification {...notification} key={index} />
                ))}
            </ToastContainer>
        </div>
    </>
}
