<template>
    <div>
        <div class="row">
            <div class="col-xl-3 d-flex mb-5 flex-column">

                <div class="d-flex flex-column flex-sm-row flex-xl-column">
                    <div class="col-sm-6 col-xl-12 d-flex justify-content-center justify-content-xl-start info-container">
                        <v-date-picker mode="date" v-model="date" :model-config="modelConfig" is-required
                                       :attributes="attributes" locale="en" is-dark
                                       :first-day-of-week="2"></v-date-picker>
                    </div>


                    <div class="col-sm-6 col-xl-12 info-container">
                        <hr>
                        <h3>
                            Daily consumption:
                        </h3>
                        <div v-show="checkedSettings.protein">Protein: {{ dailyAmount.protein }} g</div>
                        <div v-show="checkedSettings.carbs">Net Carbs: {{ dailyAmount.carbs }} g</div>
                        <div v-show="checkedSettings.fat">Fat: {{ dailyAmount.fats }} g</div>
                        <div v-show="checkedSettings.fiber">Fiber: {{ dailyAmount.fiber }} g</div>
                        <div v-show="checkedSettings.kcal">Energy: {{ dailyAmount.kcal }} kcal</div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row-reverse flex-xl-column">
                    <div v-if="(recommendations.fiber || recommendations.protein || recommendations.fat ||
                    recommendations.kcal )
                            && meals.length !== 0" class="col-sm-6 col-xl-12 info-container">
                        <hr>
                        <h3>
                            Recommendations:
                        </h3>
                        <ul>
                            <li v-if="recommendations.fiber">More fiber intake</li>
                            <li v-if="recommendations.protein">More protein intake</li>
                            <li v-if="recommendations.fat">More (healthy) fat intake</li>
                            <li v-if="recommendations.kcal">
                                Too big of a difference between daily macronutrient intake and calories
                            </li>
                        </ul>
                    </div>

                    <div v-if="checkedSettings.protein && checkedSettings.carbs && checkedSettings.fat && meals.length"
                         class="col-sm-6 col-xl-12 info-container">
                        <hr>
                        <h3>
                            Macronutrient ratio:
                        </h3>
                        <PieChart :chartData="chartData" :options="chartOptions"
                                  :key="chartData.datasets[0].data[0] + chartData.datasets[0].data[1]
                              + chartData.datasets[0].data[2]"></PieChart>
                    </div>
                </div>

            </div>

            <div class="col-xl-9 mb-5">
                <div v-if="!meals.length">
                    <h3>
                        No meal plans for this day yet.
                    </h3>
                </div>
                <div class="table-responsive" v-for="(value, index) of meals">
                    <table class="table table-dark table-round">
                        <thead>
                        <tr>
                            <th colspan="8" class="font-size-lg border-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Meal #{{ index+1 }}
                                        <div class="font-size-sm font-weight-lighter">
                                            id: {{ value.mealId }}
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-info"
                                                v-on:click="compactMode.push(value.mealId)"
                                                v-if="!compactMode.includes(value.mealId)"
                                        >
                                            Hide
                                        </button>
                                        <button type="button" class="btn btn-warning"
                                                v-on:click="compactMode = compactMode.filter(item => item !== value.mealId)"
                                                v-if="compactMode.includes(value.mealId)"
                                        >
                                            Show
                                        </button>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr class="border-top">
                            <th class="border-0 mp-col-wide" scope="col">
                                <div v-show="!compactMode.includes(value.mealId)">Name</div>
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col">Quantity</th>
                            <th class="border-0 mp-col-narrow" scope="col"
                                v-if="checkedSettings.protein">Protein
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col"
                                v-if="checkedSettings.carbs">Carbs
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col"
                                v-if="checkedSettings.fat">Fat
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col"
                                v-if="checkedSettings.fiber">Fiber
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col"
                                v-if="checkedSettings.kcal">Kcal
                            </th>
                            <th class="border-0 mp-col-narrow" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="food of value.foods" v-show="!compactMode.includes(value.mealId)">
                            <td scope="col" class="text-break align-middle">
                                <span v-if="showEdit !== food.id" class="text-break">
                                    {{ food.name }}
                                </span>
                                <label>
                                    <input type="text" v-if="showEdit === food.id" v-bind:value="food.name"
                                           class="form-control"
                                           v-bind:id="food.id + '.name'" maxlength="30"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)" aria-label="food name">
                                </label>
                            </td>

                            <td scope="col" class="align-middle">
                                <span v-if="showEdit !== food.id">
                                    {{ food.quantity }} g
                                </span>
                                <label>
                                    <input type="text" maxlength="4"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.quantity"
                                           v-bind:id="food.id + '.quantity'"
                                           v-on:input="validate(food.id + '.quantity')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="quantity"
                                    >
                                </label>
                            </td>

                            <td scope="col" v-show="checkedSettings.protein" class="align-middle">
                        <span v-if="showEdit !== food.id">
                            {{ food.protein }} g
                        </span>
                                <label>
                                    <input type="text" maxlength="5"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.protein"
                                           v-bind:id="food.id + '.protein'"
                                           v-on:input="validateMacro(food.id + '.protein')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="protein"
                                    >
                                </label>
                            </td>

                            <td scope="col" v-show="checkedSettings.carbs" class="align-middle">
                        <span v-if="showEdit !== food.id">
                            {{ food.carbohydrates }} g
                        </span>
                                <label>
                                    <input type="text" maxlength="5"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.carbohydrates"
                                           v-bind:id="food.id + '.carbohydrates'"
                                           v-on:input="validateMacro(food.id + '.carbohydrates')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="carbohydrates"
                                    >
                                </label>
                            </td>

                            <td scope="col" v-show="checkedSettings.fat" class="align-middle">
                        <span v-if="showEdit !== food.id">
                            {{ food.fats }} g
                        </span>
                                <label>
                                    <input type="text" maxlength="5"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.fats"
                                           v-bind:id="food.id + '.fats'"
                                           v-on:input="validateMacro(food.id + '.fats')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="fat"
                                    >
                                </label>
                            </td>

                            <td scope="col" v-show="checkedSettings.fiber" class="align-middle">
                        <span v-if="showEdit !== food.id">
                            {{ food.fiber }} g
                        </span>
                                <label>
                                    <input type="text" maxlength="5"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.fiber"
                                           v-bind:id="food.id + '.fiber'"
                                           v-on:input="validateMacro(food.id + '.fiber')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="fiber"
                                    >
                                </label>
                            </td>

                            <td scope="col" v-show="checkedSettings.kcal" class="align-middle">
                        <span v-if="showEdit !== food.id">
                            {{ food.kcal }}
                        </span>
                                <label>
                                    <input type="text" maxlength="4"
                                           class="form-control"
                                           v-if="showEdit === food.id"
                                           v-bind:value="food.kcal"
                                           v-bind:id="food.id + '.kcal'"
                                           v-on:input="validate(food.id + '.kcal')"
                                           v-on:keyup.enter="editAccept(value.mealId, food.id)"
                                           aria-label="calories"
                                    >
                                </label>
                            </td>

                            <td scope="col" class="delete-button-col align-middle" style="width: 10%">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-success m-1"
                                            v-on:click="editAccept(value.mealId, food.id)" v-if="showEdit === food.id">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger m-1" v-on:click="editDecline()"
                                            v-if="showEdit === food.id">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary m-1" v-on:click="editFood(food.id)"
                                            v-if="showEdit !== food.id">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger m-1"
                                            v-on:click="deleteFood(value.mealId, food.id)" v-if="showEdit !== food.id">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="mb-0 pb-0 border-top">
                            <th class="text-uppercase border-0">
                                Total amount this meal:
                            </th>
                            <th class="border-0">{{ calculateMealAmount(value.foods).quantity }} g</th>
                            <th class="border-0" v-show="checkedSettings.protein">{{
                                calculateMealAmount(value.foods).protein }} g
                            </th>
                            <th class="border-0" v-show="checkedSettings.carbs">{{
                                calculateMealAmount(value.foods).carbs }}
                                g
                            </th>
                            <th class="border-0" v-show="checkedSettings.fat">{{ calculateMealAmount(value.foods).fat }}
                                g
                            </th>
                            <th class="border-0" v-show="checkedSettings.fiber">{{
                                calculateMealAmount(value.foods).fiber }}
                                g
                            </th>
                            <th class="border-0" v-if="checkedSettings.kcal">{{ calculateMealAmount(value.foods).kcal }}
                            </th>
                            <th class="border-0"></th>
                        </tr>
                        <tr v-show="!compactMode.includes(value.mealId)">
                            <th colspan="8" class="border-0">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-success m-1"
                                            v-on:click="addFood(value.mealId)">Add
                                        food
                                    </button>
                                    <button type="button" class="btn btn-danger m-1"
                                            v-on:click="deleteMeal(value.mealId)">
                                        Delete meal
                                    </button>
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-primary" v-on:click="createMeal">Create new meal</button>
                    </div>
                    <div class="form-inline d-flex justify-content-end align-items-start" v-on:keyup.enter="importMeal">
                        <div>
                            <input type="text" class="form-control" placeholder="Import meal by id" id="meal-import">
                            <p v-if="invalidMealImportId" class="text-danger pl-2">Invalid meal id</p>
                        </div>
                        <button type="button" class="btn btn-primary" v-on:click="importMeal">Import meal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PieChart from './PieChart.js'

    export default {
        name: "MealPlan",
        components: {
            PieChart
        },
        data() {
            return {
                date: this.formatDate(new Date()),
                meals: [],
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
                dailyAmount: {
                    protein: 0,
                    carbs: 0,
                    fats: 0,
                    fiber: 0,
                    kcal: 0,
                },
                recommendations: {
                    fiber: false,
                    protein: false,
                    fat: false,
                    kcal: false,
                },
                invalidMealImportId: false,
                compactMode: [],
                checkedSettings: {
                    protein: true,
                    carbs: true,
                    fat: true,
                    fiber: true,
                    kcal: true,
                },
                chartOptions: {
                    hoverBorderWidth: 20,
                    tooltips: {
                        callbacks: {
                            label: function (context, obj) {
                                let ind = context.index;
                                return obj.labels[ind] + ': ' + obj.datasets[0].data[ind] + ' kcal';
                            },
                            afterLabel: function (context, obj) {
                                let ind = context.index;
                                return parseFloat(obj.datasets[0].data[ind] / (obj.datasets[0].data[0] + obj.datasets[0].data[1] + obj.datasets[0].data[2]) * 100).toFixed(2) + '%';
                            }
                        }
                    }
                },
                chartData: {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: ["Protein", "Carbs", "Fat"],
                    datasets: [
                        {
                            label: "Nutrition Data",
                            backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
                            data: [0, 0, 0]
                        }
                    ]
                },
            }
        },
        watch: {
            date: function () {
                this.getMealData();
            },
            meals: function () {
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
            createMeal() {
                axios.post('/api/meal/create_meal', {
                    date: this.date
                })
                    .then(() => {
                        this.getMealData();
                    }, (error) => {
                        console.log(error);
                    });
                this.getMealDates();
            },
            deleteMeal(mealId) {
                axios.delete('/api/meal/delete_meal', {
                    data: {
                        mealId
                    }
                })
                    .then(() => {
                        this.getMealData();
                    }, (error) => {
                        console.log(error);
                    });
                this.getMealDates();
            },
            addFood(mealId) {
                axios.post('/api/food/create_food', {
                    mealId
                })
                    .then(() => {
                        this.getMealData();
                    }, (error) => {
                        console.log(error);
                    });
            },
            deleteFood(mealId, foodId) {
                axios.delete('/api/food/delete_food', {
                    data: {
                        mealId,
                        foodId
                    }
                })
                    .then(() => {
                        this.getMealData();
                    }, (error) => {
                        console.log(error);
                    });
            },
            editFood(foodId) {
                this.showEdit = foodId;
            },
            editAccept(mealId, foodId) {
                let validated = true;

                let foodName = document.getElementById(foodId + '.name').value ? document.getElementById(foodId + '.name').value : 'new food';
                let foodQuantity = document.getElementById(foodId + '.quantity').value ? parseInt(document.getElementById(foodId + '.quantity').value) : 0;
                let foodProtein = document.getElementById(foodId + '.protein').value ? parseFloat(document.getElementById(foodId + '.protein').value).toFixed(1) : 0;
                let foodCarbs = document.getElementById(foodId + '.carbohydrates').value ? parseFloat(document.getElementById(foodId + '.carbohydrates').value).toFixed(1) : 0;
                let foodFats = document.getElementById(foodId + '.fats').value ? parseFloat(document.getElementById(foodId + '.fats').value).toFixed(1) : 0;
                let foodFiber = document.getElementById(foodId + '.fiber').value ? parseFloat(document.getElementById(foodId + '.fiber').value).toFixed(1) : 0;
                let foodKcal = document.getElementById(foodId + '.kcal').value ? parseInt(document.getElementById(foodId + '.kcal').value) : 0;

                if (foodName.length > 30) {
                    validated = false;
                }

                if (isNaN(foodQuantity) || isNaN(foodProtein) || isNaN(foodCarbs) || isNaN(foodFats) || isNaN(foodFiber) || isNaN(foodKcal)) {
                    validated = false;
                }

                if (validated) {
                    axios.put('/api/food/edit_food', {
                        mealId,
                        foodId,
                        foodName,
                        foodQuantity,
                        foodProtein,
                        foodCarbs,
                        foodFats,
                        foodFiber,
                        foodKcal
                    }).then((response) => {
                        this.getMealData();
                    }, (error) => {
                        console.log(error);
                    });
                }

                this.showEdit = 0;
            },
            editDecline() {
                this.showEdit = 0;
            },
            getMealDates() {
                axios.get('/api/meal/meal_dates').then((response) => {
                    const attrs = this.attributes.slice();
                    attrs[0].dates = [];
                    response.data.forEach(element => attrs[0].dates.push(element.date));
                    this.attributes = attrs;
                });
            },
            getMealData() {
                this.$isLoading(true);
                axios.get('/api/meal/meals', {
                    params: {
                        date: this.date
                    }
                }).then((response) => {
                    this.$isLoading(false);
                    this.meals = response.data
                }, (error) => {
                    this.$isLoading(false);
                });
            },
            calculateDailyAmount() {
                this.dailyAmount = {
                    protein: 0,
                    carbs: 0,
                    fats: 0,
                    fiber: 0,
                    kcal: 0,
                };
                this.meals.forEach(element => element.foods.forEach(e => {
                        this.dailyAmount.protein += parseFloat(e.protein);
                        this.dailyAmount.carbs += parseFloat(e.carbohydrates);
                        this.dailyAmount.fats += parseFloat(e.fats);
                        this.dailyAmount.fiber += parseFloat(e.fiber);
                        this.dailyAmount.kcal += parseFloat(e.kcal);
                    }
                ));
                this.updateRecommendations();
                this.updateChart();
            },
            updateChart() {
                this.chartData.datasets[0].data[0] = this.dailyAmount.protein * 4;
                this.chartData.datasets[0].data[1] = this.dailyAmount.carbs * 4;
                this.chartData.datasets[0].data[2] = this.dailyAmount.fats * 9;
            },
            updateRecommendations() {
                if (this.checkedSettings.fiber) {
                    this.recommendations.fiber = this.dailyAmount.fiber < 25;
                }
                if (this.checkedSettings.protein && this.checkedSettings.kcal) {
                    this.recommendations.protein = this.dailyAmount.protein * 4 < this.dailyAmount.kcal * 0.2 || this.dailyAmount.protein < 50;
                }
                if (this.checkedSettings.protein && !this.checkedSettings.kcal) {
                    this.recommendations.protein = this.dailyAmount.protein < 50;
                }
                if (this.checkedSettings.fat && this.checkedSettings.kcal) {
                    this.recommendations.fat = this.dailyAmount.fats * 9 < this.dailyAmount.kcal * 0.2 || this.dailyAmount.fats < 40;
                }
                if (this.checkedSettings.fat && !this.checkedSettings.kcal) {
                    this.recommendations.fat = this.dailyAmount.fats < 40;
                }
                if (this.checkedSettings.protein && this.checkedSettings.carbs && this.checkedSettings.fat && this.checkedSettings.kcal) {
                    this.recommendations.kcal = this.dailyAmount.fats * 9 + this.dailyAmount.protein * 4 + this.dailyAmount.carbs * 4 > this.dailyAmount.kcal * 1.1 ||
                        this.dailyAmount.fats * 9 + this.dailyAmount.protein * 4 + this.dailyAmount.carbs * 4 < this.dailyAmount.kcal * 0.9;
                }
            },
            validate(id) {
                if (document.getElementById(id).value.includes(",")) {
                    document.getElementById(id).value = document.getElementById(id).value.replace(",", ".");
                }
                if (isNaN(document.getElementById(id).value) || /[a-z]/i.test(document.getElementById(id).value)) {
                    document.getElementById(id).style.color = "red";
                } else {
                    document.getElementById(id).style.color = null;
                }
            },
            validateMacro(id) {
                if (document.getElementById(id).value.includes(",")) {
                    document.getElementById(id).value = document.getElementById(id).value.replace(",", ".");
                }
                if (document.getElementById(id).value >= 1000) {
                    while (document.getElementById(id).value >= 1000) {
                        document.getElementById(id).value = document.getElementById(id).value / 10;
                    }
                }
                if (isNaN(document.getElementById(id).value) || /[a-z]/i.test(document.getElementById(id).value)) {
                    document.getElementById(id).style.color = "red";
                } else {
                    document.getElementById(id).style.color = null;
                }
            },
            calculateMealAmount(foods) {
                let quantity = 0;
                let protein = 0;
                let carbs = 0;
                let fat = 0;
                let fiber = 0;
                let kcal = 0;
                foods.forEach(e => {
                    quantity += parseInt(e.quantity);
                    protein += parseFloat(e.protein);
                    carbs += parseFloat(e.carbohydrates);
                    fat += parseFloat(e.fats);
                    fiber += parseFloat(e.fiber);
                    kcal += parseInt(e.kcal);
                });
                return {
                    quantity: parseInt(quantity),
                    protein: parseFloat(protein).toFixed(1),
                    carbs: parseFloat(carbs).toFixed(1),
                    fat: parseFloat(fat).toFixed(1),
                    fiber: parseFloat(fiber).toFixed(1),
                    kcal: parseInt(kcal)
                };
            },
            importMeal() {
                let mealId = document.getElementById('meal-import').value;

                if(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i.test(mealId)){
                    this.$isLoading(true);
                    axios.post('/api/meal/import_meal', {
                        date: this.date,
                        mealId
                    }).then((response) => {
                        this.$isLoading(false);
                        this.invalidMealImportId = response.status === 201;
                        this.getMealData();
                    }, (error) => {
                        this.$isLoading(false);
                        this.invalidMealImportId = true;
                    });
                } else {
                    this.invalidMealImportId = true;
                }

                document.getElementById('meal-import').value = '';
            },
            showElement(el) {
                this.compactMode = this.compactMode.filter(item => item !== el);
            },
            getUserSettings() {
                this.$isLoading(true);
                axios.get('/api/user/get_user_settings').then((response) => {
                    this.$isLoading(false);
                    this.checkedSettings = response.data;
                }).catch(function (error) {
                    this.$isLoading(false);
                });
            },
        },
        mounted() {
            this.getUserSettings();
            this.getMealData();
            this.getMealDates();
        },
    }
</script>

<style scoped>
    .delete-button-col {
        width: 5%;
        padding-top: 2px;
        padding-bottom: 2px
    }

    .info-container {
        max-width: 255px;
        margin: auto;
        margin-top: 0;
    }

    .mp-col-wide {
        min-width: 200px;
        width: 30%
    }

    .mp-col-narrow {
        min-width: 70px;
        width: 10%
    }

    label {
        margin-bottom: 0;
    }
</style>