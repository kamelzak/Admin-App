import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

let routes = [
    {
        path : '/dashboard',
        component : require('./components/dashboard.vue').default
    },
    {
        path : '/profile',
        component : require('./components/profile.vue').default
    },
    {
        path : '/users',
        component : require('./components/users.vue').default
    },
    {
        path : '/developper',
        component : require('./components/developper.vue').default
    },
    {
        path : '/tasks',
        component : require('./components/tasks.vue').default
    },
    {
        path : '/tasks-management',
        component : require('./components/tasksManagement.vue').default
    },
    {
        path : '*',
        component : require('./components/NotFound.vue').default
    }
];

export default new VueRouter({
    mode : 'history',
    routes,
    linkActiveClass : 'active'
});