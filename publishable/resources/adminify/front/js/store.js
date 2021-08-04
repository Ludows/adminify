import Vue from 'vue'
import Vuex from 'vuex'

import Global from './store/global';

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,
    modules: {
      global: Global,
    }
})
