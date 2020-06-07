require('./bootstrap');


import { Form, HasError, AlertError } from 'vform'
import VueRouter from 'vue-router'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import Swal from 'sweetalert2'


window.Vue = require('vue');
window.Swal = Swal;
window.Form = Form;


Vue.use(VueRouter);
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '5px'
})


// Global component and methods
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('passport-clients',require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients',require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue').default);
Vue.component('not-found', require('./components/NotFound.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));


// Filters
Vue.filter('upText', function(text){ return text.toUpperCase();}); // the name of the filter is : upText
Vue.filter('myDate', function(date){ return moment(date).format("MMM Do YY");});


// Routes
let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developpers', component: require('./components/Developpers.vue').default } 
]


// Router
const router = new VueRouter({
  mode : 'history',
  linkActiveClass: 'active',
  routes // raccourci pour `routes: routes`
  })


//Toast for SweetAlert2
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast;

const app = new Vue({
    el: '#app',
    router
});
