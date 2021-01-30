/**
 * Components imports
 */

let login = () => import('./pages/LoginPage');
let userNew = () => import ('./pages/user/UserRegistration');
let userProfile = () => import ('./pages/user/Profile');
let userList = () => import ('./pages/user/List');
let createApp = () => import ('./pages/apps/createApp');
let listApps = () => import ('./pages/apps/list');

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
        path: '/apps',
        name: 'app.list',
        component: listApps,
    },
    {
        path: '/apps/create',
        name: 'app.new',
        component: createApp,
    },
    {
        path: '/apps/:slug',
        name: 'app.edit',
        component: createApp,
    },
];

export default routes;