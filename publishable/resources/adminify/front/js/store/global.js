export default {
    state: () => {{ 
        data : {}
     }},
    mutations: {
        addData (state, payload) {
            let payload_keys = Object.keys(payload);
            payload_keys.forEach((payload_key) => {
                state.data[payload_key] = payload[payload_key];
            })
            state.count++
        }
    },
    actions: {}
}