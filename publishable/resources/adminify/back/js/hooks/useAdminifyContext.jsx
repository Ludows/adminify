
import React, {useCallback, useContext} from 'react';
import { AdminifyContext } from '../contexts/AdminifyContext';

export default function useAdminifyContext() {
    let methods = useContext(AdminifyContext);
    return methods;
}
