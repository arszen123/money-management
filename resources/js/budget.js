require('./bootstrap');
import VueRouter from 'vue-router';
import Router from './Router.js';
import BudgetsList from './components/BudgetsList';
import BudgetForm from './components/BudgetForm';
import SavingsList from './components/SavingsList';
import SavingForm from './components/SavingForm';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Router);

Vue.component('savings-view', require('./components/SavingView.vue'));
Vue.component('budgets-view', require('./components/BudgetsView.vue'));

const routes = [
    {
        path: '/2',
        children:[
            {path: '', component: BudgetsList, name: 'list'},
            {path: 'create', component: BudgetForm, name: 'create'},
        ]
    },
    {
        path: '/1',
        children: [
            {path: '1', components: {a: SavingsList}, name: 'list1'},
            {path: 'create1', components: {a: SavingForm}, name: 'create1'}
        ]
    },
    {path: '3', components: {a: SavingsList}, name: 'list3'},
    {path: 'create3', components: {a: SavingForm}, name: 'create3'}
]

const router = new VueRouter({
    routes
})
const t = new Router();
const app = new Vue({
    router,
    t
}).$mount('#wallet');
