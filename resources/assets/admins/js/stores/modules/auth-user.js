import {AUTHENTICATE,SETAUTHUSER} from "../mutation-types";
import JWT from "../../helpers/jwt";

export default {
	state: {
		authenticate: false,
		role: '',
		username: '',
	},
	mutations:{
		[AUTHENTICATE] (state,status) {
			state.authenticate = status;
		},
		[SETAUTHUSER] (state,user) {
			state.role = user.role;
			state.username = user.username;
		}
	},
	getters: {
		authenticate: state => {
			return state.authenticate;
		},
		role: state => {
			return state.role;
		},
		username: state => {
			return state.username;
		}
	},
	actions:{
		authenticate(context,status) {
			context.commit(AUTHENTICATE,status);
		},
		setAuthUser(context,user) {
			context.commit(SETAUTHUSER,user);
		},
		unSetAuthUser({commit}) {
			return axios.post('/logout').then(response => {
				commit(SETAUTHUSER,{
					role : null,
					username: null
				});
			});
		}
	}
}