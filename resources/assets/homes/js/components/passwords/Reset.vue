<template>
	<div class="container">
		<div class="card border-info mb-3">
			<div class="card-header bg-transparent border-info">找回密码</div>
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
					<button type="submit" class="btn btn-primary btn-block">登陆</button>
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
	export default {
	
	}
</script>

<style scoped>
	.container {
		margin-top: 50px;
	}
</style>