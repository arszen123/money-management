<template>
    <div>
        <a v-on:click.prevent="goTo('root')">/</a>
        <a v-on:click.prevent="goTo('form')">/create</a>
        <component :is="selectedComp"></component>
        <router-link :to="{name:'list3'}">List</router-link>
        <router-link :to="{name:'create3'}">Form</router-link>
        <router-view name="a"></router-view>
    </div>
</template>

<script>
    import SavingForm from './SavingForm'
    import SavingsList from './SavingsList'
    export default {
        name: "SavingView",
        data: () => ({
            routes: [{
                name: 'root',
                component: SavingsList
            },{
                name: 'form',
                component: SavingForm
            }],
            selectedComp: null
        }),
        created() {
            this.goTo('root')
            console.log(this.$componentRouter)
        },
        methods: {
            goTo(name) {
                for(let i in this.routes) {
                    if (this.routes[i].name === name) {
                        this.selectedComp = this.routes[i].component
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>