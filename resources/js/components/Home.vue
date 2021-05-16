<template>
    <div>
        <div class="d-flex d-sm-none justify-content-center mb-5 in-down" v-if="!$store.state.authorized">
            <button type="button" class="btn btn-warning btn-lg" @click="$router.push('register')">Sign up now</button>
        </div>
        <div class="d-flex flex-column flex-sm-row mb-3 mb-md-5">
            <div class="col-sm-6 in-left mb-2">
                <img :src="'../storage/img/nutrition.jpg'" alt="nutrition" class="img-fluid" @load="onImgLoad">
            </div>
            <div class="col-sm-6 in-right m-auto">
                <h3>Track your nutrition</h3>
                <p>
                    Tracking your food intake will give you insight into many aspects of your eating habits. The more
                    specific and accurate you are with reporting, the more accurate your information will be. Whether
                    your goal is to lose fat or gain muscle, this information is crucial to make progress.
                </p>
            </div>
        </div>

        <div class="d-none d-sm-flex justify-content-center mb-3 mb-md-5 in-down"
             v-if="!$store.state.authorized && imgLoaded">
            <button type="button" class="btn btn-warning btn-lg" @click="$router.push('register')">Sign up now</button>
        </div>

        <div class="d-flex flex-column flex-sm-row-reverse">
            <div class="col-sm-6 in-right mb-2">
                <img :src="'../storage/img/workout.jpg'" alt="workout" class="img-fluid">
            </div>
            <div class="col-sm-6 in-left m-auto">
                <h3>Track your workouts</h3>
                <p>
                    Muscle growth is an adaptation to stress. Therefore, if you fail to provide greater stress than
                    before, your body is not gonna adapt. When it comes to making constant, steady gains, the name of
                    the game is progressive overload. Basically, you have to train harder than last time. The easiest
                    way to achieve that is logging your workouts.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                imgLoaded: false,
            }
        },
        methods: {
            onImgLoad() {
                this.imgLoaded = true;
            }
        }
    }
</script>

<style scoped>

    @-webkit-keyframes fadeInDown {
        from {
            opacity: 0;
            -webkit-transform: translatey(-100px);
            -moz-transform: translatey(-100px);
            -o-transform: translatey(-100px);
            transform: translatey(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatey(0);
            -moz-transform: translatey(0);
            -o-transform: translatey(0);
            transform: translatey(0);
        }
    }

    @-moz-keyframes fadeInDown {
        from {
            opacity: 0;
            -webkit-transform: translatey(-100px);
            -moz-transform: translatey(-100px);
            -o-transform: translatey(-100px);
            transform: translatey(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatey(0);
            -moz-transform: translatey(0);
            -o-transform: translatey(0);
            transform: translatey(0);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            -webkit-transform: translatey(-100px);
            -moz-transform: translatey(-100px);
            -o-transform: translatey(-100px);
            transform: translatey(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatey(0);
            -moz-transform: translatey(0);
            -o-transform: translatey(0);
            transform: translatey(0);
        }
    }

    .in-down {
        -webkit-animation-name: fadeInDown;
        -moz-animation-name: fadeInDown;
        -o-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-fill-mode: both;
        -moz-animation-fill-mode: both;
        -o-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        -o-animation-duration: 1s;
        animation-duration: 1s;
    }

    @-webkit-keyframes fadeInLeft {
        from {
            opacity: 0;
            -webkit-transform: translatex(-100px);
            -moz-transform: translatex(-100px);
            -o-transform: translatex(-100px);
            transform: translatex(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    @-moz-keyframes fadeInLeft {
        from {
            opacity: 0;
            -webkit-transform: translatex(-100px);
            -moz-transform: translatex(-100px);
            -o-transform: translatex(-100px);
            transform: translatex(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            -webkit-transform: translatex(-100px);
            -moz-transform: translatex(-100px);
            -o-transform: translatex(-100px);
            transform: translatex(-100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    .in-left {
        -webkit-animation-name: fadeInLeft;
        -moz-animation-name: fadeInLeft;
        -o-animation-name: fadeInLeft;
        animation-name: fadeInLeft;
        -webkit-animation-fill-mode: both;
        -moz-animation-fill-mode: both;
        -o-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        -o-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-delay: 1s;
        -moz-animation-delay: 1s;
        -o-animation-duration: 1s;
        animation-delay: 1s;
    }

    @-webkit-keyframes fadeInRight {
        from {
            opacity: 0;
            -webkit-transform: translatex(100px);
            -moz-transform: translatex(100px);
            -o-transform: translatex(100px);
            transform: translatex(100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    @-moz-keyframes fadeInRight {
        from {
            opacity: 0;
            -webkit-transform: translatex(100px);
            -moz-transform: translatex(100px);
            -o-transform: translatex(100px);
            transform: translatex(100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            -webkit-transform: translatex(100px);
            -moz-transform: translatex(100px);
            -o-transform: translatex(100px);
            transform: translatex(100px);
        }
        to {
            opacity: 1;
            -webkit-transform: translatex(0);
            -moz-transform: translatex(0);
            -o-transform: translatex(0);
            transform: translatex(0);
        }
    }

    .in-right {
        -webkit-animation-name: fadeInRight;
        -moz-animation-name: fadeInRight;
        -o-animation-name: fadeInRight;
        animation-name: fadeInRight;
        -webkit-animation-fill-mode: both;
        -moz-animation-fill-mode: both;
        -o-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        -o-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-delay: 1s;
        -moz-animation-delay: 1s;
        -o-animation-duration: 1s;
        animation-delay: 1s;
    }


</style>