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
			<form class="form-horizontal" v-on:submit.prevent="onSubmit" style="margin: 20px;">
				<div class="form-group">
					<a href="https://market.aliyun.com/products/56928004/cmapi021863.html?spm=5176.2020520132.101.5.qW2vLO#sku=yuncode1586300000" target="_blank">快递查询</a>
					<input type="text" class="form-control" v-model="kdi_app_code" id="AppCode" placeholder="快递查询app_code">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default" disabled>修改配置需要进入服务器网站根木目录的.env文件修改(默认/var/www/kipahouse.com/.env)</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				kdi_app_code: '',
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			getConfig: function () {
				window.axios.get('aliyuns/markets/kdi').then(response => {
					this.kdi_app_code = response.data.kdi_app_code;
				});
				
			}
		}
	}
</script>

<style scoped>

</style>