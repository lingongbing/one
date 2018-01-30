<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">菜单栏设置</h3>
		</div>
		<div class="panel-body">
			<div class="alert" :class="alert_class" role="alert" v-show="alert_message">
				<button type="button" class="close" @click="alert_message = ''">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ alert_message }}
			</div>
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group" v-for="menu in menus">
					<div class="col-sm-offset-1 col-sm-4">
						<input type="text" class="form-control" v-model="menu.name" placeholder="菜单名称">
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default btn-block" @click="updateMenu(menu.id,menu.name)">
							修改菜单
						</button>
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
				menus: {},
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getMenus();
		},
		methods: {
			getMenus: function () {
				axios.get('/menus').then(response => {
					this.menus = response.data.data;
				}).catch(error => {

				});
			},
			updateMenu: function (id,name) {
				window.axios.patch('/menus/'+id,{
					name:name
				}).then(response => {
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			}
		}
	}
</script>

<style scoped>

</style>