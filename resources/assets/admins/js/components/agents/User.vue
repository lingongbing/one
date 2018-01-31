<template>
	<form class="form-horizontal" v-on:submit.prevent="onSubmit()">
		<div class="alert alert-info" v-for="(message,index) in messages" v-show="message[0]">
			<button type="button" class="close" @click="messages[index] = {}">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ message[0] }}
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<input type="text" class="form-control" v-model="name" name="name" v-validate data-vv-rules="required|max:255"
				       data-vv-as="姓名" placeholder="姓名">
				<span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<input type="text" class="form-control" v-model="username" disabled>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<label class="help-block" for="img_file">上传头像</label>
				<input type="file" id="img_file" v-on="img_file" class="form-control" @change="uploadImg($event)">
				<img :src="avatar" v-show="avatar" name="avatar" class="img-thumbnail">
				<span class="help-block" v-show="errors.has('avatar')">{{ errors.first('avatar') }}</span>
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
						<input type="checkbox" v-model="home_management">
						首页管理权限
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<input type="text" class="form-control" v-model="mobile" name="mobile" v-validate data-vv-rules="required|phone"
				       data-vv-as="手机" placeholder="手机" disabled>
				<span class="help-block" v-show="errors.has('mobile')">{{ errors.first('mobile') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<input type="text" class="form-control" v-model="wechat" name="wechat" v-validate data-vv-rules="required|max:255"
				       data-vv-as="微信" placeholder="微信">
				<span class="help-block" v-show="errors.has('wechat')">{{ errors.first('wechat') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<textarea class="form-control" v-validate data-vv-rules="required|max:255" data-vv-as="简介"
				          v-model="introduction" name="introduction" cols="30" rows="3" placeholder="简介"></textarea>
				<span class="help-block" v-show="errors.has('introduction')">{{ errors.first('introduction') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<button type="submit" class="btn btn-default">保存</button>
			</div>
		</div>
	</form>
</template>

<script>
	export default {
		props: ['user_id'],
		data() {
			return {
				name: '',
				level: '',
				avatar: '',
				wechat: '',
				mobile: '',
				username: '',
				introduction: '',
				home_management: '',
				levels: {},
				img_file: '',
				messages: {},
				level_index: 0,
			}
		},
		created() {
			this.$validator.extend('phone', {
				getMessage: '手机号码不正确',
				validate: value => {
					return value.length == 11 && /^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(value)
				}
			});
			this.getLevels();
			this.showAgent();
		},
		watch: {
			user_id: function () {
				this.showAgent();
			}
		},
		methods: {
			showAgent: function () {
				this.resetUserData();
				window.axios.get('agents/' + this.user_id).then(response => {
					this.setUserData(response.data);
				});
			},
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						axios.patch('agents/' + this.user_id, {
							name: this.name,
							// mobile: this.mobile,
							wechat: this.wechat,
							introduction: this.introduction,
							level: this.level,
							avatar: this.avatar,
							is_home_management: this.home_management,
						}).then(response => {
							this.setUserData(response.data.data);
							this.messages = {'message': {0: response.data.message}};
						}).catch(error => {
							if (error.response.status === 422) {
								this.messages = error.response.data.errors;
							}
							this.messages = {'message': {0: '请求失败,服务器错误'}};
						})
					}
					console.log(this.errors);
				});
			},
			setUserData: function (data) {
				this.name = data.name;
				this.level = data.level;
				this.avatar = data.avatar;
				this.wechat = data.wechat;
				this.mobile = data.mobile;
				this.username = data.username;
				this.introduction = data.introduction;
				this.home_management = data.home_management;
			},
			getLevels: function () {
				window.axios.get('levels').then(response => {
					this.levels = response.data.data;
					this.changeLevel();
				});
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 200);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				window.axios.post('upload', formData).then(response => {
					this.avatar = response.data;
				}).catch(error => {
					console.log(error.response.data);
				});
			},
			resetUserData: function () {
				for (const key in this.user) {
					this.user[key] = '';
				}
			},
			changeLevel: function () {
				this.level = this.levels[this.level_index].name;
			},
		}
	}
</script>

<style scoped>
	input[type=file] {
		display: none;
	}
</style>