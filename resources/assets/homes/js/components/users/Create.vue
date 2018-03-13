<template>
	<div class="container">
		<div class="card border-info mb-3">
			<div class="card-header bg-transparent border-info">注册</div>
			<div class="card-body text-success">
				<h5 class="card-title" v-if="message">{{ message }}</h5>
				<form class="needs-validation" novalidate v-on:submit.prevent="onSubmit()">
					<div class="form-group">
						<input type="text" class="form-control" v-model="mobile" name="mobile"
						       aria-describedby="mobileHelp"
						       v-validate data-vv-rules="required|mobile|unique_mobile" data-vv-as="手机"
						       placeholder="手机">
						<small id="mobileHelp" class="form-text text-muted">{{ errors.first('mobile') }}</small>
					</div>
					
					<div class="form-group">
						<input type="text" class="form-control" v-model="username" name="username"
						       aria-describedby="usernameHelp"
						       v-validate data-vv-rules="required|unique_username" data-vv-as="账号" placeholder="账号">
						<small id="usernameHelp" class="form-text text-muted">{{ errors.first('username') }}</small>
					</div>
					
					<div class="form-group">
						<input type="password" class="form-control" v-model="password" name="password"
						       aria-describedby="passwordeHelp"
						       v-validate data-vv-rules="required|min:6" data-vv-as="密码" placeholder="密码">
						<small id="passwordeHelp" class="form-text text-muted">{{ errors.first('password') }}</small>
					</div>
					
					<div class="form-group">
						<input type="password" class="form-control" name="confirmed_password"
						       aria-describedby="confirmedPasswordHelp"
						       v-validate data-vv-rules="required|min:6" data-vv-as="确认密码" placeholder="确认密码">
						<small id="confirmedPasswordHelp" class="form-text text-muted">{{
							errors.first('confirmed_password') }}
						</small>
					</div>
					
					<div class="input-group" v-show="captcha_key && captcha_image">
						<input type="text" class="form-control" v-model="captcha_code" name="captcha_code"
						       aria-describedby="captchaImageHelp"
						       v-validate data-vv-rules="required" data-vv-as="图形验证码" placeholder="图形验证码">
						<img :src="captcha_image" class="input-group-addon" @click="storeCaptcha()">
						<small id="captchaImageHelp" class="form-text text-muted">{{ errors.first('captcha_code') }}
						</small>
					</div>
					
					<div class="input-group" v-show="captcha_key && captcha_image">
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
						<small id="verificationCodeHelp" class="form-text text-muted" style="width: 100%;">
							{{errors.first('verification_code') }}
						</small>
					</div>
					
					<div class="form-group">
						<button type="button" class="btn btn-primary btn-block" @click="storeCaptcha()">获取验证码</button>
						<button type="submit" class="btn btn-primary btn-block">注册</button>
						<small class="form-text text-muted" v-show="errors.first('verification_code')">请先输入验证码</small>
					</div>
				</form>
			</div>
			<div class="card-footer bg-transparent border-info">
				<router-link :to="{ name : 'authorizations' }" tag="a">登陆</router-link>
				<router-link :to="{ name : 'password-reset' }" tag="a">找回密码</router-link>
			</div>
		</div>
	</div>
</template>

<script>
	import VueCountdown from '@xkeshi/vue-countdown';
	import {AUTHENTICATE} from "../../stores/mutation-types";
	import JWT from '../../helpers/jwt';

	export default {
		components: {
			VueCountdown
		},
		data() {
			return {
				mobile: '',
				message: '',
				username: '',
				password: '',
				counting: false,
				captcha_key: '',
				captcha_code: '',
				captcha_image: '',
				verification_key: '',
				verification_text: '发送短信验证码',
				verification_code: ''
			}
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						window.axios.post('users', {
							username: this.username,
							password: this.password,
							verification_key: this.verification_key,
							verification_code: this.verification_code
						}).then(response => {
							JWT.setToken(response.data.meta.access_token);
							JWT.setTokenType(response.data.meta.token_type);
							window.axios.defaults.headers.common['Authorization'] = JWT.getTokenType() + ' ' + JWT.getToken();
							this.$store.commit(AUTHENTICATE);
							this.$router.push({ name : 'home' });
						}).catch(error => {
							this.message = error.response.data.message;
						})
					}
				});
			},
			storeCaptcha: function () {
				window.axios.post('captchas', {
					mobile: this.mobile
				}).then(response => {
					this.captcha_key = response.data.captcha_key;
					this.captcha_image = response.data.captcha_image_content;
				}).catch(error => {
					this.message = error.response.data.message;
				})
			},
			storeMobileCaptcha: function () {
				this.$validator.validateAll({captcha_code: this.captcha_code}).then(result => {
					if (result) {
						window.axios.post('verificationCodes', {
							captcha_key: this.captcha_key,
							captcha_code: this.captcha_code
						}).then(response => {
							this.countdown();
							this.verification_key = response.data.key;
						}).catch(error => {
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
			},
		}
	}
</script>

<style scoped>
	.input-group {
		margin-bottom: 1rem;
	}
	.container {
		margin-top: 70px;
	}
</style>