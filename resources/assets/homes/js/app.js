require('./axios');
require('./bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex';
import store from './stores/index'
Vue.use(Vuex);

import VueRouter from 'vue-router';
import router from './router';
Vue.use(VueRouter);
import MintUI from 'mint-ui'
Vue.use(MintUI);

import zh_CN from 'vee-validate/dist/locale/zh_CN';
import VeeValidate, { Validator } from 'vee-validate';
Validator.localize('zh_cn', zh_CN);
import * as rules from './rules';
Validator.extend('mobile',rules.mobile);
Validator.extend('unique_mobile',rules.unique_mobile);
Validator.extend('unique_username',rules.unique_username);
Vue.use(VeeValidate);

Vue.component('app', require('./components/App'));

const app = new Vue({
    el: '#app',
	store,
    router,
});
