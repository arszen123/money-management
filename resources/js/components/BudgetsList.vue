<template>
    <ul class="list-group">
        <li v-for="budget in budgets" :class="'list-group-item '+(categoryId === budget.id ? 'active' : '')" v-on:click.prevent="select(budget.id)">{{ budget.name }}</li>
    </ul>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "BudgetsList",
        props: ['categoryId'],
        data: () => ({
            budgets: []
        }),
        created() {
            if (typeof this.$parent.budgets !== 'undefined') {
                this.budgets = this.$parent.budgets;
            } else {
                this.fetchBudgets()
            }
        },
        methods: {
            fetchBudgets() {
                axios.get('/budget').then(value => {
                    let budgets = value.data.data;
                    for (let index in budgets) {
                        this.budgets.push(budgets[index]);
                    }
                })
            },
            select(id) {
                this.$parent.selectCategory(id);
            }
        }
    }
</script>

<style scoped>
.list-group {
    cursor: pointer;
}
</style>