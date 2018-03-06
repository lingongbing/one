<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="trading">正在交易</mt-tab-item>
			<mt-tab-item id="has_been_completed">已经完成</mt-tab-item>
		</mt-navbar>
		<mt-loadmore v-if="orders" :top-method="getOrders" :bottom-method="getOrders" :bottom-all-loaded="allLoaded">
			<div class="table table-responsive-sm">
				<thead>
					<tr>
						<th scope="col" style="width: 70%;">商品名称</th>
						<th scope="col" style="width: 30%;">创建时间</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="order in orders">
						<th scope="row">
							<router-link :to="{ name: 'orders-show', params:{order:order.id} }" tag="span">{{ order.goods_name }}</router-link>
						</th>
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
				state: 1,
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
		watch: {
			selected:function () {
				if (this.selected === 'trading') {
					this.state = 1;
				} else {
					this.state = 2;
				}
			},
			state:function () {
				this.orders = {};
				this.pagination.total_pages = 1;
				this.pagination.current_page = 0;
				this.getOrders();
			}
		},
		created() {
			this.getOrders();
		},
		methods:{
			getOrders:function () {
				if (this.pagination.total_pages > this.pagination.current_page)
				{
					window.axios.get('orders',{
						params:{
							state:this.state,
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
						this.pagination.total_pages = response.data.meta.pagination.total_pages;
						this.pagination.current_page = response.data.meta.pagination.current_page;
					});
				}
			}
		}
	}
</script>

<style scoped>

</style>