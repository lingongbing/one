<template>
	<form action="#" class="fh5co-form animate-box" data-animate-effect="fadeInRight" v-on:submit.prevent="onSubmit">
		<h2>Sign In</h2>
		<div class="form-group">
			<label for="username" class="sr-only">账号</label>
			<input type="text" class="form-control" v-model="username" name="username" id="username" placeholder="账号"
			       v-validate data-vv-rules="required" data-vv-as="账号">
			<span class="help-block" v-show="errors.has('username')">{{ errors.first('username') }}</span>
		</div>
		<div class="form-group">
			<label for="password" class="sr-only">密码</label>
			<input type="password" class="form-control" v-model="password" name="password" id="password"
			       placeholder="密码"
			       v-validate data-vv-rules="required" data-vv-as="密码">
			<span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
		</div>
		<div class="form-group">
			<label for="remember"><input type="checkbox" id="remember">记住我</label>
		</div>
		<div class="form-group">
			<input type="submit" value="登陆" class="btn btn-primary">
			<router-link :to="{name:'password-reset'}" class="btn btn-primary" tag="button">忘记密码</router-link>
		</div>
	</form>
</template>

<script>
	export default {
		data() {
			return {
				username: '',
				password: '',
				error: '',
			}
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						const formData = new FormData();
						formData.append('username', this.username);
						formData.append('password', this.password);
						this.$store.dispatch('authenticate', formData).then(response => {
							this.$router.push({name: 'index'});
						}).catch(error => {
						
						});
					}
				});
			}
		},
	}
</script>