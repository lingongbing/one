import JWT from '../../helpers/jwt';

export default {
	actions:{
		login({dispatch},formData) {
			return axios.post('/authorizations',formData).then(response => {
				JWT.setTokenType(response.data.token_type);
				JWT.setToken(response.data.access_token);
				window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType()+ ' ' + JWT.getToken();
				dispatch('authenticate',true);
				dispatch('setAuthUser',response.data.user);
			});
		},
		logout({dispatch}) {
			JWT.removeToken();
			dispatch('authenticate',false);
			dispatch('unSetAuthUser');
		}
	}
}