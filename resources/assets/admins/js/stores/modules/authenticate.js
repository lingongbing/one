import {AUTHENTICATE} from "../mutation-types";
import JWT from '../../helpers/jwt';
import {UNAUTHENTICATE} from "../../../../homes/js/stores/mutation-types";

export default {
	state: {
		authenticate: false,
	},
	mutations:{
		[AUTHENTICATE] (state) {
			state.authenticate = true;
		},
	},
	getters: {
		authenticate: state => {
			return state.authenticate;
		},
	},
	actions:{
		authenticate({commit,dispatch},credentials) {
			return axios.post('authorizations',credentials).then(response => {
				JWT.setToken(response.data.token_type + ' ' +response.data.access_token);
				window.axios.defaults.headers.common['Authorization'] = JWT.getToken();
				commit(AUTHENTICATE);
				dispatch('user');
			});
		},
		unauthenticate({commit}) {
			return window.axios.post('authorizations/current').then(response => {
				JWT.removeToken();
				JWT.removeTokenType();
				window.axios.defaults.headers.common['Authorization'] = false;
				commit(UNAUTHENTICATE);
			});
		},
		refreshToken({commit},token) {
			// JWT.setToken(token);
			console.log(token);
			window.axios.defaults.headers.common['Authorization'] = token;
		}
	}
}