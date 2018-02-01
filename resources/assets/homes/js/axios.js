import axios from 'axios';
import JWT from './helpers/jwt';
import store from './stores/index';
import {AUTHENTICATE} from "./stores/mutation-types";
import router from './router';

window.axios = axios;
window.axios.defaults.baseURL = '/api';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if (JWT.getToken() && JWT.getTokenType()) {
	window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
	store.commit(AUTHENTICATE);
}

window.axios.interceptors.response.use(
	response => {
		return response;
	},
	error => {
		if (error.response) {
			switch (error.response.status) {
				case 401:
					// 返回 401 清除token信息并跳转到登录页面
					if (store.getters.authenticate) {
						window.axios.put('authorizations/current').then(response => {
							JWT.setToken(response.data.access_token);
							JWT.setTokenType(response.data.token_type);
							window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
						})
					}else {
						router.push({name : 'authorizations'});
					}
			}
		}
		return Promise.reject(error)   // 返回接口返回的错误信息
	});