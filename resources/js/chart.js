require('./bootstrap');
import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';

window.Vue = require('vue');

Vue.use(Donut);

const app = new Vue({
    el: '#app'
});
