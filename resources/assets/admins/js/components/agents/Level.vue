<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">代理级别</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group" v-for="(item,index) in items">
					<div class="col-sm-offset-1 col-sm-8">
						<input type="text" class="form-control" v-model="item['name']" placeholder="级别名称">
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default btn-block" @click="deleteLevel(index)">删除级别
						</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">保存</button>
						<button type="button" class="btn btn-default" @click="addLevel()">添加</button>
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
				items: [],
				// alert_class:'',
				// alert_message: {},
			}
		},
		created() {
			this.getItems();
		},
		methods: {
			getItems: function () {
				axios.get('/config/agent_set').then(response => {
					this.items = response.data;
				}).catch(error => {
					console.log(error.response.data);
				});
			},
			onSubmit: function () {
				const formData = new FormData();
				formData.append('_method', 'PATCH');
				formData.append('name', 'agent_set');
				if (Array.isArray(this.items)) {
					this.items.forEach(function (item, index) {
						formData.append(`options[${index}][name]`, item.name);
					});
				}
				axios.post('/config', formData).then(response => {
					this.items = response.data.data;
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data;
				});
			},
			addLevel: function () {
				let item = new Array();
				item['name'] = '';
				this.items.push(item);
			},
			deleteLevel: function (index) {
				this.items.splice(index, 1);
			},
		}
	}
</script>

<style scoped>

</style>