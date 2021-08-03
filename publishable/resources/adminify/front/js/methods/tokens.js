
export function getToken() {

    let route = this.$route('api.token');

    this.$axios({
        'method' : 'POST',
        'url' : route,
        'data' : {}
    })
    .then((response) => {
        console.log('response', response)
    })
    .catch((err) => {
        console.log('whooops', err)
    })
}