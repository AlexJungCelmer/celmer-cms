require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import store from './store/index'
import { ToastPlugin } from 'bootstrap-vue'

Vue.use(VueRouter)
Vue.use(ToastPlugin)

/** All general components */
var files = require.context('./components', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/** Register pages */
var files = require.context('./pages', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

let App = () => import('./VueApp');
Vue.component('VueApp', App)

import Routes from './router'

const router = new VueRouter({
	mode: 'history',
	routes: Routes,
});

const app = new Vue({
	el: '#app',
	components: { App },
	router,
	store
})