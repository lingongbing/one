<template>
	<div class="needs-validation" v-on:submit.prevent="onSubmit()">
		<div class="form-group">
			<input type="text" class="form-control" v-model="mobile" name="mobile"
			       aria-describedby="mobileHelp"
			       v-validate data-vv-rules="required|mobile|unique_mobile" data-vv-as="手机"
			       placeholder="手机">
			<small id="mobileHelp" class="form-text text-muted">{{ errors.first('mobile') }}</small>
		</div>
		<div class="input-group" v-show="captcha_key && captcha_image">
			<input type="text" class="form-control" v-model="captcha_code" name="captcha_code"
			       aria-describedby="captchaImageHelp"
			       v-validate data-vv-rules="required" data-vv-as="图形验证码" placeholder="图形验证码">
			<img :src="captcha_image" class="input-group-addon" @click="storeCaptcha()">
			<small id="captchaImageHelp" class="form-text text-muted">{{ errors.first('captcha_code') }}</small>
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
		<div class="container">
			<mt-button class="mt-button" type="primary" size="large" plain @click="storeCaptcha()">获取验证码</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="onSubmit()">确认修改</mt-button>
		</div>
	</div>
</template>

<script>
	import { Toast } from 'mint-ui';
	import VueCountdown from '@xkeshi/vue-countdown';
	export default {
		components: {
			VueCountdown
		},
		data() {
			return {
				mobile: '',
				message: '',
				captcha: '',
				counting: false,
				captcha_key: '',
				captcha_code: '',
				captcha_image: '',
				show_captcha:false,
				verification_key: '',
				verification_text: '发送短信验证码',
				verification_code: ''
			}
		},
		watch: {
			show_captcha: function () {
				if (this.show_captcha) {
					this.storeCaptcha();
				}
			}
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						window.axios.patch('user', {
							verification_key: this.verification_key,
							verification_code: this.verification_code
						}).then(response => {
							Toast('修改成功');
						}).catch(error => {
							Toast(error.response.data.message);
						})
					} else {
						Toast(this.errors.items[0].msg);
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
					Toast(error.response.data.message);
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
							Toast('手机验证码发送成功');
							this.verification_key = response.data.key;
						}).catch(error => {
							this.storeCaptcha();
							Toast(error.response.data.message);
						})
					} else {
						Toast(this.errors.items[0].msg);
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
	.mt-button {
		margin-top: 10px;
		padding-top: 8px;
	}
	#captchaImageHelp {
		width: 100%;
	}
	.needs-validation {
		margin: 10px;
	}
</style>