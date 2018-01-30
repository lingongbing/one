import {AUTHENTICATE} from "../mutation-types";
import JWT from '../../helpers/jwt';

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
		authenticate({commit},credentials) {
			return axios.post('/authorizations',credentials).then(response => {
				JWT.setToken(response.data.access_token);
				JWT.setTokenType(response.data.token_type);
				window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
				commit(AUTHENTICATE)
			});
		}
	}
}