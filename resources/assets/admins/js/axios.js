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
	return response;
},(error) => {
	return Promise.reject(error)
});