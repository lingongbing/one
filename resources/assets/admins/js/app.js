import {AUTHENTICATE} from "../../homes/js/stores/mutation-types";

require('./axios');
require('./bootstrap');

import Vue from 'vue';
// 路由
import VueRouter from 'vue-router'
import router from './router';
Vue.use(VueRouter);
// 验证
import zh_CN from 'vee-validate/dist/locale/zh_CN';
import VeeValidate, { Validator } from 'vee-validate';
Validator.localize('zh_cn', zh_CN);
import * as rules from './rules';
Validator.extend('mobile',rules.mobile);
Validator.extend('mobileIsExist',rules.mobileIsExist);
Validator.extend('usernameIsExist',rules.usernameIsExist);
Vue.use(VeeValidate);
//状态
import Vuex from 'vuex'
import store from './stores/index'
import JWT from './helpers/jwt'
Vue.use(Vuex);
if (JWT.getToken())
{
    store.commit(AUTHENTICATE);
    store.dispatch('user');
}

Vue.component('app', require('./components/App'));

const app = new Vue({
    el: '#app',
    router,
    store,
});