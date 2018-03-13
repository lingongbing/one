<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="integral_exchange">积分兑换</mt-tab-item>
			<mt-tab-item id="integral_query">积分查询</mt-tab-item>
		</mt-navbar>
		<div v-show="lists">
			<mt-cell title="剩余积分:" :value="user.integral"></mt-cell>
			<ul class="list-group">
				<li class="list-group-item" v-for="(item,index) in integral_orders" @click="showOrder(index),lists = false,show = true">{{ item.good.name }}</li>
			</ul>
		</div>
		<div v-show="show" style="margin-top: 10px;">
			<div class="card">
				<div class="card-body">
					<p class="card-text">商品名称：<span>{{ order.good.name }}</span></p>
					<p class="card-text">兑换数量：<span>{{ order.number }}</span></p>
					<p class="card-text">兑换积分：<span>{{ order.integral }}</span></p>
					<p class="card-text">收货人： <span>{{ order.consignee }}</span><br></p>
					<p class="card-text">手机号：<span>{{ order.phone }}</span><br></p>
					<p class="card-text">收货地址：<span>{{ order.province }},{{ order.city }},{{ order.area }},{{ order.address }}</span></p>
					<p class="card-text">订单状态：<span>{{ order.state == 1 ? '未发货' : '已发货'}}</span></p>
					<p class="card-text">兑换时间：<span>{{ order.created_at }}</span></p>
					<p class="card-text">更新时间：<span>{{ order.updated_at }}</span></p>
					<p class="card-text" v-show="order.courier_order_no">快递单号：<span>{{ order.courier_order_no }}</span></p>
					<ul class="list-group" v-show="order.courier_order_no">
						<li class="list-group-item" v-for="item in express_status.result.list">
							{{ item.time }} {{ item.status }}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {},
				order: {
					good: {
						name: '',
					},
					number: '',
					integral: '',
					consignee: '',
					phone: '',
					province: '',
					city: '',
					area: '',
					address: '',
					state: '',
					created_at: '',
					updated_at: '',
					courier_order_no: '',
				},
				express_status: {
					result: {
						list: {},
					}
				},
				show: false,
				lists: true,
				integral_orders: {},
				integral_records: {},
				selected: 'integral_query',
			}
		},
		watch: {
			selected:function () {
				switch (this.selected) {
					case 'integral_exchange':
						this.$router.push({name: 'integrals-exchange'});
						break;
					case 'integral_query':
						this.$router.push({name: 'integrals-query'});
						break;
				}
			},
			order:function () {
				if (this.order.courier_order_no) {
					this.queryCourier();
				}
			}
		},
		created() {
			window.axios.get('user/integral').then(response => {
				this.integral_records = response.data.data;
			});
			
			window.axios.get('user').then(response => {
				this.user = response.data;
			});
			
			window.axios.get('integral-orders').then(response => {
				this.integral_orders = response.data.data;
			});
		},
		methods:{
			showOrder:function (index) {
				this.order = this.integral_orders[index];
			},
			queryCourier: function () {
				window.axios.get('couriers/' + this.order.courier_order_no).then(response => {
					this.express_status = response.data;
				})
			}
		}
	}
</script>

<style scoped>

</style>