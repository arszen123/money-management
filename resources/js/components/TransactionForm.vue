<template>
    <div>
        <modal  v-if="showModal" @close="showModal = !showModal">
            <h5 slot="header">Create transaction</h5>
            <form slot="body">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input id="amount" type="text" name="amount" class="form-control" v-model="transaction.amount">
                    <div v-if="errors.amount !== null" class="invalid-feedback">{{ errors.amount }}</div>
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" v-model="transaction.comment"></textarea>
                    <div v-if="errors.comment !== null" class="invalid-feedback">{{ errors.comment }}</div>
                </div>
                <div class="form-group">
                    <label for="tag">Tag (separate with ",")</label>
                    <input id="tag" name="tag" class="form-control" v-model="transaction.tag">
                    <div v-if="errors.tag !== null" class="invalid-feedback">{{ errors.tag }}</div>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control" v-model="transaction.type" v-on:change="fetchCategories(transaction.type)">
                        <option value="1">Income</option>
                        <option value="2">Expense</option>
                    </select>
                    <div v-if="errors.type !== null" class="invalid-feedback">{{ errors.type }}</div>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control" v-model="transaction.category">
                        <option v-for="category in categories[transaction.type]" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <div v-if="errors.category !== null" class="invalid-feedback">{{ errors.category }}</div>
                </div>
                <div class="form-group">
                    <label for="date-created">Date</label>
                    <input id="date-created" name="date-created" class="form-control" type="date" v-model="transaction.date">
                    <div v-if="errors.date !== null" class="invalid-feedback">{{ errors.date }}</div>
                </div>
            </form>
            <div slot="footer" class="form-footer">
                <button class="btn btn-outline-success" style="left: 0;" v-on:click="saveTransaction">Create transaction</button>
                <button class="btn btn-outline-danger" v-on:click="deleteTransaction">Delete</button>
                <button class="btn btn-outline-danger" v-on:click="showModal = !showModal">Cancel</button>
            </div>
        </modal>
        <button id="fab" type="button" class="btn btn-success bmd-btn-fab" v-on:click="showModal = !showModal">
            <i class="material-icons">add</i>
        </button>
    </div>
</template>

<script>
    import Modal from "./common/Modal";
    import axios from 'axios';
    import Carbon from '../helpers/Carbon';
    // import DatePicker from "vue-bootstrap-datetimepicker/src/component";
    // import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    // import 'bootstrap/dist/css/bootstrap.css';


    export default {
        name: "TransactionForm",
        props: ['transactionToEdit'],
        components: {Modal},
        data: () => ({
            showModal: false,
            categories: {
                1: [],
                2: [],
            },
            transaction: {
                amount: 0,
                comment: '',
                type: 1,
                category: null,
                date: null,
                tag: null
            },
            errors: {
                amount: null,
                comment: null,
                type: null,
                category: null,
                date: null,
                tag: null
            }
        }),
        created() {
            this.fetchCategories(1)
            this.fetchCategories(2)
        },
        methods: {
            fetchCategories(type) {
                axios.get(`/category?type=${type}`).then(value => {
                    this.categories[type] = value.data.categories;
                })
            },
            saveTransaction() {
                let request = null;
                if (this.transactionToEdit.id == null) {
                    request = axios.post('/transaction', this.transaction)
                } else {
                    request = axios.put(`/transaction/${this.transactionToEdit.id}`, this.transaction)
                }
                request.then(value => {
                    if (value.data.success) {
                        this.showModal = !this.showModal
                        this.$notify({
                            group: 'notification',
                            title: 'Saved!',
                            text: 'Transaction saved successfully!',
                            type: 'success'
                        });
                    }
                }).catch(reason => {
                    this.errors = {
                        amount: null,
                            comment: null,
                            type: null,
                            category: null,
                            date: null,
                    };
                    let errors = reason.response.data.errors;
                    for (let error in errors) {
                        this.errors[error] = errors[error][0];
                    }
                })
            },
            deleteTransaction() {
                axios.delete(`/transaction/${this.transactionToEdit.id}`)
                .then(value => {
                    if (value.data.success) {
                        this.showModal = !this.showModal;
                        this.$notify({
                            group: 'notification',
                            title: 'Deleted!',
                            text: 'Transaction deleted successfully!',
                            type: 'success'
                        });
                    }
                }).catch(reason => {
                    this.showModal = !this.showModal;
                    this.$notify({
                        group: 'notification',
                        title: 'Failed!',
                        text: 'Transaction deletions failed!',
                        type: 'error'
                    });
                })
            }
        },
        watch: {
            transactionToEdit() {
                if (this.transactionToEdit.id !== null) {
                    this.transaction.amount = this.transactionToEdit.amount;
                    this.transaction.comment = this.transactionToEdit.comment;
                    this.transaction.type = this.transactionToEdit.type;
                    this.transaction.category = this.transactionToEdit.category_id;
                    this.transaction.date = this.transactionToEdit.created_at.split(' ')[0];
                    this.transaction.tag = this.transactionToEdit.tag;
                } else {
                    this.transaction.amount= 0
                    this.transaction.comment = ''
                    this.transaction.type = 1
                    this.transaction.category = null
                    this.transaction.date = Carbon.now().format()
                    this.transaction.tag = null
                }
            }
        }
    }
</script>

<style scoped>
    .form-footer {
        width: 100%;
        text-align: center;
    }
    #fab {
        position: fixed;
        right: 10px;
        bottom: 10px;
    }
    .invalid-feedback {
        display: inherit;
    }
</style>