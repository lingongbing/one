export const mobile = {
	getMessage:'必须是11位手机号码',
	validate(value) {
		return value.length == 11 && /^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(value)
	}
};

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