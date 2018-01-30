import axios from 'axios';
import JWT from './helpers/jwt';
import store from './stores/index';
import {AUTHENTICATE} from "./stores/mutation-types";

window.axios = axios;
window.axios.defaults.baseURL = 'http://api.one.com';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if (JWT.getToken() && JWT.getTokenType()) {
	window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
	store.commit(AUTHENTICATE);
}