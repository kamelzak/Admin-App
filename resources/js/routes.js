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
    }
];

export default new VueRouter({
    routes
});