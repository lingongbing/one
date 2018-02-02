<template>
	<div>
		<div class="form-group text-center" style="margin-bottom: 0;">
			<label for="avatar">头像</label>
			<input type="file" class="form-control-file" id="avatar" @change="uploadImg($event)" style="display: none;">
		</div>
		<div class="text-center">
			<img :src="user.avatar" v-show="user.avatar" class="img-thumbnail">
		</div>
		<mt-field label="姓名" placeholder="姓名" v-model="user.name"></mt-field>
		<mt-field label="账号" placeholder="账号" v-model="user.username" disabled></mt-field>
		<mt-field label="手机" placeholder="手机" v-model="user.mobile" disabled></mt-field>
		<mt-field label="微信" placeholder="微信" v-model="user.wechat"></mt-field>
		<mt-field label="地址" placeholder="地址" v-model="user.address"></mt-field>
		<mt-field label="注册时间" placeholder="注册时间" v-model="user.created_at" disabled></mt-field>
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
				user:{
					name: '',
					avatar: '',
					wechat: '',
					address: ''
				},
			}
		},
		created() {
			window.axios.get('user').then(response => {
				this.user = response.data;
			});
		},
		methods: {
			onSubmit: function () {
				window.axios.patch('user',{
					name:this.user.name,
					avatar:this.user.avatar,
					wechat:this.user.wechat,
					address:this.user.address
				}).then(response => {
					Toast('修改成功');
					this.user = response.data;
				}).catch(error => {
					Toast(error.response.data.message);
				})
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 200);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				axios.post('upload', formData).then(response => {
					this.user.avatar = response.data.path;
				}).catch(error => {
					Toast(error.response.data.message);
				});
			},
		}
	}
</script>

<style scoped>
	.mt-button {
		margin-top: 10px;
		padding-top: 8px;
	}
</style>