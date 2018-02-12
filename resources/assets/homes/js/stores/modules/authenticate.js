import {AUTHENTICATE,UNAUTHENTICATE} from "../mutation-types";
import JWT from '../../helpers/jwt';

export default {
	state: {
		authenticate: false,
	},
	mutations:{
		[AUTHENTICATE] (state) {
			state.authenticate = true;
		},
		[UNAUTHENTICATE] (state) {
			state.authenticate = false;
		}
	},
	getters: {
		authenticate: state => {
			return state.authenticate;
		},
	},
	actions:{
		authenticate({commit},credentials) {
			return window.axios.post('/authorizations',credentials).then(response => {
				JWT.setToken(response.data.token_type + ' ' + response.data.access_token);
				window.axios.defaults.headers.common['Authorization'] = JWT.getToken();
				commit(AUTHENTICATE);
			});
		},
		unauthenticate({commit}) {
			return window.axios.delete('authorizations/current').then(response => {
				JWT.removeToken();
				window.axios.defaults.headers.common['Authorization'] = '';
				commit(UNAUTHENTICATE);
			});
		},
		refreshToken(token) {
			JWT.setToken(token);
			window.axios.defaults.headers.common['Authorization'] = JWT.getToken();
		},
		resetPasswordAuthenticate({commit},user){
			JWT.setToken(user.meta.token_type + ' ' + user.meta.access_token);
			window.axios.defaults.headers.common['Authorization'] = user.meta.token_type + ' ' + user.meta.access_token;
		}
	}
}