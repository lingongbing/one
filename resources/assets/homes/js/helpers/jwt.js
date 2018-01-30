export default {
	setToken(token) {
		window.localStorage.setItem('access_token',token);
	},
	getToken() {
		return window.localStorage.getItem('access_token');
	},
	removeToken() {
		window.localStorage.removeItem('access_token');
	},
	setTokenType(token_type) {
		window.localStorage.setItem('token_type',token_type);
	},
	getTokenType() {
		return window.localStorage.getItem('token_type');
	},
	removeTokenType() {
		window.localStorage.removeItem('token_type');
	}
}