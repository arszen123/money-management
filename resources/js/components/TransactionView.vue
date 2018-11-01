<template>
    <div class="card">
        <div class="card-header">{{ title }}</div>

        <ul class="list-group">
            <template v-if="transactions" >
                <div v-for="transaction in transactions" @click="selectedTransaction = (selectedTransaction.id === transaction.id ? {id: null} : transaction)" :key="transaction.id" :class="'list-group-item list-group-item-action flex-column align-items-start ' + (selectedTransaction.id === transaction.id ? 'active':'')">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Category: {{ transaction.categoryName }}</h5>
                        <small>Created: {{ transaction.created_at }}</small>
                    </div>
                    <p class="mb-1">Amount: {{ transaction.amount }}</p>
                    <p class="mb-1">Tag: {{ transaction.tag }}</p>
                    <p class="mb-1">Comment: {{ transaction.comment }}</p>
                </div>
            </template>
            <template v-else>
                    No Transactions yet.
            </template>
        </ul>
        <transaction-form :transaction-to-edit="selectedTransaction"/>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "TransactionView",
        data: ()=> ({
            transactions: null,
            title: 'Transactions',
            url: null,
            selectedTransaction: {
                id: null
            }
        }),
        created(){
            this.load()
        },
        methods: {
            load() {
                let tmpUrl = this.url
                this.setUrl()
                if (tmpUrl !== this.url) {
                    this.fetchTransactions();
                }
            },
            setUrl() {
                let urlPrefix = '/transaction'
                let queryParams = this.$route.query;
                let params = []
                for (let param in queryParams) {
                    params.push(param + '=' + queryParams[param]);
                }
                this.url = urlPrefix + this.$route.path + '?' + params.join('&')
            },
            fetchTransactions() {
                axios.get(this.url).then(value => {
                    this.transactions = value.data.transactions
                    this.title = value.data.title
                })
            }
        },
        watch: {
            '$route.path': function () {
                this.load();
            },
            '$route.query': function () {
                this.load();
            }
        }
    }
</script>

<style scoped>

</style>