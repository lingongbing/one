<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">积分商品</h3>
		</div>
		<div class="panel-body">
			<button class="btn btn-default" @click="index = true,create = false,edit = false,image = false" v-show="!index">商品列表</button>
			<button class="btn btn-default" @click="create = true,index = false,edit = false,image = false" v-show="!create">添加商品</button>
			<hr>
			<div v-if="create">
				<create-form></create-form>
			</div>
			<div v-if="edit">
				<edit-form :good="good"></edit-form>
			</div>
			<div v-if="image">
				<image-form :good="good"></image-form>
			</div>
			<div v-if="index">
				<table class="table table-hover table-condensed">
					<thead>
					<tr>
						<th style="width: 40%;">商品名称</th>
						<th style="width: 20%;">售卖积分</th>
						<th style="width: 40%;">操作</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in goods">
						<td>{{ item.name }}</td>
						<td>{{ item.integral }}</td>
						<td>
							<button class="btn btn-info" @click="image = true,index = false,create = false,edit = false,good = item.id">商品图片</button>
							<button class="btn btn-warning"
							        @click="edit = true,index = false,create = false,good = item.id,image = false">编辑商品
							</button>
							<button class="btn btn-danger" @click="deleteGood(item.id)">删除商品</button>
						</td>
					</tr>
					</tbody>
					<tfoot>
					<tr class="text-center">
						<td colspan="10">
							<nav aria-label="...">
								<ul class="pager">
									<li v-show="pagination.links.previous" @click="getGoods(--pagination.current_page)">
										<a href="javascript:;">Previous</a>
									</li>
									<li v-show="pagination.links.next" @click="getGoods(++pagination.current_page)">
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
	import CreateForm from './CreateForm';
	import EditForm from './EditForm';
	import ImageForm from './ImageForm';

	export default {
		components: {CreateForm, EditForm,ImageForm},
		data() {
			return {
				good: 0,
				goods: {},
				edit: false,
				index: true,
				image: false,
				create: false,
				pagination: {
					links: {
						next: false,
						previous: false
					},
					current_page: 1
				},
			}
		},
		created() {
			this.getGoods();
		},
		methods: {
			getGoods: function (page = null) {
				window.axios.get('integral-goods', {
					params: {
						page: page
					}
				}).then(response => {
					this.goods = response.data.data;
					this.pagination = response.data.meta.pagination;
				})
			},
			deleteGood: function (good) {
				window.axios.delete('integral-goods/' + good).then(response => {
					this.getGoods(this.pagination.current_page);
				})
			}
		}
	}
</script>

<style scoped>

</style>