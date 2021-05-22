<template>
    <div>
        <div class="row">
            <div class="col-xl-3 mb-5 d-flex flex-column flex-sm-row flex-xl-column align-items-center
                        justify-content-center justify-content-sm-around justify-content-xl-start">
                <v-date-picker mode="date" v-model="date" :model-config="modelConfig" is-required
                               :attributes="attributes" locale="en" is-dark :first-day-of-week="2"></v-date-picker>
                <div>
                    <hr>
                    <h3>
                        Total daily volume:
                    </h3>
                    <h3>
                        {{ dailyAmount }} kg
                    </h3>
                </div>
            </div>

            <div class="col-xl-9 mb-5">
                <div v-if="!workouts.length">
                    <h3>
                        No workout plans for this day yet.
                    </h3>
                </div>
                <div class="table-responsive" v-for="(value, index) of workouts">
                    <table class="table table-dark table-round">
                <thead>
                <tr>
                    <th colspan="7" class="font-size-lg border-0">
                        Workout #{{ index+1 }}
                    </th>
                </tr>
                <tr class="border-top">
                    <th scope="col" class="wo-col-wide border-0">Name</th>
                    <th scope="col" class="wo-col-narrow border-0">Set</th>
                    <th scope="col" class="wo-col-narrow border-0">Rep</th>
                    <th scope="col" class="wo-col-narrow border-0">Weight</th>
                    <th scope="col" class="wo-col-narrow border-0">1RM*</th>
                    <th scope="col" class="wo-col-narrow border-0"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="exercise of value.exercises">
                    <th scope="col" class="text-break align-middle">
                        <span  v-if="showEdit !== exercise.id">
                            {{ exercise.name }}
                        </span>
                        <label>
                            <input type="text" v-if="showEdit === exercise.id" v-bind:value="exercise.name" class="form-control"
                                   v-bind:id="exercise.id + '.name'" maxlength="30"  v-on:keyup.enter="editAccept(value.workoutId, exercise.id)" aria-label="exercise name">
                        </label>
                    </th>
                    <th scope="col" class="align-middle">
                        <span  v-if="showEdit !== exercise.id">
                            {{ exercise.set }}
                        </span>

                        <label>
                            <input type="text" maxlength="3"
                                   class="form-control"
                                   v-if="showEdit === exercise.id"
                                   v-bind:value="exercise.set"
                                   v-bind:id="exercise.id + '.set'"
                                   v-on:input="validate(exercise.id + '.set')"
                                   v-on:keyup.enter="editAccept(value.workoutId, exercise.id)"
                                   aria-label="sets"
                            >
                        </label>
                    </th>
                    <th scope="col" class="align-middle">
                        <span  v-if="showEdit !== exercise.id">
                            {{ exercise.repetitions }}
                        </span>

                        <label>
                            <input type="text" maxlength="3"
                                   class="form-control"
                                   v-if="showEdit === exercise.id"
                                   v-bind:value="exercise.repetitions"
                                   v-bind:id="exercise.id + '.repetitions'"
                                   v-on:input="validate(exercise.id + '.repetitions')"
                                   v-on:keyup.enter="editAccept(value.workoutId, exercise.id)"
                                   aria-label="repetitions"
                            >
                        </label>
                    </th>
                    <th scope="col" class="align-middle">
                        <span  v-if="showEdit !== exercise.id">
                            {{ exercise.weight }} kg
                        </span>

                        <label>
                            <input type="text" maxlength="3"
                                   class="form-control"
                                   v-if="showEdit === exercise.id"
                                   v-bind:value="exercise.weight"
                                   v-bind:id="exercise.id + '.weight'"
                                   v-on:input="validate(exercise.id + '.weight')"
                                   v-on:keyup.enter="editAccept(value.workoutId, exercise.id)"
                                   aria-label="weight"
                            >
                        </label>
                    </th>
                    <th scope="col" class="align-middle">
                        <span>
                            {{ calculateOneRM(exercise.repetitions, exercise.weight) }}
                        </span>
                    </th>
                    <th scope="col" class="delete-button-col align-middle">
                        <div class="d-flex">
                            <button type="button" class="btn btn-success m-1" v-on:click="editAccept(value.workoutId, exercise.id)" v-if="showEdit === exercise.id">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-danger m-1" v-on:click="editDecline()" v-if="showEdit === exercise.id">
                                <i class="fas fa-times"></i>
                            </button>
                            <button type="button" class="btn btn-secondary m-1" v-on:click="editExercise(exercise.id)" v-if="showEdit !== exercise.id">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger m-1" v-on:click="deleteExercise(value.workoutId, exercise.id)" v-if="showEdit !== exercise.id">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </th>
                </tr>
                <tr class="border-top">
                    <th colspan="7" class="pb-0 border-0">
                        <p class="mb-0 font-size-sm">
                            *1RM = calculated one rep max between rep ranges [2-12]
                        </p>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" class="border-0">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success m-1" v-on:click="addExercise(value.workoutId)">Add exercise</button>
                            <button type="button" class="btn btn-danger m-1" v-on:click="deleteWorkout(value.workoutId)">Delete workout</button>
                        </div>
                    </th>
                </tr>

                </tbody>
            </table>
                </div>
                <button type="button" class="btn btn-primary" v-on:click="createWorkout">Create new workout</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WorkoutPlan",
        data() {
            return {
                date: this.formatDate(new Date()),
                workouts: [],
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                },
                showEdit: 0,
                attributes: [
                    {
                        dot: true,
                        dates: []
                    }
                ],
                dailyAmount: 0,
            }
        },
        watch: {
            date: function () {
                this.getWorkoutData();
            },
            workouts: function () {
                this.calculateDailyAmount();
            }
        },
        methods: {
            formatDate(date) {
                let d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            },
            createWorkout() {
                axios.post('/api/user/create_workout', {
                    date: this.date
                })
                .then(() => {
                    this.getWorkoutData();
                }, (error) => {
                    console.log(error);
                });
                this.getWorkoutDates();
            },
            deleteWorkout(workoutId) {
                axios.delete('/api/user/delete_workout', {
                    data: {
                        workoutId: workoutId
                    }
                })
                .then(() => {
                    this.getWorkoutData();
                }, (error) => {
                    console.log(error);
                });
                this.getWorkoutDates();
            },
            addExercise(workoutId) {
                axios.post('/api/user/create_exercise', {
                    workoutId: workoutId
                })
                    .then(() => {
                        this.getWorkoutData();
                    }, (error) => {
                        console.log(error);
                    });
            },
            deleteExercise(workoutId, exerciseId) {
                axios.delete('/api/user/delete_exercise', {
                    data: {
                        workoutId: workoutId,
                        exerciseId: exerciseId
                    }
                })
                    .then(() => {
                        this.getWorkoutData();
                    }, (error) => {
                        console.log(error);
                    });
            },
            editExercise(exerciseId) {
                this.showEdit = exerciseId;
            },
            editAccept(workoutId, exerciseId) {
                let validated = true;

                let exerciseName = document.getElementById(exerciseId + '.name').value ? document.getElementById(exerciseId + '.name').value : 'new exercise';
                let exerciseSet = document.getElementById(exerciseId + '.set').value ? parseInt(document.getElementById(exerciseId + '.set').value) : 0;
                let exerciseRep = document.getElementById(exerciseId + '.repetitions').value ? parseInt(document.getElementById(exerciseId + '.repetitions').value) : 0;
                let exerciseWeight = document.getElementById(exerciseId + '.weight').value ? parseInt(document.getElementById(exerciseId + '.weight').value) : 0;

                if(exerciseName.length > 30) {
                    validated = false;
                }

                if(!Number.isInteger(exerciseSet) || !Number.isInteger(exerciseRep) || !Number.isInteger(exerciseWeight)) {
                    validated = false;
                }


                if(validated) {
                    axios.put('/api/user/edit_exercise', {
                        workoutId,
                        exerciseId,
                        exerciseName,
                        exerciseSet,
                        exerciseRep,
                        exerciseWeight
                    })
                    .then(() => {
                        this.getWorkoutData();
                    }, (error) => {
                        console.log(error);
                    });
                }

                this.showEdit = 0;
            },
            editDecline() {
                this.showEdit = 0;
            },
            getWorkoutDates() {
                axios.get('/api/user/workout_dates').then((response) => {
                    const attrs = this.attributes.slice();
                    attrs[0].dates = [];
                    response.data.forEach(element => attrs[0].dates.push(element.date));
                    this.attributes = attrs;
                });
            },
            getWorkoutData() {
                this.$isLoading(true);
                axios.get('/api/user/workouts', {
                    params: {
                        date: this.date
                    }
                }).then((response) => {
                    this.$isLoading(false);
                    this.workouts = response.data
                }, (error) => {
                    this.$isLoading(false);
                });
            },
            calculateOneRM(rep, weight) {
                if(rep > 1 && rep <= 12){
                    return Math.round(weight / (1.02 - rep * 0.0255)) + ' kg';
                }
                return "*";
            },
            calculateDailyAmount() {
                this.dailyAmount = 0;

                this.workouts.forEach(element => element.exercises.forEach(e =>
                    this.dailyAmount += parseInt(e.set) * parseInt(e.repetitions) * parseInt(e.weight)
                ));
            },
            validate(id) {
                if(document.getElementById(id).value.includes(",")) {
                    document.getElementById(id).value = document.getElementById(id).value.replace(",", ".");
                }
                if(isNaN(document.getElementById(id).value) || /[a-z]/i.test(document.getElementById(id).value)) {
                    document.getElementById(id).style.color = "red";
                } else {
                    document.getElementById(id).style.color = null;
                }
            },
        },
        mounted() {
            this.getWorkoutData();
            this.getWorkoutDates();
        },
    }
</script>

<style scoped>
    .delete-button-col {
        width: 5%;
        padding-top: 2px;
        padding-bottom: 2px
    }

    .wo-col-narrow {
        min-width: 70px;
        width: 12%;
    }

    .wo-col-wide {
        min-width: 200px;
        width: 40%;
    }

    label {
        margin-bottom: 0;
    }

</style>