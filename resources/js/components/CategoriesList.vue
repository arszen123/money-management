<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories income</div>

                <div class="card-body">
                    <category-list :on-click="selectCategory" :categoryId="categoryId" :categories="incomeCategories"/>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Categories expense</div>

                <div class="card-body">
                    <category-list :on-click="selectCategory" :categoryId="categoryId" :categories="expenseCategories"/>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">
                    <category-form :category-id="categoryId" @save="onSave()" @delete="onDelete()"/>
                </div>
            </div>
            <notifications group="notification" />
        </div>
    </div>
</template>

<script>
    import CategoryList from "./CategoryList";
    import CategoryForm from "./CategoryForm";
    import axios from 'axios';

    export default {
        name: "CategoriesList",
        components: {CategoryList, CategoryForm},
        props: ['categories'],
        data: () => ({
            categoryId: null,
            expenseCategories: [],
            incomeCategories: []
        }),
        beforeMount() {
            this.initCategories(this.categories)
        },
        methods: {
            selectCategory(categoryId) {
                if (this.categoryId !== categoryId) {
                    this.categoryId = categoryId
                } else {
                    this.categoryId = null
                }
                return this.categoryId
            },
            onSave () {
                axios.get('/category').then(value => {
                    this.initCategories(value.data.categories)
                })
            },
            onDelete () {
                this.categoryId = null
                this.onSave()
            },
            initCategories (categories) {
                let tempExpenseCategories = []
                let tempIncomeCategories = []
                for (let categoryId in categories) {
                    let category = categories[categoryId]
                    if (category.type === 1) {
                        tempIncomeCategories.push(category)
                    } else {
                        tempExpenseCategories.push(category)
                    }
                }
                this.expenseCategories = tempExpenseCategories
                this.incomeCategories = tempIncomeCategories
            }
        }
    }
</script>

<style scoped>

</style>