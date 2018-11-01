require('./bootstrap');
import Notification from 'vue-notification'
import VueRouter from 'vue-router'

window.Vue = require('vue');

Vue.use(Notification);
Vue.use(VueRouter);

Vue.component('transaction-form', require('./components/TransactionForm'));
Vue.component('transaction-view', require('./components/TransactionView'));
Vue.component('transaction-links', require('./components/TransactionLinks'));

let router = new VueRouter({
    routes: [
        {path: '/:resource/:id'}
    ]
});
const app = new Vue({
    router
}).$mount('#transaction');
