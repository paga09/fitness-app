<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-10 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body" v-on:keyup.enter="login">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" v-model="formData.email">
                            <p class="text-danger" v-text="errors.email"></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" v-model="formData.password">
                            <p class="text-danger" v-text="errors.password"></p>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <button @click.prevent="login" class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </div>
                            <div class="col text-right">
                                <router-link to="/register">Create New Account</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                formData: {
                    email: '',
                    password: '',
                    device_name: 'browser'
                },
                errors: []
            }
        },
        methods: {
            login() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData).then((response) => {
                        this.$store.commit('setAuthorization', true);
                        this.$router.push({ name: 'Dashboard' });
                    }).catch((error) =>{
                        this.errors = error.response.data.errors;
                    })
                });
            }
        },
        mounted() {
            document.getElementById("email").focus();
        }
    }
</script>

<style scoped>

</style>