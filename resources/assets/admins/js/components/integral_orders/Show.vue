<template>
	<div>
		<div class="panel panel-default">
			<div class="panel-body">
				<p>商品名称：<span>{{ order.good.name }}</span></p>
				<p>兑换数量：<span>{{ order.number }}</span></p>
				<p>兑换账号：<span>{{ order.user.username }}</span></p>
				<p>兑换积分：<span>{{ order.integral }}</span></p>
				<p>剩余积分：<span>{{ order.user.integral }}</span></p>
				<p>收货人： <span>{{ order.consignee }}</span><br></p>
				<p>手机号：<span>{{ order.phone }}</span><br></p>
				<p>收货地址：<span>{{ order.province }},{{ order.city }},{{ order.area }},{{ order.address }}</span></p>
				<p>订单状态：<span>{{ order.state == 1 ? '未发货' : '已发货'}}</span></p>
				<p>兑换时间：<span>{{ order.created_at }}</span></p>
				<p>更新时间：<span>{{ order.updated_at }}</span></p>
			</div>
		</div>
		<div class="panel panel-default" v-show="order.state == 1">
			<div class="panel-body">
				<div class="alert alert-info" role="alert" v-show="messages.courier_order_no">
					<button type="button" class="close" aria-label="Close" @click="messages.courier_order_no = false"><span aria-hidden="true">&times;</span></button>
					{{ messages.courier_order_no }}
				</div>
				<input type="text" class="form-control" placeholder="快递单号" v-model="order.courier_order_no">
				<button class="btn btn-default" @click="updateOrder()">输入快递单号并设置为已发货</button>
			</div>
		</div>
		<div class="panel panel-default"
		     v-if="order.courier_order_no && express_status.status == 0 && order.state == 2">
			<div class="panel-heading">{{ express_status.result.expName }} {{express_status.result.number}} {{
				express_status.result.issign == 1 ? '已签收' : '未签收' }}
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item" v-for="item in express_status.result.list">
						{{ item.time }} {{ item.status }}
					</li>
				</ul>
			</div>
		</div>
		<div class="panel panel-default" v-else-if="order.courier_order_no && order.state == 2">
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">
						{{ express_status.msg }}
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['integral_order_id'],
		watch: {
			integral_order_id: function () {
				this.express_status = {};
				if (this.integral_order_id > 0) {
					this.getOrder();
				}
			}
		},
		data() {
			return {
				order: {
					user: {},
					good: {}
				},
				messages: {
					courier_order_no: false
				},
				express_status: {
					result: {
						list: {},
					}
				}
			}
		},
		methods: {
			getOrder: function () {
				window.axios.get('integral-orders/' + this.integral_order_id).then(response => {
					this.order = response.data;
					if (this.order.courier_order_no) {
						this.queryCourier();
					}
				}).catch(error => {
					console.log(error.response.data.message);
				})
			},
			updateOrder: function () {
				window.axios.patch('integral-orders/' + this.integral_order_id, {
					courier_order_no: this.order.courier_order_no
				}).then(response => {
					this.order = response.data;
					if (this.order.courier_order_no) {
						this.queryCourier();
					}
				}).catch(error => {
					if (error.response.data.status_code != 422)
					{
						this.messages.courier_order_no = error.response.data.message;
					} else {
						this.messages.courier_order_no = error.response.data.errors.courier_order_no[0];
					}
				})
			},
			queryCourier: function () {
				window.axios.get('couriers/' + this.order.courier_order_no).then(response => {
					this.express_status = response.data;
				})
			}
		},
	}
</script>

<style scoped>
	span {
		color: red;
	}
</style>