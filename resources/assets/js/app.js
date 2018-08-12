
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })

import ProductsIndex from './components/products/index.vue';
import ProductsCreate from './components/products/form.vue';
import ProductsEdit from './components/products/form.vue';
import money from 'v-money'
window.Vue.use(money, { precision: 2 })
import App from './views/App';

const router = new VueRouter({
    routes: [
      {
          path: '/',
          name: 'products',
          component: ProductsIndex
      },
       {
            path: '/products/create',
            name: 'products-create',
           component: ProductsCreate
       }, 
        {
            path: '/products/edit/:id',
            name: 'products-edit',
            component: ProductsEdit
        }, 

    ]


});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    components: { App },
    router
});
