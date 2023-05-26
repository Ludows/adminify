import axios from 'axios';
function createAxios(url = '', axiosProps = {}, axiosConfig = {}) {

    let defaults = {
        method: 'get',
        url: '',
        data: {}
    }
    
    let options = Object.assign({}, defaults ,axiosProps, {url});

    let axiosInstance = axios(options);
    
    return axiosInstance;
}

export {
    createAxios,
}
