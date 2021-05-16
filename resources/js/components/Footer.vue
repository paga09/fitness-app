<template>
    <footer class="bg-dark text-white d-flex justify-content-center align-items-center">
        <div>
            &copy {{ currentYear }}
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        data () {
            return {
                currentYear: new Date().getFullYear(),
            }
        }
    }
</script>

<style scoped>
    footer {
        position: absolute;
        height: 2.5rem;
        bottom: 0;
        width: 100%;
    }
</style>