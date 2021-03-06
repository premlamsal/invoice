/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

//print block//
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);

//print block ends//




//bootstrap for vue//
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
//bootstrap for vue ends//



//notification block//
//Toaster
import CxltToastr from 'cxlt-vue2-toastr';

var toastrConfigs = {
    position: 'top right',
    showDuration: 1000,
    timeOut: 4000
    
}

Vue.use(CxltToastr, toastrConfigs);

import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'

//notification block ends//





//Sweet alert start//


import VueSweetalert2 from 'vue-sweetalert2';
 
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
 
Vue.use(VueSweetalert2);

//Sweet alert ends//


let routes = [
  
  { 
    path: '/',
    component: require('./components/dashboard.vue').default
  },

  { 
    path: '/dashboard', 
    component: require('./components/dashboard.vue').default
  },

  //invoice routes
  { 
    path: '/invoices', 
    name:'invoices',
    component: require('./components/invoice/invoices.vue').default 
  },

  { 
    path: '/newInvoice', 
    component: require('./components/invoice/newInvoice.vue').default
  },

  {
   path: '/:id/editInvoice',
   name:'editInvoice' ,
   component: require('./components/invoice/editInvoice.vue').default
  },

  { 
    path: '/:id/showInvoice/',
    name:'showInvoice' ,
    component: require('./components/invoice/showInvoice.vue').default
  },

  { 
    path: '/:id/printInvoice/',
    name:'printInvoice' ,
    component: require('./components/invoice/printInvoice.vue').default
  },

  //estimate routes
  { 
    path: '/estimates', 
    name:'estimates',
    component: require('./components/estimate/estimates.vue').default 
  },

  { 
    path: '/newEstimate', 
    component: require('./components/estimate/newEstimate.vue').default
  },

  { 
    path: '/:id/editEstimate',
    name:'editEstimate' ,
    component: require('./components/estimate/editEstimate.vue').default
  },
  { 
    path: '/:id/showEstimate/',
    name:'showEstimate' ,
    component: require('./components/estimate/showEstimate.vue').default
  },
  { 
    path: '/:id/printEstimate/',
    name:'printEstimate' ,
    component: require('./components/estimate/printEstimate.vue').default
  },

  //customer routes
  { 
    path: '/customers', 
    name:'customers',
    component: require('./components/customer/customers.vue').default 
  },

  //units route
  { 
    path: '/units/',
    name:'units' ,component: require('./components/units/units.vue').default
  },

  //settings route
  { 
    path: '/settings/',
    name:'settings' ,
    component: require('./components/settings.vue').default
  },

];



const router = new VueRouter({
 
  routes // short for `routes: routes`
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// register modal component
Vue.component('modal', {
  template: '#modal-template'
  
})




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
     router,
     data:{
     	message:'',

     },

     methods:{

        
     },
  
});

