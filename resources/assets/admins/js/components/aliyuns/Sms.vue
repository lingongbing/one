<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">阿里云短信设置</h3>
		</div>
		<div class="panel-body">
			<div class="alert" :class="alert_class" role="alert" v-show="alert_message">
				<button type="button" class="close" @click="alert_message = ''">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ alert_message }}
			</div>
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="sign_name" id="sign_name"
						       placeholder="sign_name">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="access_key_id" id="access_key_id"
						       placeholder="access_key_id">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="access_key_secret" id="access_key_secret"
						       placeholder="access_key_secret">
					</div>
				</div>
				<div class="form-group" v-for="(template,index) in templates">
					<div class="col-sm-offset-1 col-sm-4">
						<input type="text" class="form-control" v-model="template['name']" placeholder="模版名称(不要用中文)">
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" v-model="template['code']" placeholder="模板CODE">
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default btn-block" @click="deleteTemplate(index)">删除模版
						</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">保存</button>
						<button type="button" class="btn btn-default" @click="addTemplate()">添加模版</button>
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
				sign_name: '',
				access_key_id: '',
				access_key_secret: '',
				templates: [],
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			addTemplate: function () {
				let item = new Array();
				item['name'] = '';
				item['code'] = '';
				this.templates.push(item);
			},
			deleteTemplate: function (index) {
				this.templates.splice(index, 1);
			},
			onSubmit: function () {
				const formData = new FormData();
				formData.append('_method', 'PATCH');
				formData.append('name', 'aliyun_sms');
				formData.append('options[sign_name]', this.sign_name);
				formData.append('options[access_key_id]', this.access_key_id);
				formData.append('options[access_key_secret]', this.access_key_secret);
				if (Array.isArray(this.templates))
				{
					this.templates.forEach(function (item, index) {
						formData.append(`options[templates][${index}][name]`, item.name);
						formData.append(`options[templates][${index}][code]`, item.code);
					});
				}
				axios.post('/config', formData).then(response => {
					this.setData(response.data.data);
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			},
			getConfig: function () {
				axios.get('/config/aliyun_sms').then(response => {
					this.setData(response.data);
				});
			},
			setData: function (data) {
				this.sign_name = data.sign_name;
				this.access_key_id = data.access_key_id;
				this.access_key_secret = data.access_key_secret;
				if (Array.isArray(data.templates))
				{
					this.templates = data.templates;
				}
			}
		}
	}
</script>

<style scoped>

</style>