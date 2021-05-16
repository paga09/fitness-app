<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-10 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
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
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-model="formData.password_confirmation">
                            <p class="text-danger" v-text="errors.password_confirmation"></p>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <button @click.prevent="registerUser" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                            <div class="col text-right">
                                Already registered? <br>
                                <router-link to="/login">Log in</router-link>
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
        data() {
            return {
                formData: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {}
            }
        },
        methods: {
            registerUser(){
                axios.post('api/register', this.formData).then(() => {
                    this.formData.email = this.formData.password = this.formData.password_confirmation = '';
                    this.errors = {};
                    this.$router.push('/login');
                }).catch((errors) => {
                    this.errors = errors.response.data.errors;
                });
            }
        },
        mounted() {
            document.getElementById("email").focus();
        }
    }
</script>