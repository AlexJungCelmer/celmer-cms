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
//entries
const listEntries = () => import('./pages/entries/List');
const editEntrie = () => import('./pages/entries/Edit');


/** Routes for SPA */
const routes = [
  {
    path: '/login',
    name: 'login',
    component: login,
  },

  // user
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

  // app
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

  // collections
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
    path: '/application/:slug/collections/:collection',
    name: 'app.collections.edit',
    component: createOrEditCollections,
  },

  //entries
  {
    path: '/application/:slug/collections/:collection/entries',
    name: 'app.collections.entries',
    component: listEntries,
  },
  {
    path: '/application/:slug/collections/:collection/entries/:id',
    name: 'app.collections.entries.edit',
    component: editEntrie,
  },
];

export default routes;