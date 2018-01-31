<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">新增代理</h3>
		</div>
		<div class="panel-body">
			<div class="alert alert-info" v-for="(message,index) in messages" v-show="message" v-if="messages">
				<button type="button" class="close" @click="messages[index] = false">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ message }}
			</div>
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="username" name="username" id="username"
						       placeholder="登陆账号"
						       v-validate data-vv-rules="required|unique_username" data-vv-as="登陆账号">
						<span class="help-block" v-show="errors.has('username')">{{ errors.first('username') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="password" class="form-control" v-model="password" name="password" id="password"
						       placeholder="密码"
						       v-validate data-vv-rules="required|min:6" data-vv-as="密码">
						<span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="password" class="form-control" name="confirmed_password" id="confirmed_password"
						       placeholder="确认密码"
						       v-validate data-vv-rules="required|confirmed:password" data-vv-as="确认密码">
						<span class="help-block" v-show="errors.has('confirmed_password')">{{ errors.first('confirmed_password') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<select class="form-control" v-model="level_index" id="level_index" name="level_index"
						        @change="changeLevel()">
							<option value="default" disabled>选择代理等级</option>
							<option v-bind:value="index" v-for="(item,index) in levels">{{ item.name }}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="home_management" v-model="home_management">
								首页管理权限
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<label class="help-block" for="img_file">上传头像</label>
						<input type="file" id="img_file" class="form-control" @change="uploadImg($event)">
						<img :src="img_url" v-show="img_url" class="img-thumbnail">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="name" name="name" id="name"
						       placeholder="姓名"
						       v-validate data-vv-rules="required" data-vv-as="姓名">
						<span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="mobile" name="mobile" id="mobile"
						       placeholder="手机号码"
						       v-validate data-vv-rules="required|mobile|unique_mobile" data-vv-as="手机号码">
						<span class="help-block" v-show="errors.has('mobile')">{{ errors.first('mobile') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="wechat" name="wechat" id="wechat"
						       placeholder="微信号" v-validate data-vv-rules="required" data-vv-as="微信号">
						<span class="help-block" v-show="errors.has('wechat')">{{ errors.first('wechat') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<textarea class="form-control" v-validate data-vv-rules="required" data-vv-as="简介" v-model="introduction"
						          name="introduction" id="" cols="30" rows="10" placeholder="简介"></textarea>
						<span class="help-block"
						      v-show="errors.has('introduction')">{{ errors.first('introduction') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">创建</button>
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
				name: '',
				mobile: '',
				wechat: '',
				username: '',
				password: '',
				introduction: '',
				level: '',
				levels: {},
				level_index: 0,
				home_management: false,
				img_url: '',
				messages: {
					message: '',
					name: '',
					mobile: '',
					wechat: '',
					username: '',
					password: '',
					introduction: '',
					level: '',
					avatar: ''
				},
			}
		},
		created() {
			this.getLevels();
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						const formData = new FormData();
						formData.append('name', this.name);
						formData.append('mobile', this.mobile);
						formData.append('wechat', this.wechat);
						formData.append('username', this.username);
						formData.append('password', this.password);
						formData.append('introduction', this.introduction);
						formData.append('level', this.level);
						formData.append('avatar', this.img_url);
						if (this.home_management) {
							formData.append('is_home_management', true);
						}
						window.axios.post('agents', formData).then(response => {
							this.messages.message = '创建成功';
						}).catch(error => {
							if (error.response.status == 422) {
								for (let index in error.response.data.errors) {
									this.messages[index] = error.response.data.errors[index][0];
								}
							}else {
								this.messages.message = error.response.data.message;
							}
						});
					}
				});
			},
			getLevels: function () {
				window.axios.get('levels').then(response => {
					this.levels = response.data.data;
					this.level = this.levels[this.level_index].name
				});
			},
			changeLevel: function () {
				this.level = this.levels[this.level_index].name;
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 200);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				window.axios.post('upload', formData).then(response => {
					this.img_url = response.data.path;
				}).catch(error => {
					this.messages.message = error.response.data.message;
				});
			},
		}
	}
</script>

<style scoped>
	img {
		width: 200px;
		height: 200px;
	}
</style>