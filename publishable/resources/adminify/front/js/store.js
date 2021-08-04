import Vuex from 'vuex'

import User from './store/user';

export const store = new Vuex.Store({
    modules: {
      user: User,
    }
})
