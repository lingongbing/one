<template>
	<form class="form-horizontal" v-on:submit.prevent="onSubmit">
		<div class="alert alert-info" v-for="(message,index) in messages" v-show="message">
			<button type="button" class="close" @click="messages[index] = false">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ message }}
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">账号</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="username" name="username"
				       placeholder="账号" v-validate data-vv-rules="required|unique_username" data-vv-as="登陆账号">
				<span class="help-block" v-show="errors.has('username')">{{ errors.first('username') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">密码</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" v-model="password" name="password"
				       placeholder="密码" v-validate data-vv-rules="required" data-vv-as="密码">
				<span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">密码</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" v-model="confirmed_password" name="confirmed_password"
				       placeholder="确认密码" v-validate data-vv-rules="required|confirmed:password" data-vv-as="确认密码">
				<span class="help-block" v-show="errors.has('confirmed_password')">{{ errors.first('confirmed_password') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">头像</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" name="avatar" v-validate data-vv-rules="mimes:image/*"
				       data-vv-as="头像" @change="uploadImg($event)">
				<span class="help-block" v-show="errors.has('avatar')">{{ errors.first('avatar') }}</span>
				<img :src="avatar" v-show="avatar" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">姓名</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="name" name="name" placeholder="姓名"
				       v-validate data-vv-rules="required" data-vv-as="姓名">
				<span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">手机</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="mobile" name="mobile" placeholder="手机"
				       v-validate data-vv-rules="required|mobile|unique_mobile" data-vv-as="手机">
				<span class="help-block" v-show="errors.has('mobile')">{{ errors.first('mobile') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">微信</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="wechat" name="wechat" placeholder="微信"
				       v-validate
				       data-vv-rules="required" data-vv-as="微信">
				<span class="help-block" v-show="errors.has('wechat')">{{ errors.first('wechat') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">地区</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="region" name="region" placeholder="地区"
				       v-validate
				       data-vv-rules="required" data-vv-as="地区">
				<span class="help-block" v-show="errors.has('region')">{{ errors.first('region') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">地址</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="address" name="address" placeholder="地址"
				       v-validate
				       data-vv-rules="required" data-vv-as="地址">
				<span class="help-block" v-show="errors.has('address')">{{ errors.first('address') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">创建</button>
				<button type="submit" class="btn btn-default" @click="showSkin">创建(皮肤信息)</button>
			</div>
		</div>
	</form>
</template>

<script>
	export default {
		data() {
			return {
				name: '',
				wechat: '',
				mobile: '',
				avatar: '',
				region: '',
				user_id: 0,
				address: '',
				username: '',
				password: '',
				confirmed_password: '',
				messages: {
					name: '',
					wechat: '',
					mobile: '',
					region: '',
					message: '',
					username: '',
					password: '',
				},
			}
		},
		created() {

		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						axios.post('clients', {
							name: this.name,
							wechat: this.wechat,
							mobile: this.mobile,
							avatar: this.avatar,
							region: this.region,
							address: this.address,
							username: this.username,
							password: this.password,
						}).then(response => {
							this.$emit("set_user_id",response.data.id);
							this.messages.message = response.data.message;
						}).catch(error => {
							if (error.response.status === 422)
							{
								for (let index in error.response.data.errors)
								{
									this.messages[index] = error.response.data.errors[index][0];
								}
							}
						});
					}
				});
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 200);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				axios.post('upload', formData).then(response => {
					this.avatar = response.data.path;
				}).catch(error => {
					console.log(error.response.data);
				});
			},
			showSkin:function () {
				this.$emit("show_skin",true);
			}
		},
	}
</script>

<style scoped>

</style>