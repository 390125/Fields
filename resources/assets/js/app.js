//import ExampleComponent from './components/ExampleComponent.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import ModalTemplate from './components/ModalTemplate.vue';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * bs/uilding robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');



 // register modal component
 //Vue.component('modal-template', require('./components/ModalTemplate.vue'));

const app = new Vue({
    el: '#app',
    data: {
        showModal: false
    },
    components: {
        'example-component': ExampleComponent,
        'modal-template' : ModalTemplate
    }
});
