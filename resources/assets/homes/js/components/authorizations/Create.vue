<template>
	<div class="container">
		<div class="card border-info mb-3">
			<div class="card-header bg-transparent border-info">登陆</div>
			<div class="card-body text-success">
				<h5 class="card-title" v-if="message">{{ message }}</h5>
				<form class="needs-validation" novalidate v-on:submit.prevent="onSubmit()">
					<div class="form-group">
						<input type="text" class="form-control" v-model="username" name="username"
						       aria-describedby="usernameHelp"
						       v-validate data-vv-rules="required|max:255" data-vv-as="账号" placeholder="账号">
						<small id="usernameHelp" class="form-text text-muted">{{ errors.first('username') }}
						</small>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" v-model="password" name="password"
						       aria-describedby="passwordHelp"
						       v-validate data-vv-rules="required" data-vv-as="密码" placeholder="密码">
						<small id="passwordHelp" class="form-text text-muted">{{ errors.first('password') }}
						</small>
					</div>
					<button type="submit" class="btn btn-primary btn-block">登陆</button>
				</form>
			</div>
			<div class="card-footer bg-transparent border-info">
				<router-link :to="{ name : 'password-reset' }" tag="a">找回密码</router-link>
				<router-link :to="{ name : 'user-create' }" tag="a">注册账号</router-link>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				message: '',
				username: '',
				password: ''
			}
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						const credentials = new FormData();
						credentials.append('username', this.username);
						credentials.append('password', this.password);
						this.$store.dispatch('authenticate', credentials).then(response => {
							this.$router.push({name: 'home'});
						}).catch(error => {
							this.message = error.response.data.message;
						});
					}
				});
			}
		}
	}
</script>

<style scoped>

</style>