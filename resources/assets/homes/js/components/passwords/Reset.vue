<template>
	<div class="container">
		<div class="card border-info mb-3">
			<div class="card-header bg-transparent border-info">找回密码</div>
			<div class="card-body">
				<div class="alert alert-info" role="alert" v-show="message">{{ message }}</div>
				<form>
					<div class="form-group">
						<label for="mobile">输入手机号</label>
						<input type="text" class="form-control" v-model="mobile" id="mobile" name="mobile"
						       placeholder="输入手机号" v-validate data-vv-rules="required|mobile" data-vv-as="手机号">
						<small class="form-text text-muted">{{ errors.first('mobile') }}</small>
					</div>
					<div class="form-group">
						<label for="password">新密码</label>
						<input type="password" class="form-control" id="password" v-model="password" name="password"
						       placeholder="Password" v-validate data-vv-rules="required|min:6" data-vv-as="新密码">
						<small class="form-text text-muted">{{ errors.first('password') }}</small>
					</div>
					<div class="form-group" v-show="show_captcha">
						<label for="captcha">图形验证码</label>
						<input type="email" class="form-control" id="captcha" v-model="captcha_code" name="captcha_code"
						       placeholder="图形验证码"
						       v-validate data-vv-rules="required" data-vv-as="图形验证码">
						<img :src="captcha_image" @click="storeCaptcha()">
						<small class="form-text text-muted">{{ errors.first('captcha_code') }}</small>
					</div>
					<div class="form-group" v-show="captcha_key && captcha_image">
						<label for="mobile">手机验证码</label>
						<input type="text" class="form-control" v-model="verification_code" name="verification_code"
						       aria-describedby="verificationCodeHelp"
						       v-validate data-vv-rules="required" data-vv-as="手机验证码" placeholder="手机验证码">
						<button class="btn btn-default" type="button" :disabled="counting"
						        @click="storeMobileCaptcha()">
							<vue-countdown v-if="counting" :time="60000" @countdownend="countdownend">
								<template slot-scope="props">{{ props.seconds || 60 }}秒后再次发送验证码</template>
							</vue-countdown>
							<span v-else>发送验证码</span>
						</button>
						<small class="form-text text-muted">
							{{errors.first('verification_code') }}
						</small>
					</div>
					<button type="button" class="btn btn-primary" @click="storeCaptcha()">获取验证码</button>
					<button type="button" class="btn btn-primary" @click="onSubmit()">修改密码</button>
				</form>
			</div>
			<div class="card-footer bg-transparent border-info">
				<router-link :to="{ name : 'authorizations' }" tag="a">登陆</router-link>
				<router-link :to="{ name : 'user-create' }" tag="a">注册账号</router-link>
			</div>
		
		</div>
	</div>
</template>

<script>
	import VueCountdown from '@xkeshi/vue-countdown';


	export default {
		components:{VueCountdown},
		data() {
			return {
				mobile: '',
				message: '',
				password: '',
				counting: false,
				captcha_key: '',
				captcha_code: '',
				captcha_image: '',
				show_captcha: false,
				verification_key: '',
				verification_code: ''
			}
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						window.axios.post('passwords/resetPassword', {
							password: this.password,
							verification_key: this.verification_key,
							verification_code: this.verification_code
						}).then(response => {
							this.$store.dispatch('resetPasswordAuthenticate', response.data);
							window.location.href = '/';
						}).catch(error => {
							this.message = error.response.data.message;
						})
					}
				});
			},
			storeCaptcha: function () {
				this.$validator.validate('mobile', this.mobile).then((result) => {
					if (result) {
						window.axios.post('passwords/captcha', {
							mobile: this.mobile
						}).then(response => {
							this.show_captcha = true;
							this.captcha_key = response.data.captcha_key;
							this.captcha_image = response.data.captcha_image_content;
						})
					}
				});
			},
			storeMobileCaptcha: function () {
				this.$validator.validate('captcha_code', this.captcha_code).then(result => {
					if (result) {
						window.axios.post('passwords/verificationCodes', {
							captcha_key: this.captcha_key,
							captcha_code: this.captcha_code
						}).then(response => {
							this.countdown();
							this.verification_key = response.data.key;
						}).catch(error => {
							this.storeCaptcha();
							this.message = error.response.data.message;
						})
					}
				});
			},
			countdown: function () {
				this.counting = true;
			},
			countdownend: function () {
				this.counting = false;
			}
		}
	}
</script>

<style scoped>
	.container {
		margin-top: 50px;
	}
</style>