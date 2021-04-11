import store from './store/index'

/**
 * Components imports
 */

//user
const login = () => import('./pages/LoginPage');
const userNew = () => import('./pages/user/UserRegistration');
const userProfile = () => import('./pages/user/Profile');
const userList = () => import('./pages/user/List');
//apps
const createOrEdit = () => import('./pages/apps/CreateOrEdit');
const listApps = () => import('./pages/apps/list');
const listAppsCollections = () => import('./pages/collections/Collections');
//collections
const createOrEditCollections = () => import('./pages/collections/Edit');


/** Routes for SPA */
const routes = [
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
  {
    path: '/application/:slug/collections/create',
    name: 'app.collections.create',
    component: createOrEditCollections,
  },
  {
    path: '/application/:slug/collections/:collection',
    name: 'app.collections.edit',
    component: createOrEditCollections,
  },
];

export default routes;