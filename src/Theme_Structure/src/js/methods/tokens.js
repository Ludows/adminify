
export function getToken() {

    let route = Route('api.token');

    axios({
        'method' : 'POST',
        'url' : route,
        'data' : {}
    })
    .then((response) => {
        console.log('response', response)
        localStorage.setItem('api-token', response.data.token)
    })
    .catch((err) => {
        console.log('whooops', err)
    })
}

export function tokenFromLocalStorage() {
    return localStorage.getItem('api-token');
}

export function verifyToken() {
    let route = Route('api.token.verify');

    axios({
        'method' : 'POST',
        'url' : route,
        'data' : {
            'token': localStorage.getItem('api-token')
        }
    })
    .then((response) => {
        console.log('response', response)
        if(response.data.isValid == false) {
            refreshToken();
        }
    })
    .catch((err) => {
        console.log('whooops', err)
    })
}

export function refreshToken() {
    let route = Route('api.token.refresh');

    this.$axios({
        'method' : 'POST',
        'url' : route,
        'data' : {}
    })
    .then((response) => {
        console.log('response', response)
        localStorage.setItem('api-token', response.data.token)
    })
    .catch((err) => {
        console.log('whooops', err)
    })
}