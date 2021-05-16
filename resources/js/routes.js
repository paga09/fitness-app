import Home from './components/Home'
import About from './components/About'
import PageNotFound from './components/PageNotFound'
import Register from './components/Register'
import Login from './components/Login'
import Dashboard from './components/Dashboard'
import MealPlan from './components/MealPlan'
import WorkoutPlan from './components/WorkoutPlan'

export default {
    mode: 'history',
    linkActiveClass: 'font-weight-bold',
    routes: [
        {
            path: '*',
            component: PageNotFound,
            name: 'PageNotFound'
        },
        {
            path: '/',
            component: Home,
            name: 'Home'
        },
        {
            path: '/about',
            component: About,
            name: 'About'
        },
        {
            path: '/register',
            component: Register,
            name: 'Register',
        },
        {
            path: '/login',
            component: Login,
            name: 'Login',
        },
        {
            path: '/mealplan',
            component: MealPlan,
            name: 'MealPlan',
        },
        {
            path: '/workoutplan',
            component: WorkoutPlan,
            name: 'WorkoutPlan',
        },
        {
            path: '/dashboard',
            component: Dashboard,
            name: 'Dashboard',
        }
    ]
}