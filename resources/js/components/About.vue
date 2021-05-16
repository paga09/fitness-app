<template>
    <div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card text-white bg-dark mb-3">
                    <h3 class="card-header">About the project</h3>
                    <div class="card-body border-top">
                        <p class="card-text">
                            The goal of this project is to create a customizable, but still easy to use application to
                            track
                            your food intake and your workouts. The target audience is every level of gym visitor, who
                            has some
                            general idea about how they want to approach their journey. It's not in our intention to
                            give out
                            complete workout and nutrition plans, for that we recommend contacting personal trainers and
                            dietitians. However the app may make some recommendations, based on the information you
                            provide.
                        </p>
                        <p class="card-text line-height-normal">
                            <small>
                                pictures: <br>
                                <a href="https://www.pexels.com/photo/close-up-of-a-person-s-lower-body-holding-barbell-949134/?utm_content=attributionCopyText&utm_medium=referral&utm_source=pexels"
                                   target="_blank">Photo by Victor Freitas from Pexels</a> <br>
                                <a href="https://www.pexels.com/photo/bowl-of-vegetable-salad-and-fruits-936611/?utm_content=attributionCopyText&utm_medium=referral&utm_source=pexels"
                                   target="_blank">Photo by Jane D. from Pexels</a>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div id="accordion" class="mb-5">
                    <div class="card bg-dark text-white">
                        <div class="card-header" id="headingMealPlan">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-white" data-toggle="collapse"
                                        data-target="#collapseMealPlan"
                                        aria-expanded="true" aria-controls="collapseMealPlan">
                                    About Meal Plans
                                </button>
                            </h5>
                        </div>

                        <div id="collapseMealPlan" class="collapse" aria-labelledby="headingMealPlan"
                             data-parent="#accordion">
                            <div class="card-body border-top">
                                <h5 class="card-title">Creating meal plans</h5>
                                <p class="card-text">When it comes to logging food intake, everyone considers different
                                    values
                                    important. This part of the app is highly customizable, whether you want to track
                                    calories,
                                    macronutrients or both, you will be able to set your preferences.
                                </p>
                                <h5 class="card-title">Macronutrient ratio</h5>
                                <p class="card-text">If you decided to provide all the macronutrients (proteins,
                                    carbohydrates,
                                    fats), we can calculate their ratio for you based on their energy value (1 g of fats
                                    contains
                                    9 kcal; 1 g of proteins contains 4 kcal and 1 g of carbohydrates contains 4 kcal).
                                </p>
                                <h5 class="card-title">Recommendations</h5>
                                <p class="card-text">
                                    As each person's needs are individual, our recommendations are very general, don't
                                    take them
                                    as nutritional advice. For a plan that fits your needs consult a dietitian. <br>
                                    The app make the following recommendations:
                                </p>
                                <ul>
                                    <li>
                                        At least 25 grams of fiber
                                    </li>
                                    <li>
                                        At least 50 grams of protein and at least 20% of your calories from protein
                                    </li>
                                    <li>
                                        At least 40 grams of fat and at least 20% of your calories from fat
                                    </li>
                                    <li>
                                        If all the macronutrients and the kcal display is set, calories calculated from
                                        the
                                        macros should not differ too much from the calories typed in by the user
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark text-white border-top">
                        <div class="card-header" id="headingWorkoutPlan">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed text-white" data-toggle="collapse"
                                        data-target="#collapseWorkoutPlan"
                                        aria-expanded="false" aria-controls="collapseWorkoutPlan">
                                    About Workout plans
                                </button>
                            </h5>
                        </div>
                        <div id="collapseWorkoutPlan" class="collapse" aria-labelledby="headingWorkoutPlan"
                             data-parent="#accordion">
                            <div class="card-body border-top">
                                <h5 class="card-title">Creating workout plans</h5>
                                <p class="card-text">This part of the app is mainly aimed towards gym workouts. You can
                                    log the
                                    exercise name, workout sets, repetitions and the weight used. You can also create
                                    multiple
                                    workouts per day. The goal here is to be able to monitor your progress.</p>
                                <h5 class="card-title">Calculated one repetition max (1RM)</h5>
                                <p class="card-text">For each working sets between repetition ranges 2-12, we can
                                    estimate the
                                    maximum weight you could potentially lift. Disregard this information if you didn't
                                    go all
                                    out on given exercise.</p>
                                <h5 class="card-title">Total daily volume</h5>
                                <p class="card-text">Volume is a measurement of the total weight lifted, you get this by
                                    using
                                    the following equation: sets x reps x weight. Then you add this up for every
                                    exercise
                                    performed on given day to get the total daily volume.</p>
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
        name: "About",
    }
</script>

<style scoped>
    .line-height-normal {
        line-height: normal;
    }
</style>