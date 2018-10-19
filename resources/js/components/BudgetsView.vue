<template>
    <div>
        <a v-on:click.prevent="goTo('root')">/</a>
        <a v-on:click.prevent="goTo('form')">/create</a>
        <a v-on:click.prevent="goToView('test1.list3')">/test1</a>
        <a v-on:click.prevent="goToView('test1.create3')">/test1/create</a>
        <a v-on:click.prevent="goToView('test2.list3')">/test2</a>
        <a v-on:click.prevent="goToView('test2.create3')">/test2/create</a>
        <component :is="selectedComp"></component>
        <router-link :to="{name:'list'}">List</router-link>
        <router-link :to="{name:'create'}">Form</router-link>
        <component-router-view name="test2"/>
        <component-router-view name="test1"/>
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
            this.$componentRouter.go('test2.list3');
            this.$componentRouter.go('test1.create3');
            this.$componentRouter.go('test1.list3');
            this.$componentRouter.go('test2.list3');
            this.$componentRouter.go('test2.create3');
        },
        mounted () {
            this.$componentRouter.go('test2.list3');
        },
        methods: {
            goToView(name) {
                console.log(name);
                this.$componentRouter.go(name);
            },
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