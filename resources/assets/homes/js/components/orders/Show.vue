<template>
	<div class="card border-primary">
		<div class="card-header text-center">
			订单详情
		</div>
		<div class="card-body">
			<img :src="order.goods_image" class="img-thumbnail">
			<p>商品名称：{{ order.goods_name }}</p>
			<p>商品数量：{{ order.goods_number }}</p>
			<p>商品总价：{{ order.goods_total_price }}</p>
			<p>订单编号：{{ order.order_no }}</p>
			<p>创建时间：{{ order.created_at }}</p>
			<p>快递公司：{{ order.courier_company }}</p>
			<p>快递单号：{{ order.courier_order_no }}</p>
			<button type="button" class="btn btn-primary btn-block" @click="confirmReceipt(order.id)" v-show="order.state == 1">确认收货</button>
			<button type="button" class="btn btn-default btn-block" v-show="order.state == 2" disabled>已经收货</button>
		</div>
		<div class="card-header text-center">
			物流状态
		</div>
		<mt-spinner type="fading-snake" color="yellow" v-show="show_courier"></mt-spinner>
		<ul class="list-group list-group-flush" >
			<li class="list-group-item" v-for="item in courier.result.list" v-show="courier.status == 0 && !show_courier">
				<p>{{ item.time }}</p>
				<p>{{ item.status }}</p>
			</li>
			<li v-show="courier.status != 0 && !show_courier" class="list-group-item text-center">
				{{ courier.msg }}
			</li>
		</ul>
		
		<div class="card-footer text-muted">
			<router-link :to="{ name : 'orders' }" type="button" class="btn btn-outline-secondary btn-block"
			             tag="button">返回
			</router-link>
		</div>
	</div>
</template>

<script>
	import { MessageBox,Toast } from 'mint-ui';
	export default {
		data() {
			return {
				order: {},
				courier: {
					msg: '没有信息',
					result: {
						list: {}
					},
					status: 205,
				},
				show_courier: true,
			}
		},
		created() {
			window.axios.get('orders/' + this.$route.params.order).then(response => {
				this.order = response.data;
				this.getCourier(this.order.courier_order_no);
			});
		},
		methods: {
			getCourier:function (courier_order_no) {
				window.axios.get('couriers/'+courier_order_no).then(response => {
					this.show_courier = false;
					this.courier = response.data;
				}).catch(error => {
					this.show_courier = false;
					this.courier.msg = error.response.data.message;
				});
			},
			confirmReceipt:function (order) {
				MessageBox.confirm('确定执行此操作?').then(action => {
					window.axios.patch('orders/'+order,{
						state:2
					}).then(response => {
						Toast({message: '操作成功'});
						this.order = response.data;
						this.getCourier(this.order.courier_order_no);
					}).catch(error => {
						Toast({message: error.response.message});
					});
				},order);
			}
		}
	}
</script>

<style scoped>

</style>