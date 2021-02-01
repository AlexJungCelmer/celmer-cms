import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


//modules

import user from './modules/user'
import application from './modules/application'

export default new Vuex.Store({
    modules: {
        user, application
    }
})