<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">首页内容管理</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<form class="form-horizontal" v-on:submit.prevent="onSubmit()">
					<div class="form-group">
						<label for="link" class="col-sm-4 control-label">链接</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" v-model="link" id="link" placeholder="链接">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">图片(宽度420px)</label>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="form_image" v-validate data-vv-rules="required|mimes:image/*"
							       data-vv-as="图片" @change="uploadImg($event)">
							<span class="help-block" v-show="errors.has('form_image')">{{ errors.first('form_image') }}</span>
							<img :src="image" v-show="image" class="img-thumbnail">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">保存</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<table class="table table-hover">
					<thead>
					<tr>
						<th>图片</th>
						<th>链接</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in homes">
						<td width="360"><img :src="item.image" class="img-thumbnail"></td>
						<td><a :href="item.link">{{ item.link }}</a></td>
						<td><button class="btn btn-default btn-xs" @click="deleteHome(item.id)">删除</button></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				link: '',
				image: '',
				homes: {},
			}
		},
		created() {
			this.getHomes();
		},
		methods: {
			getHomes: function () {
				window.axios.get('homes').then(response => {
					this.homes = response.data.data;
				})
			},
			deleteHome: function (home) {
				window.axios.delete('homes/'+home).then(response => {
					this.getHomes();
				})
			},
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						axios.post('homes', {
							link:this.link,
							image:this.image
						}).then(response => {
							this.getHomes();
						});
					}
				});
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'image');
				formData.append('width', '420');
				formData.append('image', event.target.files[0]);
				window.axios.post('upload', formData).then(response => {
					this.image = response.data.path;
				});
			},
		}
	}
</script>

<style scoped>

</style>