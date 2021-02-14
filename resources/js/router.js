import store from './store/index'

/**
 * Components imports
 */

let login = () => import('./pages/LoginPage');
let userNew = () => import('./pages/user/UserRegistration');
let userProfile = () => import('./pages/user/Profile');
let userList = () => import('./pages/user/List');
let createOrEdit = () => import('./pages/apps/CreateOrEdit');
let listApps = () => import('./pages/apps/list');
let listAppsCollections = () => import('./pages/apps/Collections');

/** Routes for SPA */
let routes = [
  {
    path: '/login',
    name: 'login',
    component: login,
  },
  {
    path: '/user/new',
    name: 'user.new',
    component: userNew,
  },
  {
    path: '/user/:slug',
    name: 'user.edit',
    component: userNew,
  },
  {
    path: '/user',
    name: 'user.list',
    component: userList,
  },
  {
    path: '/my-profile',
    name: 'user.profile',
    component: userProfile,
  },

  {
    path: '/applications',
    name: 'app.list',
    component: listApps,
  },
  {
    path: '/application/create',
    name: 'app.new',
    component: createOrEdit,
  },
  {
    path: '/application/:slug',
    name: 'app.edit',
    component: createOrEdit,
  },
  {
    path: '/application/:slug/collections',
    name: 'app.collections',
    component: listAppsCollections,
    beforeEnter: (to, from, next) => {
      store.dispatch('getApplication', to.params.slug).then(resp => {
        console.log('a');
        next();
      })
    }
  },
];

export default routes;