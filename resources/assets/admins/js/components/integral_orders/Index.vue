<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">积分订单</h3>
		</div>
		<div class="panel-body">
			<button class="btn btn-default" v-show="show" @click="index = true,show = false">返回订单列表</button>
			<hr>
			<table class="table table-hover table-condensed" v-show="index">
				<thead>
				<tr>
					<th>兑换账号</th>
					<th>商品名称</th>
					<th>兑换数量</th>
					<th>兑换积分</th>
					<th>兑换时间</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="item in orders">
					<td>{{ item.user.username }}</td>
					<td>{{ item.good.name }}</td>
					<td>{{ item.number }}</td>
					<td>{{ item.integral }}</td>
					<td>{{ item.created_at }}</td>
					<td>
						<button class="btn btn-default" @click="index = false,show = true,integral_order_id = item.id">查看详细</button>
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
			<show :integral_order_id="integral_order_id" v-show="show"></show>
		</div>
	</div>
</template>

<script>
	import Show from './Show';
	export default {
		components: {
			Show
		},
		data() {
			return {
				integral_order_id: 0,
				show:false,
				index:true,
				orders: {},
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
			this.getOrders(this.pagination.current_page);
		},
		methods: {
			getOrders:function (page) {
				window.axios.get('integral-orders',{
					params:{
						page:page
					}
				}).then(response => {
					this.orders = response.data.data;
					if (response.data.meta.length) {
						this.pagination = response.data.meta;
					}
				}).catch(error => {
				
				});
			}
		}
	}
</script>

<style scoped>

</style>