
export function getToken() {

    let route = this.$route('api.token');

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

export function tokenFromLocalStorage() {
    return localStorage.getItem('api-token');
}

export function verifyToken() {
    let route = this.$route('api.token.verify');

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

export function refreshToken() {
    let route = this.$route('api.token.refresh');

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