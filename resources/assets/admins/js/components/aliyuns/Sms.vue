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
					<label for="sign_name" class="col-sm-5 control-label">sign_name(ALIYUN_SMS_SIGN_NAME)</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" v-model="sign_name" id="sign_name" placeholder="sign_name">
					</div>
				</div>
				<div class="form-group">
					<label for="access_key_id" class="col-sm-5 control-label">access_key_id(ALIYUN_SMS_ACCESS_KEY_ID)</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" v-model="access_key_id" id="access_key_id"
						       placeholder="access_key_id">
					</div>
				</div>
				<div class="form-group">
					<label for="access_key_secret" class="col-sm-5 control-label">access_key_secret(ALIYUN_SMS_ACCESS_KEY_SECRET)</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" v-model="access_key_secret" id="access_key_secret"
						       placeholder="access_key_secret">
					</div>
				</div>
				<hr>
				<div class="form-group" style="margin: 10px;">
					<label for="send_code">send_code(ALIYUN_SMS_TEMPLATES_SEND_CODE)短信验证码模版(示例:您的验证码是：${code}，如非本人操作，请忽略本短信。)</label>
					<input type="text" class="form-control" v-model="templates.send_code" id="send_code" placeholder="send_code">
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-default" disabled>修改配置需要进入服务器网站根木目录的.env文件修改(默认/var/www/kipahouse.com/.env)</button>
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
				templates: {},
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			onSubmit: function () {
				window.axios.patch('sms', {
					sign_name: this.sign_name,
					access_key_id: this.access_key_id,
					access_key_secret: this.access_key_secret
				}).then(response => {
					this.alert_class = 'alert-success';
					this.alert_message = '保存成功';
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.message;
				});
			},
			getConfig: function () {
				window.axios.get('sms').then(response => {
					this.sign_name = response.data.sign_name;
					this.access_key_id = response.data.access_key_id;
					this.access_key_secret = response.data.access_key_secret;
					this.templates = response.data.templates;
				});
			},
		}
	}
</script>

<style scoped>

</style>