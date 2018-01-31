<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" v-show="this.$route.params.state == 1">正在交易的订单</h3>
			<h3 class="panel-title" v-show="this.$route.params.state == 2">已经完成的订单</h3>
		</div>
		<div class="panel-body">
			<div class="alert alert-info" v-for="(message,index) in messages" v-show="message" v-if="messages">
				<button type="button" class="close" @click="messages[index] = false">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ message }}
			</div>
			<div class="col-md-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" class="form-control" v-model="params.order_no" @change="getOrders(paginate.current_page)" placeholder="输入订单号查询">
						<input type="text" class="form-control" v-model="params.courier_order_no" @change="getOrders(paginate.current_page)" placeholder="输入快递单号查询">
						<!--<input type="text" class="form-control" v-model="params.name" @change="getOrders(paginate.current_page)" placeholder="输入客户姓名查询">-->
						<!--<input type="text" class="form-control" v-model="params.goods_name" @change="getOrders(paginate.current_page)" placeholder="输入商品名称查询">-->
					</div>
				</div>
				<hr>
				<table class="table table-hover">
					<thead>
					<tr>
						<th><input type="checkbox" v-model="checked" @click="checkedAll"></th>
						<th>订单号</th>
						<th>快递单号</th>
						<th>客户姓名</th>
						<th>商品名称</th>
						<th>商品数量</th>
						<th>商品总价(以分为单位)</th>
						<th>快递公司</th>
						<th>创建时间</th>
						<th>状态</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="item in orders">
						<td><input type="checkbox" v-model="checkboxModel" :value="item.id"></td>
						<td>{{ item.order_no }}</td>
						<td>{{ item.courier_order_no }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.goods_name }}</td>
						<td>{{ item.goods_number }}</td>
						<td>{{ item.goods_total_price }}</td>
						<td>{{ item.courier_company }}</td>
						<td>{{ item.created_at }}</td>
						<td>
							<button v-if="item.state == 1" class="btn btn-default btn-sm" @click="updateState(item.id,2)">设成已经完成</button>
							<button v-if="item.state == 2" class="btn btn-success btn-sm">已经完成</button>
						</td>
					</tr>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="10">
							<button class="btn btn-danger" @click="deleteOrder">删除选中</button>
						</td>
					</tr>
					<tr class="text-center">
						<td colspan="10">
							<nav aria-label="...">
								<ul class="pager">
									<li v-show="paginate.prev_page_url" @click="getOrders(--paginate.current_page)">
										<a href="javascript:;">Previous</a>
									</li>
									<li v-show="paginate.next_page_url" @click="getOrders(++paginate.current_page)">
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
				state: this.$route.params.state,
				orders: {},
				paginate: {
					current_page: 1,
					prev_page_url: '',
					next_page_url: '',
				},
				params: {
					page: 1,
					// name: '',
					order_no: '',
					// goods_name: '',
					courier_order_no: '',
					state: this.$route.params.state,
				},
				checked: false,
				checkboxModel: [],
				messages: {
					message: '',
				}
			}
		},
		watch:{
			'$route' (to) {
				this.state = to.params.state;
			},
			state:function () {
				this.params.state = this.state;
				this.paginate.current_page = 1;
				this.getOrders(this.paginate.current_page);
			},
		},
		created() {
			this.getOrders(this.paginate.current_page);
		},
		methods: {
			getOrders: function (page) {
				this.params.page = page;
				axios.get('orders', {params: this.params}).then(response => {
					this.orders = response.data.data;
					this.paginate.current_page = response.data.current_page;
					this.paginate.prev_page_url = response.data.prev_page_url;
					this.paginate.next_page_url = response.data.next_page_url;
				})
			},
			checkedAll: function () {
				if (!this.checked) {
					this.checkboxModel = [];
					for (let index in this.orders) {
						this.checkboxModel.push(this.orders[index].id);
					}
				}else {
					this.checkboxModel = [];
				}
			},
			deleteOrder: function () {
				this.checkboxModel.forEach(function (value,index) {
					axios.delete('orders/'+value).then(response => {
						if  (++index === this.checkboxModel.length) {
							this.getOrders(this.paginate.current_page);
							this.messages.message = response.data.message;
						}
					}).catch(error => {
						this.messages.message = error.response.data.message;
					});
				},this);
			},
			updateState: function (id,state) {
				axios.patch('orders/'+id, {state:state}).then(response => {
					this.getOrders(this.paginate.current_page);
					this.messages.message = response.data.message;
				})
			}
		}
	}
</script>

<style scoped>

</style>