export const mobileIsExist = {
	getMessage:'手机号码已经存在',
	validate(value) {
		return axios.get('/confirmed-mobile/' + value).then(result => {
			return true;
		}).catch(result => {
			return false;
		})
	}
};

export const usernameIsExist = {
	getMessage:'账号已经存在',
	validate(value) {
		return axios.get('/confirmed-username/' + value).then(result => {
			return true;
		}).catch(result => {
			return false;
		})
	}
};

export const mobile = {
	getMessage:'格式错误',
	validate(value) {
		return /^1[34578]\d{9}$/.test(value)
	}
};

export const unique_mobile = {
	getMessage:'手机 已经存在',
	validate(value) {
		return window.axios.get('/confirmed',{
			params:{
				mobile:value
			}
		}).then(result => {
			return true;
		}).catch(result => {
			return false;
		})
	}
};

export const unique_username = {
	getMessage:'账号 已经存在',
	validate(value) {
		return window.axios.get('/confirmed',{
			params:{
				username:value
			}
		}).then(result => {
			return true;
		}).catch(result => {
			return false;
		})
	}
};