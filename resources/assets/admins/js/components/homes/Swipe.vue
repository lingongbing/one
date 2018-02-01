<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">首页轮播图设置</h3>
		</div>
		<div class="panel-body">
			<div class="alert" :class="alert_class" role="alert" v-show="alert_message">
				<button type="button" class="close" @click="alert_message = ''">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ alert_message }}
			</div>
			<div class="col-md-6">
				<form class="form-horizontal" v-on:submit.prevent="addCarousel">
					<div class="form-group">
						<label for="link" class="col-sm-2 control-label">链接</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" v-model="link" id="link" placeholder="链接">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">图片(420x200)</label>
						<div class="col-sm-10">
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
					<tr v-for="item in carousels">
						<td width="200"><img :src="item.image" class="img-thumbnail"></td>
						<td>{{ item.link }}</td>
						<td width="100"><button class="btn btn-default" @click="deleteCarousel(item.id)">删除</button></td>
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
				carousel: {},
				carousels: {},
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getCarousels();
		},
		methods: {
			getCarousels: function () {
				window.axios.get('carousels').then(response => {
					this.carousels = response.data.data;
				});
			},
			addCarousel:function () {
				let params = {};
				if (this.link) {
					params.link = this.link;
				}
				if (this.image) {
					params.image = this.image;
				}
				window.axios.post('carousels',params).then(response => {
					this.getCarousels();
					this.alert_class = 'alert-success';
					this.alert_message = '创建成功';
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.message;
				});
			},
			deleteCarousel: function (carousel) {
				window.axios.delete('carousels/'+carousel).then(response => {
					this.getCarousels();
					this.alert_class = 'alert-success';
					this.alert_message = '删除成功';
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.message;
				});
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'image');
				formData.append('width', '420');
				formData.append('height', '200');
				formData.append('image', event.target.files[0]);
				axios.post('/upload', formData).then(response => {
					this.image = response.data.path;
				});
			},
		}
	}
</script>

<style scoped>

</style>