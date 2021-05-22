<template>
    <div>
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-between">

                <div class="card text-white bg-dark mb-3">
                    <h5 class="card-header">Your profile</h5>
                    <div class="card-body border-top">
                        <h5 class="card-text">Email: {{ email }}</h5>
                        <h5 class="card-text">Joined: {{ registrationDate }}</h5>
                    </div>
                </div>

                <div class="d-none d-lg-flex justify-content-center">
                    <button type="button" class="btn btn-danger" @click.prevent="logout">Logout</button>
                </div>

            </div>
            <div class="col-lg-6">
                <user-settings-component></user-settings-component>
            </div>

            <div class="col-12 d-flex justify-content-center d-lg-none">
                <button type="button" class="btn btn-danger" @click.prevent="logout">Logout</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                email: '',
                registrationDate: ''
            }
        },
        methods: {
            logout() {
                this.$isLoading(true);
                axios.post('/logout').then(()=> {
                    this.$isLoading(false);
                    this.$store.commit('setAuthorization', false);
                    this.$router.push({ name: 'Login' })
                }, (error) => {
                    this.$isLoading(false);
                })
            }
        },
        mounted() {
            this.$isLoading(true);
            axios.get('/api/user').then((response) => {
                this.$isLoading(false);
                this.email = response.data.email;
                this.registrationDate = response.data.created_at.substring(0, 10);
            }, (error) => {
                this.$isLoading(false);
            })
        }
    }
</script>

<style scoped>

</style>