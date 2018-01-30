<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">系统运行状态</h3>
		</div>
		<div class="panel-body">
			<p>系统类型:<strong>{{ system.system_type }}</strong></p>
			<p>系统版本:<strong>{{ system.system_version }}</strong></p>
			<p>服务器IP:<strong>{{ system.server_addr }}</strong></p>
			<p>服务器域名:<strong>{{ system.server_name }}</strong></p>
			<p>服务器端口:<strong>{{ system.server_port }}</strong></p>
			<p>服务器解译引擎:<strong>{{ system.server_software }}</strong></p>
			<p>PHP版本:<strong>{{ system.php_version }}</strong></p>
			<p>PHP运行方式:<strong>{{ system.php_sapi_name }}</strong></p>
			<p>Zend版本:<strong>{{ system.zend_version }}</strong></p>
			<p>当前系统时间:<strong>{{ system.server_date }}</strong></p>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				system:{},
			}
		},
		created() {
			axios.get('/system').then(response => {
				this.system = response.data;
			}).catch(error => {
				console.log('服务器错误');
			});
		},
	}
</script>

<style scoped>
	strong {
		color: red;
	}
</style>