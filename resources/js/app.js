require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/index'
import UserController from './plugins/UserController'

import '@mdi/font/css/materialdesignicons.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

const vuetify = new Vuetify({
	icons: {
		iconfont: 'mdiSvg',
	},
});
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(UserController, {
	scopes: {
		application: [
			'application',
			'profile',
			'collection:view',
			'collection:data',
		],
		user: store.state.user.user.can
	}
});

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
	store,
	vuetify
})