<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">代理级别</h3>
		</div>
		<div class="panel-body">
			<div class="alert alert-info" v-for="(message,index) in messages" v-show="message" v-if="messages">
				<button type="button" class="close" @click="messages[index] = false">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ message }}
			</div>
			<div class="col-md-6">
				<table class="table table-hover">
					<thead>
					<tr>
						<th>名称</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in levels">
						<td>{{ item.name }}</td>
						<td>
							<button type="submit" class="btn btn-default" @click="deleteLevel(item.id)">删除</button>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<form class="form-horizontal" v-on:submit.prevent="onSubmit">
					<div class="form-group">
						<input type="text" class="form-control" v-model="name" placeholder="级别名称">
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="submit" class="btn btn-default">添加</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				name: '',
				levels: [],
				messages: {
					name: '',
					message: ''
				},
			}
		},
		created() {
			this.getItems();
		},
		methods: {
			getItems: function () {
				window.axios.get('levels').then(response => {
					this.levels = response.data.data;
				});
			},
			onSubmit: function () {
				axios.post('levels', {name:this.name}).then(response => {
					this.getItems();
				}).catch(error => {
					if (error.response.status == 422) {
						for (let index in error.response.data.errors) {
							this.messages[index] = error.response.data.errors[index][0];
						}
					}else {
						this.messages.message = error.response.data.message;
					}
				});
			},
			deleteLevel: function (level) {
				window.axios.delete('levels/'+level).then(response => {
					this.getItems();
				}).catch(error => {
					if (error.response.status == 422) {
						for (let index in error.response.data.errors) {
							this.messages[index] = error.response.data.errors[index][0];
						}
					}else {
						this.messages.message = error.response.data.message;
					}
				});
			},
		}
	}
</script>

<style scoped>

</style>