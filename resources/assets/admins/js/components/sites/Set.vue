<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">网站logo及版权设置</h3>
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
					<div class="col-sm-offset-1 col-sm-8">
						<label class="help-block" for="logo_file">选择网站logo图片(150x50)</label>
						<input type="file" id="logo_file" class="form-control" @change="uploadImg($event)">
						<img :src="logo_url" v-show="logo_url" class="img-thumbnail">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
						<label class="help-block" for="copyright">网站版权信息设置</label>
						<textarea class="form-control" id="copyright" v-model="copyright" cols="30" rows="1" placeholder="网站版权信息设置"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">保存</button>
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
				logo_url: '',
				copyright: '',
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			getConfig: function () {
				axios.get('/config/sites').then(response => {
					this.setData(response.data);
				});
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 150);
				formData.append('height', 50);
				formData.append('img', event.target.files[0]);
				axios.post('/upload', formData).then(response => {
					this.logo_url = response.data;
				}).catch(error => {
					console.log(error.response.data);
				});
			},
			onSubmit: function () {
				const formData = new FormData();
				formData.append('_method', 'PATCH');
				formData.append('name', 'sites');
				formData.append('options[logo_url]', this.logo_url);
				formData.append('options[copyright]', this.copyright);
				axios.post('/config', formData).then(response => {
					this.setData(response.data.data);
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			},
			setData: function (data) {
				this.logo_url = data.logo_url;
				this.copyright = data.copyright;
			}
		}
	}
</script>

<style scoped>

</style>