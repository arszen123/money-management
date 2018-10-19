<template>
    <div>
        <a v-on:click.prevent="log">Hello world!</a>
    </div>
</template>

<script>
    export default {
        name: "SavingForm",
        methods: {
            log () {
                console.log({cR: this.$componentRoute, cRr: this.$componentRouter});
            }
        }
    }
</script>

<style scoped>

</style>