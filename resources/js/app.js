/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import VCalendar from 'v-calendar';
import loading from 'vuejs-loading-screen'

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VCalendar);
Vue.use(loading);

const router = new VueRouter(routes);

router.beforeEach((to, from, next) => {
    if ((to.name === 'Login' || to.name === 'Register') && store.state.authorized) {
        next({ name: 'Home' });
    } else if (to.name === 'Dashboard' || to.name === 'WorkoutPlan' || to.name === 'MealPlan') {
        axios.get('/api/authenticated').then(() => {
            next()
        }).catch(() => {
            next({ name: 'Login'});
        })
    } else {
        next();
    }
});


const store = new Vuex.Store({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    state: {
        authorized: false
    },
    mutations: {
        setAuthorization (state, value) {
            state.authorized = value
        }
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('navbar-component', require('./components/Navbar.vue').default);
Vue.component('user-settings-component', require('./components/UserSettings.vue').default);
Vue.component('footer-component', require('./components/Footer.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    created () {
        axios.interceptors.response.use((response) => {
            return response;
        }, (error) => {
            if (error.response.status === 401 || error.response.status === 419) {
                store.commit('setAuthorization', false);
                this.$router.push({ name: 'Login' });
            }
            return Promise.reject(error);
        });
    }
});
