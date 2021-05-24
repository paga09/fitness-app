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

Vue.component('navbar-component', require('./components/Navbar.vue').default);
Vue.component('footer-component', require('./components/Footer.vue').default);
Vue.component('user-settings-component', require('./components/UserSettings.vue').default);

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
