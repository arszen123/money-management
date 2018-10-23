<template>
    <div>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div>
            <ul class="navbar-nav">
                <li v-for="route in routes" :key="route.name" :class="'nav-item '+(route.name == selectedComponent.name ? 'active' : '')" >
                    <a v-on:click.prevent="goTo(route.name)" class="nav-link">{{route.linkText}}</a>
                </li>
            </ul>
        </div>
    </nav>
        <div class="card-body">
            <component :is="selectedComponent.component" :categoryId="categoryId"/>
        </div>
    </div>
</template>

<script>
    import BudgetsList from './BudgetsList'
    import BudgetForm from './BudgetForm'
    export default {
        name: "BudgetsView",
        props: ['budgets'],
        data: () => ({
            routes: [{
                name: 'root',
                component: BudgetsList,
                linkText: 'List'
            },{
                name: 'form',
                component: BudgetForm,
                linkText: 'Edit/Create'
            }],
            selectedComponent: {
                name: '',
                component: null
            },
            categoryId: null
        }),
        created() {
            this.goTo('root')
        },
        methods: {
            goTo(name) {
                console.log(name);
                for(let i in this.routes) {
                    if (this.routes[i].name === name) {
                        this.selectedComponent = this.routes[i]
                        console.log(this.selectedComponent)
                    }
                }
            },
            selectCategory(categoryId) {
                if (this.categoryId === categoryId) {
                    this.categoryId = null
                } else {
                    this.categoryId = categoryId
                }
                return this.categoryId
            }
        }
    }
</script>

<style scoped>
    .navbar-nav li{
        cursor: pointer;
    }
    .navbar-nav{
        cursor: pointer;
    }
</style>