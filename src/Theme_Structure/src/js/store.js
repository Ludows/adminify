import { createStore } from 'vuex'

import Global from './store/global';

export default createStore({
    namespaced: true,
    modules: {
      global: Global,
    }
})
