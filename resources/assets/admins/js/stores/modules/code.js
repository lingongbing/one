import {CODETIMECOUNTDOWN, SETCODETIMECOUNTDOWN} from "../mutation-types";

export default {
	state: {
		time: 0,
	},
	mutations: {
		[CODETIMECOUNTDOWN](state) {
			const ID = setInterval(function () {
				if (state.time > 0)
				{
					state.time--;
				}else {
					clearInterval(ID);
				}
			},1000);
		},
		[SETCODETIMECOUNTDOWN](state, time) {
			state.time = time;
		},
	},
	getters: {
		time: state => {
			return state.time;
		},
	},
	actions: {
		codeTimeCountDown(context) {
			context.commit(CODETIMECOUNTDOWN);
		},
		setCodeTimeCountDown(context, time) {
			context.commit(SETCODETIMECOUNTDOWN, time);
		},
	}
}