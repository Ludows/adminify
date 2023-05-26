import React, { useState, useContext, useEffect } from 'react';
import ToastContainer from 'react-bootstrap/ToastContainer';
import { EmitterContext } from "../contexts/EmitterContext";
import Notification from './Notification';
export default function Notifications(props) {
    const [notifications, setNotifications] = useState([]);
    const [on, off, emit] = useContext(EmitterContext);

    useEffect(() => {
        let handleNotifications = (datas) => {

        }
        on('adminify:notify', handleNotifications);

        return () => {
            off("adminify:notify", handleNotifications);
        }
    }, [])

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
