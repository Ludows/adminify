import Vuex from 'vuex'

import User from './store/user';

export default new Vuex.Store({
    namespaced: true,
    modules: {
      user: User,
    }
})
