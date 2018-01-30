<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">订单统计</h3>
		</div>
		<div class="panel-body">
			<div class="jumbotron text-center">
				<h1>已经完成的订单有{{ completed_count }}</h1>
				<h1>正在交易的订单有{{uncompleted_count}}</h1>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				completed_count:0,
				uncompleted_count:0
			}
		},
		created() {
			axios.get('/order-count').then(response => {
				this.completed_count = response.data.data.completed_count;
				this.uncompleted_count = response.data.data.uncompleted_count;
			})
		}
	}
</script>

<style scoped>

</style>