<template>
    <div class="absolute d-flex align-items-center flex-column">
        <h1>404 | Page not found!</h1>
        <button type="button" class="btn btn-primary btn-lg mt-5" @click="$router.push('/')">Go back home</button>
    </div>
</template>

<script>
    export default {
        name: "PageNotFound"
    }
</script>

<style scoped>

</style>