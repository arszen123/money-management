<template>
    <div id="main">
        <a @click="sendToRoot"><button class="btn btn-outline-primary">All transaction</button></a>
        <div class="form-group">
            <label for="tag">Tag:</label>
            <input id="tag" type="text" name="tag" class="form-control" v-model="tag" @keypress.enter="selectedTag">
        </div>
        <div class="form-group">
        <div>
            <label for="category" >Category</label>
            <select id="category" v-model="selectedCategory" class="custom-select custom-select-md">
                <option :value="null" ></option>
                <optgroup label="Income">
                    <option v-for="category in categories.income" :key="category.id" :value="category.id" >{{ category.name }}</option>
                </optgroup>
                <optgroup label="Expense">
                    <option v-for="category in categories.expense" :key="category.id" :value="category.id" >{{ category.name }}</option>
                </optgroup>
            </select>
        </div>
        </div>
        <div class="form-group">
        <label for="budget">Budget:</label>
        <select id="budget" v-model="selectedBudget" class="custom-select custom-select-md">
            <option :value="null" ></option>
            <option v-for="budget in budgets" :key="budget.id" :value="budget.id" >{{ budget.name }}</option>
        </select>
        </div>
        <div class="form-group">
            <label for="from">From:</label>
            <input id="from" type="date" v-model="date.from" class="custom-select custom-select-md">
            <label for="to">To:</label>
            <input id="to" type="date" v-model="date.to" class="custom-select custom-select-md" />
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import DatePicker from "vue-bootstrap-datetimepicker/src/component";
    // import DatePicker from "vue-bootstrap-datetimepicker/src/component";
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import 'bootstrap/dist/css/bootstrap.css';
    export default {
        name: "TransactionLinks",
        components: {DatePicker},
        data: () => ({
            categories: {
                income: null,
                expense: null,
            },
            selectedCategory: null,
            budgets: null,
            selectedBudget: null,
            tag: '',
            date: {
                from: null,
                to: null
            }
        }),
        created() {
            this.fetchCategories()
            this.fetchBudgets()
            this.fetchRoute(this.$route.params);
        },
        methods: {
            fetchCategories() {
                axios.get('/category?type=1').then(value => {
                    this.categories.income = value.data.categories;
                })
                axios.get('/category?type=2').then(value => {
                    this.categories.expense = value.data.categories;
                })
            },
            fetchBudgets() {
                axios.get('/budget').then(value => {
                    this.budgets = value.data.data;
                })
            },
            selectedTag() {
                if (this.tag !== '') {
                    this.$router.push('/tag/' + this.tag + '?' + this.getDateParams())
                    this.selectedBudget = null;
                    this.selectedCategory = null;
                }
            },
            sendToRoot(send)
            {
                if (send !== true) {
                    this.$router.push('/' + '?' + this.getDateParams());
                }
                this.selectedCategory = null;
                this.selectedBudget = null;
                this.tag = '';
            },
            fetchRoute(params)
            {
                if (typeof params.resource === 'undefined') {
                    this.sendToRoot(true)
                }
                if (params.resource === 'category') {
                    this.selectedCategory = params.id;
                }
                if (params.resource === 'budget') {
                    this.selectedBudget = params.id;
                }
                if (params.resource === 'tag') {
                    this.tag = params.id;
                }
            },
            getDateParams()
            {
                return (!this.date.from ?'':`from=${this.date.from}`) + (!this.date.to?'':`&to=${this.date.to}`);
            }
        },
        watch: {
            selectedCategory() {
                if (this.selectedCategory !== null) {
                    this.$router.push('/category/' + this.selectedCategory + '?' + this.getDateParams())
                    this.selectedBudget = null;
                    this.tag = '';
                }
            },
            selectedBudget() {
                if (this.selectedBudget !== null) {
                    this.$router.push('/budget/' + this.selectedBudget + '?' + this.getDateParams())
                    this.selectedCategory = null;
                    this.tag = '';
                }
            },
            'date.from': function (){
                this.$router.push(this.$route.path + '?' + this.getDateParams());
            },
            'date.to': function (){
                this.$router.push(this.$route.path + '?' + this.getDateParams());
            },
            '$route.params': function (params) {
                this.fetchRoute(params)
            },
        }
    }
</script>

<style scoped>
    /*.justify-content-center {*/
        /*margin-bottom: 1%;*/
    /*}*/
    #main {
        text-align: center;
    }
</style>