<template>
    <form v-on:submit.prevent="saveBudget" >
        <div class="form-group">
            <label for="budget-name">Budget name:</label>
            <input id="budget-name" name="name" class="form-control" v-model="budget.name">
            <div v-if="errors.name !== null" class="invalid-feedback">{{ errors.name }}</div>
        </div>
        <div class="form-group">
            <label for="budget-from">Date from:</label>
            <input id="budget-from" name="from" type="date" class="form-control" v-model="budget.from">
            <div v-if="errors.from !== null" class="invalid-feedback">{{ errors.from }}</div>
        </div>
        <div class="form-group">
            <label for="budget-to">Date to:</label>
            <input id="budget-to" name="to" type="date" class="form-control" v-model="budget.to">
            <div v-if="errors.to !== null" class="invalid-feedback">{{ errors.to }}</div>
        </div>
        <div class="form-group">
            <label for="budget-starting-balance">Balance:</label>
            <input id="budget-starting-balance" name="starting_balance" type="number" class="form-control" v-model="budget.starting_balance">
            <div v-if="errors.starting_balance !== null" class="invalid-feedback">{{ errors.starting_balance }}</div>
        </div>
        <div class="form-group">
            <label>Categories:</label>
            <div class="form-check" v-for="category in categories">
                <input class="form-check-input" :id="'budget-category-'+(category.id)" :value="category.id" name="categories" type="checkbox" v-model="budget.categories">
                <label class="form-check-label" :for="'budget-category-'+(category.id)">{{ category.name }}</label>
            </div>
        </div>
        <div>
            <input type="submit" class="btn btn-primary"/>
        </div>
    </form>
</template>

<script>
    import Carbon from '../helpers/Carbon'
    import axios from 'axios'

    export default {
        name: "BudgetForm",
        props: ['categoryId'],
        data: () => ({
            budget: {
                name: '',
                from: null,
                to: null,
                starting_balance: null,
                categories: []
            },
            errors: {
                name: null,
                from: null,
                to: null,
                starting_balance: null,
                categories: null,
            },
            categories: []
        }),
        created() {
            if (this.categoryId) {
                this.getBudget(this.categoryId)
            } else {
                this.budget.from = Carbon.now().addMonths(1).format();
                this.budget.to = Carbon.now().addMonths(2).format();
            }
            this.getCategories()
        },
        methods: {
            saveBudget() {
                let result = null
                if (this.categoryId !== null) {
                    result = axios.put(`/budget/${this.categoryId}`, this.budget)
                } else {
                    result = axios.post('/budget', this.budget)
                }
                result.then(() => {
                    this.$parent.goTo('root')
                    this.$notify({
                        group: 'notification',
                        title: 'Saved!',
                        text: 'Budget saved successfully!',
                        type: 'success'
                    });
                }).catch(reason => {
                    let errors = reason.response.data.errors
                    this.errors = {
                        name: null,
                        from: null,
                        to: null,
                        starting_balance: null,
                        categories: null,
                    };
                    for (let error in errors) {
                        this.errors[error] = errors[error][0];
                    }
                })
            },
            getBudget(id) {
                axios.get(`/budget/${id}`).then(value => {
                    this.budget = value.data.budget
                })
            },
            getCategories()
            {
                axios.get('/category?type=2').then(value => {
                    this.categories = value.data.categories;
                })
            }
        }
    }
</script>

<style scoped>
    .invalid-feedback {
        display: inherit;
    }
</style>