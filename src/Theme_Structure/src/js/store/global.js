export default {
    state: () => { return {
        data : {}
     }},
    mutations: {
        addData (state, payload) {
            let payload_keys = Object.keys(payload);
            payload_keys.forEach((payload_key) => {
                if(state.data[payload_key] == undefined) {
                    state.data[payload_key] = null;
                }
                state.data[payload_key] = payload[payload_key];
            })
        }
    },
    actions: {}
}
