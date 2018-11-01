
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Notification from 'vue-notification'

window.Vue = require('vue');

Vue.use(Notification);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('category-form', require('./components/CategoryForm.vue'));
Vue.component('categories-list', require('./components/CategoriesList.vue'));
//Vue.component('category-form', require('./components/CategoryForm.vue'));

const app = new Vue({
    el: '#app'
});
