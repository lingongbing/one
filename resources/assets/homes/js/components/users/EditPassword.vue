<template>
	<div>
		<mt-field placeholder="新密码" type="password" v-model="user.password"></mt-field>
		<mt-field placeholder="新密码" type="password" v-model="user.confirmed_password"></mt-field>
		
		<div class="container">
			<mt-button class="mt-button" type="primary" size="large" plain @click="onSubmit()">确认修改</mt-button>
		</div>
	</div>
</template>

<script>
	import { Toast } from 'mint-ui';
	export default {
		data() {
			return {
				user: {
					password: '',
					confirmed_password: ''
				},
			}
		},
		methods: {
			onSubmit: function () {
				if (this.user.password === this.user.confirmed_password) {
					window.axios.patch('user',{
						password:this.user.password
					}).then(response => {
						Toast('修改成功');
					}).catch(error => {
						Toast(error.response.data.message);
					})
				} else {
					Toast('两次密码不一样');
				}
			}
		}
	}
</script>

<style scoped>
	.mt-button {
		margin-top: 10px;
		padding-top: 8px;
	}
</style>