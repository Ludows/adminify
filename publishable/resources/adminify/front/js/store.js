import Vue from 'vue'
import Vuex from 'vuex'

import User from './store/user';

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,
    modules: {
      user: User,
    }
})
