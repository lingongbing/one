<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">商品列表</h3>
		</div>
		<div class="panel-body">
			<div class="alert alert-info" v-for="(message,index) in messages" v-show="message">
				<button type="button" class="close" @click="messages[index] = false">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ message }}
			</div>
			<div class="form-inline">
				<div class="form-group">
					<input type="text" class="form-control" v-model="params.name" @change="getGoods(paginate.current_page)" placeholder="输入商品名称查询">
				</div>
			</div>
			<hr>
			<div class="col-md-6">
				<form class="form-horizontal" v-on:submit.prevent="onSubmit">
					<div class="form-group">
						<label class="col-sm-2 control-label">商品图片</label>
						<div class="col-sm-10">
							<input type="file" class="form-control" name="form_image" v-validate data-vv-rules="required|mimes:image/*"
							       data-vv-as="商品图片" @change="uploadImg($event)">
							<span class="help-block" v-show="errors.has('form_image')">{{ errors.first('form_image') }}</span>
							<img :src="form.image" v-show="form.image" class="img-thumbnail">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">商品名称</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" v-model="form.name" name="form_name"
							       v-validate data-vv-rules="required" data-vv-as="商品名称" placeholder="商品名称">
							<span class="help-block" v-show="errors.has('form_name')">{{ errors.first('form_name') }}</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-success btn-block">添加</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<table class="table table-hover">
					<thead>
					<tr>
						<th><input type="checkbox" v-model="checked" @click="checkedAll"></th>
						<th>商品图片</th>
						<th>商品名称</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in goods">
						<td><input type="checkbox" v-model="checkboxModel" :value="item.id"></td>
						<td><img :src="item.image" class="img-thumbnail"></td>
						<td>{{ item.name }}</td>
					</tr>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="3">
							<button class="btn btn-danger" @click="deleteGoods">删除选中</button>
						</td>
					</tr>
					<tr class="text-center">
						<td colspan="3">
							<nav aria-label="...">
								<ul class="pager">
									<li v-show="paginate.prev_page_url" @click="getGoods(--paginate.current_page)">
										<a href="javascript:;">Previous</a>
									</li>
									<li v-show="paginate.next_page_url" @click="getGoods(++paginate.current_page)">
										<a href="javascript:;">Next</a>
									</li>
								</ul>
							</nav>
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				goods: {},
				params: {
					page: 1,
					name: '',
				},
				checked: false,
				checkboxModel: [],
				messages: {
					name: '',
					imahe: '',
					message: '',
				},
				paginate: {
					current_page: 1,
					prev_page_url: '',
					next_page_url: '',
				},
				form:{
					name:'',
					image: '',
				}
			}
		},
		created() {
			this.getGoods(this.paginate.current_page);
		},
		methods: {
			getGoods: function (page) {
				this.params.page = page;
				window.axios.get('goods', {params: this.params}).then(response => {
					this.goods = response.data.data;
					this.paginate.current_page = response.data.meta.pagination.current_page;
					if (response.data.meta.pagination.links) {
						this.paginate.prev_page_url = response.data.meta.pagination.links.previous;
						this.paginate.next_page_url = response.data.meta.pagination.links.next;
					}
					this.checked = false;
				})
			},
			checkedAll: function () {
				if (!this.checked) {
					this.checkboxModel = [];
					for (let index in this.goods) {
						this.checkboxModel.push(this.goods[index].id);
					}
				} else {
					this.checkboxModel = [];
				}
			},
			deleteGoods: function () {
				this.checkboxModel.forEach(function (value) {
					window.axios.delete('goods/' + value).then(response => {
						this.getGoods(this.paginate.current_page);
					}).catch(error => {
						this.messages.message = error.response.data.message;
					});
				}, this);
				if (this.checkboxModel.length) {
					this.getGoods(this.paginate.current_page);
				}
			},
			uploadImg: function (event) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 420);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				axios.post('/upload', formData).then(response => {
					this.form.image = response.data.path;
				}).catch(error => {
					console.log(error.response.data);
				});
			},
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						window.axios.post('goods', {
							name: this.form.name,
							image: this.form.image,
						}).then(response => {
							this.form.name = '';
							this.form.image = '';
							this.getGoods(this.paginate.current_page);
							this.messages.message = '添加成功';
						}).catch(error => {
							if (error.response.data.status_code === 422)
							{
								for (let index in error.response.data.errors)
								{
									this.messages[index] = error.response.data.errors[index][0];
								}
							} else {
								this.messages.message = error.response.data.message;
							}
						});
					}
				});
			}
		}
	}
</script>

<style scoped>
	img {
		width: 200px;
		height: 200px;
	}
</style>