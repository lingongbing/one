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
				<div class="form-group" v-for="(menu,index) in menus">
					<div class="col-sm-offset-1 col-sm-4">
						<input type="text" class="form-control" v-model="menu.name" placeholder="菜单名称">
					</div>
					<div class="col-sm-2">
						<label class="btn btn-default" :for="`icon-${index}`">选择图标(24x24)</label>
						<input type="file" style="display: none;" :id="`icon-${index}`" @change="uploadImg($event,index)">
						<img :src="menu.icon" v-show="menu.icon">
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default btn-block" @click="updateMenu(menu.id,menu.name,menu.icon)">
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
			updateMenu: function (id,name,icon) {
				window.axios.patch('/menus/'+id,{
					name:name,
					icon:icon
				}).then(response => {
					this.alert_class = 'alert-success';
					this.alert_message = response.data.message;
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			},
			uploadImg: function (event,index) {
				let formData = new FormData();
				formData.append('key', 'image');
				formData.append('width', '24');
				formData.append('height', '24');
				formData.append('image', event.target.files[0]);
				axios.post('upload', formData).then(response => {
					this.menus[index].icon = response.data.path;
				});
			},
		}
	}
</script>

<style scoped>

</style>