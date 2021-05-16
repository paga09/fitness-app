<template>
    <nav class="navbar navbar-expand-md sticky-top navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-brand">Fitness-app</div>
            <div><img src="../../../storage/app/public/img/nutrition.jpg" alt=""></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav d-flex justify-content-end">
                    <li class="nav-item ">
                        <router-link to="/" class="nav-link" exact>Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/about" class="nav-link">About</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link" v-if="$store.state.authorized">Dashboard</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/mealplan" class="nav-link" v-if="$store.state.authorized">Meal Plans</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/workoutplan" class="nav-link" v-if="$store.state.authorized">Workout Plans</router-link>
                    </li>
                    <li class="nav-item" v-if="!$store.state.authorized">
                        <router-link to="/login" class="nav-link">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="!$store.state.authorized">
                        <router-link to="/register" class="nav-link">Register</router-link>
                    </li>
                    <li class="nav-item" v-if="$store.state.authorized">
                        <a class="nav-link" @click="logout" role="button">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        methods: {
            logout() {
                this.$isLoading(true);
                axios.post('/logout').then(()=> {
                    this.$isLoading(false);
                    this.$store.commit('setAuthorization', false);
                    // sessionStorage.clear();
                    this.$router.push({ name: 'Home' }).catch(err => {})
                })
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>