import axios from 'axios';
import JWT from './helpers/jwt';
import store from './stores/index';
import {AUTHENTICATE} from "./stores/mutation-types";
import router from "../../homes/js/router";

window.axios = axios;
window.axios.defaults.baseURL = '/api';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if (JWT.getToken() && JWT.getTokenType()) {
	window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
	store.commit(AUTHENTICATE);
}

window.axios.interceptors.response.use((response) => {
	return response
}, (error) => {
	switch (error.response.status) {
		// 如果响应中的 http code 为 401，那么则此用户可能 token 失效了之类的，我会触发 logout 方法，清除本地的数据并将用户重定向至登录页面
		case 401:
			store.dispatch('unauthenticate');
			return router.push({name : 'login'});
			break
	}
	return Promise.reject(error)
});