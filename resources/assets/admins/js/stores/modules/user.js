import {USER} from "../mutation-types";

export default {
	state: {
		role: '',
		username: '',
	},
	mutations: {
		[USER](state, user) {
			state.role = user.role;
			state.username = user.username;
		},
	},
	getters: {
		role: state => {
			return state.role;
		},
		username: state => {
			return state.username;
		},
	},
	actions: {
		user({commit}) {
			return axios.get('user').then(response => {
				commit(USER,response.data);
			});
		}
	}
}