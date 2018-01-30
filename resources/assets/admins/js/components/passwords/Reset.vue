<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">找回密码</h3>
		</div>
		<div class="panel-body">
			<div class="alert" :class="alert_class" role="alert" v-show="alert_message">
				<button type="button" class="close" @click="alert_message = ''">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ alert_message }}
			</div>
			<form class="form-horizontal">
				<div class="form-group" :class="{'has-error' : errors.has('username')}" v-show="!is_send">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="username" name="username" id="username"
						       placeholder="账号" v-validate data-vv-rules="required" data-vv-as="账号" :disabled="lock_username || this.$store.getters.username">
						<span class="help-block" v-show="errors.has('username')">{{ errors.first('username') }}</span>
					</div>
				</div>
				<div class="form-group" :class="{'has-error' : errors.has('code')}" v-show="is_send && !is_validation">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="code" name="code" id="code" placeholder="验证码"
						       v-validate data-vv-rules="required" data-vv-as="验证码" @change="validationCode()">
						<span class="help-block" v-show="errors.has('code')">{{ errors.first('code') }}</span>
					</div>
				</div>
				<div class="form-group" :class="{'has-error' : errors.has('password')}" v-show="is_validation">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="password" class="form-control" v-model="password" name="password" id="password" placeholder="新密码"
						       v-validate data-vv-rules="required" data-vv-as="新密码">
						<span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
					</div>
				</div>
				<div class="form-group" :class="{'has-error' : errors.has('confirmed_password')}" v-show="is_validation">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="password" class="form-control" v-model="confirmed_password" name="confirmed_password" id="confirmed_password" placeholder="确认新密码"
						       v-validate data-vv-rules="required|confirmed:password" data-vv-as="确认新密码">
						<span class="help-block" v-show="errors.has('confirmed_password')">{{ errors.first('confirmed_password') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="button" class="btn btn-default" @click="sendMobileCode()" :disabled="this.$store.getters.time > 0" v-show="!is_validation">发送验证码到手机<span v-show="this.$store.getters.time">({{ this.$store.getters.time }})</span></button>
						<button type="button" class="btn btn-default" @click="changePassword()" v-show="is_validation">修改密码</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				is_send: false,
				is_validation: false,
				code: '',
				username: this.$store.getters.username,
				lock_username: false,
				alert_class: '',
				alert_message: '',
				password: '',
				confirmed_password: '',
			}
		},
		created() {
			console.log(this.$store.getters.username == true);
		},
		methods: {
			sendMobileCode: function () {
				this.$validator.validateAll({'username':this.username}).then(result => {
					if (result) {
						const formData = new FormData();
						formData.append('username', this.username);
						axios.post('/password/mobile', formData).then(response => {
							this.is_send = true;
							this.lock_username =true;
							this.alert_class = 'alert-success';
							this.alert_message = response.data.message;
							this.$store.dispatch('setCodeTimeCountDown',120);
							this.$store.dispatch('codeTimeCountDown');
						}).catch(error => {
							this.is_send = true;
							this.lock_username =true;
							this.$store.dispatch('setCodeTimeCountDown',120);
							this.$store.dispatch('codeTimeCountDown');
							this.alert_class = 'alert-danger';
							if (error.response.status === 422) {
								this.alert_message = error.response.data.errors.username[0];
							}else {
								this.alert_message = error.response.data.error;
							}
						})
					}
				});
			},
			validationCode: function () {
				this.$validator.validateAll({'code':this.code}).then(result => {
					if (result) {
						const formData = new FormData();
						formData.append('code', this.code);
						formData.append('username', this.username);
						axios.post('/password/mobile/validation', formData).then(response => {
							this.is_validation = true;
							this.alert_class = 'alert-success';
							this.alert_message = response.data.message;
						}).catch(error => {
							this.alert_class = 'alert-danger';
							if (error.response.status === 422) {
								this.alert_message = error.response.data.errors.username[0];
							}else {
								this.alert_message = error.response.data.error;
							}
						})
					}
				});
			},
			changePassword: function () {
				this.$validator.validateAll({'password':this.password,'confirmed_password':this.confirmed_password}).then(result => {
					if (result) {
						const formData = new FormData();
						formData.append('username', this.username);
						formData.append('password', this.password);
						axios.post('/password/reset', formData).then(response => {
							this.alert_message = response.data.message;
							this.$router.push({name:'login'});
						}).catch(error => {
							this.alert_class = 'alert-danger';
							if (error.response.status === 422) {
								this.alert_message = error.response.data.errors.username[0];
							}else {
								this.alert_message = error.response.data.error;
							}
						})
					}
				});
			}
		}
	}
</script>

<style scoped>

</style>