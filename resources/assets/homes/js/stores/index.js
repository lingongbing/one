import Vue from 'vue'
import Vuex from 'vuex'
import authenticate from './modules/authenticate'

Vue.use(Vuex);

export default new Vuex.Store({
	modules:{
		authenticate
	}
});