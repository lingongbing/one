import axios from 'axios';
import JWT from './helpers/jwt';
import store from './stores/index';
import {AUTHENTICATE} from "./stores/mutation-types";
import router from "../../homes/js/router";

window.axios = axios;
window.axios.defaults.baseURL = '/api';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if (JWT.getToken()) {
	window.axios.defaults.headers.common['Authorization'] = JWT.getToken();
	store.commit(AUTHENTICATE);
}

window.axios.interceptors.response.use((response) => {
	// console.log(response.headers);
	// 判断一下响应中是否有 token，如果有就直接使用此 token 替换掉本地的 token。你可以根据你的业务需求自己编写更新 token 的逻辑
	// let token = response.headers.authorization;
	// if (token) {
		// 如果 header 中存在 token，那么触发 refreshToken 方法，替换本地的 token
		// JWT.setToken(token);
		// window.axios.defaults.headers.common['Authorization'] = JWT.getToken();
	// }
	return response
});