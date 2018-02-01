<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="trading">正在交易</mt-tab-item>
			<mt-tab-item id="has_been_completed">已经完成</mt-tab-item>
		</mt-navbar>
		<mt-loadmore :top-method="getOrders" :bottom-method="getOrders" :bottom-all-loaded="allLoaded">
			<div class="table table-dark table-responsive-sm">
				<thead>
					<tr>
						<th scope="col">商品名称</th>
						<th scope="col">创建时间</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="order in orders">
						<th scope="row">{{ order.goods_name }}</th>
						<th scope="row">{{ order.created_at }}</th>
					</tr>
				</tbody>
			</div>
		</mt-loadmore>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				orders: {},
				loading: false,
				allLoaded: false,
				selected: 'trading',
				pagination: {
					total_pages: 1,
					current_page: 0
				}
			}
		},
		created() {
			this.getOrders(1);
		},
		methods:{
			getOrders:function (state) {
				if (this.pagination.total_pages > this.pagination.current_page)
				{
					window.axios.get('orders',{
						params:{
							state:state,
							page:++this.pagination.current_page
						}
					}).then(response => {
						let data = {};
						for (let index in response.data.data) {
							data[response.data.data[index].id] = response.data.data[index];
						}
						let new_data ={};
						Object.assign(new_data,this.orders,data);
						this.orders = new_data;
						this.pagination = response.data.meta.pagination;
					});
				}
			}
		}
	}
</script>

<style scoped>

</style>