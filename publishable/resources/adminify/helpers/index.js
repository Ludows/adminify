import axios from 'axios';
function createAxios(url = '', axiosProps = {}) {

    let defaults = {
        method: 'get',
        url: '',
        data: {}
    }
    
    let options = Object.assign({}, defaults ,axiosProps, {url});

    return axios(options);
}

export {
    createAxios,
}
