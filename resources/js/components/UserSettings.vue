<template>
    <div>
        <div class="card text-white bg-dark mb-3">
            <h5 class="card-header">Settings</h5>
            <div class="card-body border-top">
                <div class="form-check card-text mb-2">
                    <input class="form-check-input" type="checkbox" value="protein" id="proteinCheck" v-model="checkedSettings.protein">
                    <label class="form-check-label" for="proteinCheck">
                        Show amount of protein
                    </label>
                </div>
                <div class="form-check card-text mb-2">
                    <input class="form-check-input" type="checkbox" value="carbs" id="carbsCheck" v-model="checkedSettings.carbs">
                    <label class="form-check-label" for="carbsCheck">
                        Show amount of carbohydrates
                    </label>
                </div>
                <div class="form-check card-text mb-2">
                    <input class="form-check-input" type="checkbox" value="fat" id="fatCheck" v-model="checkedSettings.fat">
                    <label class="form-check-label" for="fatCheck">
                        Show amount of fat
                    </label>
                </div>
                <div class="form-check card-text mb-2">
                    <input class="form-check-input" type="checkbox" value="fiber" id="fiberCheck" v-model="checkedSettings.fiber">
                    <label class="form-check-label" for="fiberCheck">
                        Show amount of fiber
                    </label>
                </div>
                <div class="form-check card-text mb-2">
                    <input class="form-check-input" type="checkbox" value="kcal" id="kcalCheck" v-model="checkedSettings.kcal">
                    <label class="form-check-label" for="kcalCheck">
                        Show amount of kcal
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserSettings",
        data() {
            return {
                checkedSettings: {
                    protein: false,
                    carbs: false,
                    fat: false,
                    fiber: false,
                    kcal: false,
                }
            }
        },
        watch: {
            checkedSettings: {
                handler() {
                    this.editUserSettings();
                },
                deep: true,
            }
        },
        methods: {
            getUserSettings() {
                this.$isLoading(true);
                axios.get('/api/user/get_user_settings').then((response) => {
                    this.$isLoading(false);
                    this.checkedSettings = response.data;
                });
            },
            editUserSettings() {
                this.$isLoading(true);
                axios.post('/api/user/edit_user_settings', {
                    checkedSettings: this.checkedSettings
                }).then(() => {
                        this.$isLoading(false)
                    })
            }
        },
        created() {
            this.getUserSettings();
        }
    }
</script>

<style scoped>

</style>