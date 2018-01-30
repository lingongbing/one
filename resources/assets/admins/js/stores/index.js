import Vue from 'vue'
import Vuex from 'vuex'
import user from './modules/user';
import authorizations from './modules/authenticate';

Vue.use(Vuex);

export default new Vuex.Store({
	modules:{
		user,authorizations
	}
});