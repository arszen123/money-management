<template>
    <div>
        <a v-on:click.prevent="goTo('root')">/</a>
        <a v-on:click.prevent="goTo('form')">/create</a>
        <component :is="selectedComp"></component>
        <router-link :to="{name:'list'}">List</router-link>
        <router-link :to="{name:'create'}">Form</router-link>
        <router-view></router-view>
    </div>
</template>

<script>
    import BudgetsList from './BudgetsList'
    import BudgetForm from './BudgetForm'
    export default {
        name: "BudgetsView",
        data: () => ({
            routes: [{
                name: 'root',
                component: BudgetsList
            },{
                name: 'form',
                component: BudgetForm
            }],
            selectedComp: null
        }),
        created() {
            this.goTo('root')
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