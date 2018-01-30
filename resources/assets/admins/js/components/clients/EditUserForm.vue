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
				<input type="text" class="form-control" v-model="user.username" name="username" disabled>
				<span class="help-block" v-show="errors.has('username')">{{ errors.first('username') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">密码</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" v-model="user.password" name="password" placeholder="留空不修改"
				       data-vv-as="密码">
				<span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">密码</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" v-model="user.confirmed_password" name="confirmed_password"
				       v-validate data-vv-rules="confirmed:password" data-vv-as="确认密码" placeholder="留空不修改">
				<span class="help-block" v-show="errors.has('confirmed_password')">{{ errors.first('confirmed_password') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">头像</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" name="avatar" v-validate data-vv-rules="mimes:image/*"
				       data-vv-as="头像" @change="uploadImg($event)">
				<span class="help-block" v-show="errors.has('avatar')">{{ errors.first('avatar') }}</span>
				<img :src="user.avatar" v-show="user.avatar" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">姓名</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="user.name" name="name"
				       v-validate data-vv-rules="required" data-vv-as="姓名">
				<span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">手机</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="user.mobile" name="mobile" v-validate
				       data-vv-rules="required|mobile" data-vv-as="手机">
				<span class="help-block" v-show="errors.has('mobile')">{{ errors.first('mobile') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">微信</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="user.wechat" name="wechat"
				       v-validate data-vv-rules="required" data-vv-as="微信">
				<span class="help-block" v-show="errors.has('wechat')">{{ errors.first('wechat') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">地区</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="user.region" name="region"
				       v-validate data-vv-rules="required" data-vv-as="地区">
				<span class="help-block" v-show="errors.has('region')">{{ errors.first('region') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">地址</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" v-model="user.address">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">保存</button>
			</div>
		</div>
	</form>
</template>

<script>
	export default {
		props: [
			'user_id'
		],
		data() {
			return {
				user: {
					name: '',
					mobile: '',
					region: '',
					avatar: '',
					wechat: '',
					address: '',
					username: '',
					password: '',
				},
				messages: {
					name: '',
					avatar: '',
					wechat: '',
					region: '',
					message: '',
					password: '',
				},
			}
		},
		watch: {
			user_id: function () {
				this.user.name = '';
				this.user.mobile = '';
				this.user.region = '';
				this.user.avatar = '';
				this.user.wechat = '';
				this.user.address = '';
				this.user.username = '';
				this.user.password = '';
				if (this.user_id) {
					this.getUser(this.user_id);
				}
			},
			level_index: function () {
				this.user.level = this.levels[this.level_index].name;
			}
		},
		methods: {
			getUser(user_id) {
				axios.get('/client/' + user_id + '/edit').then(response => {
					this.user = response.data.data;
				})
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 200);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				axios.post('/upload', formData).then(response => {
					this.user.avatar = response.data;
				});
			},
			onSubmit() {
				this.$validator.validateAll().then(result => {
					if (result) {
						axios.patch('/client/' + this.user_id, {
							name: this.user.name,
							avatar: this.user.avatar,
							region: this.user.region,
							wechat: this.user.wechat,
							mobile: this.user.mobile,
							address: this.user.address,
							password: this.user.password,
						}).then(response => {
							this.messages.message = response.data.message;
						}).catch(error => {
							if (error.response.status === 422) {
								for (let index in error.response.data.errors) {
									this.messages[index] = error.response.data.errors[index][0];
								}
							}
						});
					}
				});
			}
		}
	}
</script>

<style scoped>

</style>