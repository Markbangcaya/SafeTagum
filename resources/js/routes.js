import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
const routes = [
    {
        path: '*',
        name: 'not-found',
        component: require('./components/NotFound.vue').default
    },
    //---------------------------------------------------------DASHBOARD
    {
        path: '/Dashboard',
        name: 'Dashboard',
        component: require('./components/Dashboard.vue').default
    },
    //---------------------------------------------------------END DASHBOARD
    //---------------------------------------------------------PATIENT
    {
        path: '/Patient',
        name: 'Patient',
        component: require('./components/Patient/Index.vue').default,
    },
    //---------------------------------------------------------END PATIENT
    //---------------------------------------------------------FORECAST
    {
        path: '/Forecast',
        name: 'Forecast',
        component: require('./components/Forecast/Index.vue').default
    },
    //---------------------------------------------------------END FORECAST
    //---------------------------------------------------------REPORT
    {
        path: '/Report',
        name: 'Report',
        component: require('./components/Report/Index.vue').default
    },
    //---------------------------------------------------------END REPORT
    //---------------------------------------------------------DISEASE
    {
        path: '/disease',
        name: 'disease',
        component: require('./components/Disease/IndexDisease.vue').default,
        props: true,
    },
    //---------------------------------------------------------END DISEASE
    //---------------------------------------------------------USER
    {
        path: '/users',
        name: 'users',
        component: require('./components/Users/IndexUser.vue').default,
        props: true,
    },
    //---------------------------------------------------------END USER
    //---------------------------------------------------------USER
    {
        path: '/profile',
        name: 'profile',
        component: require('./components/Profile/IndexProfile.vue').default,
        props: true,
    },
    //---------------------------------------------------------END USER
    //---------------------------------------------------------ROLE
    {
        path: '/role',
        name: 'role',
        component: require('./components/Role/IndexRole.vue').default,
        props: true,
    },
    // {
    //     path: '/role-add/:page',
    //     name: 'role_add',
    //     component: require('./components/Role/AddRole.vue').default,
    //     props: true,
    // },
    //---------------------------------------------------------END ROLE
    //---------------------------------------------------------PERMISSION
    {
        path: '/permission',
        name: 'permission',
        component: require('./components/Permission/IndexPermission.vue').default
    },
    // {
    //     path: '/permission-add',
    //     name: 'permission-add',
    //     component: require('./components/Permission/AddPermission.vue').default
    // },
    //---------------------------------------------------------END PERMISSION
    //---------------------------------------------------------REGISTRAR
    {
        path: '/registrar',
        name: 'registrar',
        component: require('./components/Registrar/IndexRegistrar.vue').default
    },
    //---------------------------------------------------------END REGISTRAR
    //---------------------------------------------------------PROGRAM
    {
        path: '/program',
        name: 'program',
        component: require('./components/Program/IndexProgram.vue').default
    },
    //---------------------------------------------------------END PROGRAM
]
// Vue.component(
//     'enrollment-status',
//     require('./components/EnrollmentStatus.vue').default
// );
const router = new Router({
    mode: 'history',
    routes: routes
});

export default router
