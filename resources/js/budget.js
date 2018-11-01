require('./bootstrap');
import Notification from 'vue-notification'

window.Vue = require('vue');

Vue.use(Notification);

Vue.component('savings-view', require('./components/SavingView.vue'));
Vue.component('budgets-view', require('./components/BudgetsView.vue'));

const app = new Vue().$mount('#wallet');
