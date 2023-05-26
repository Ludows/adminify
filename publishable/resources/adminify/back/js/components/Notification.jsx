import React from 'react';
import Toast from 'react-bootstrap/Toast';

export default function Notification(props) {
    return <>
        <Toast
          {...props}
        >
            {props.showHeader &&
                <Toast.Header>
                    {props.header_text}
                </Toast.Header>
            }
          <Toast.Body>
             {props.body_text}
          </Toast.Body>
        </Toast>
    </>
}
