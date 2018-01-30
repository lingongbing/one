<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">阿里云云市场快递查询设置</h3>
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
						<input type="text" class="form-control" v-model="app_code" id="AppCode" placeholder="app_code">
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
				app_code: '',
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			getConfig: function () {
				axios.get('/config/aliyun_kdi').then(response => {
					this.app_code = response.data.app_code;
				});
			},
			onSubmit: function () {
				axios.patch('/config', {
					name:'aliyun_kdi',
					options: {
						app_code : this.app_code,
					}
				}).then(response => {
					this.app_code = response.data.data.app_code;
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			},
		}
	}
</script>

<style scoped>

</style>