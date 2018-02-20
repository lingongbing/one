<template>
	<div class="card" style="width: 100%;">
		<div class="card-body">
			<h5 class="card-title">创建订单</h5>
			<h6 class="card-subtitle mb-2 text-muted">{{ good.name }}</h6>
			<hr>
			<div class="form-group">
				<label for="shipping_address">收货地址</label>
				<select class="form-control" id="shipping_address" v-model="selected_shipping_address">
					<option :value="index" v-for="(shipping_address,index) in shipping_addresses">{{ shipping_address.name }}，
						{{ shipping_address.phone }}，{{ shipping_address.province }}，{{ shipping_address.city }}，
						{{ shipping_address.area }}，{{ shipping_address.address }}
					</option>
				</select>
			</div>
			<div class="form-group">
				<label for="good_number">商品数量</label>
				<input type="number" class="form-control" id="good_number" placeholder="商品数量" v-model="number">
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block" @click="storeOrder()">确认下单(需要{{ number*good.integral }}积分)</button>
			</div>
		</div>
	</div>
</template>

<script>
	import VSelect from 'vue-select';
	import { Toast } from 'mint-ui';
	export default {
		components: {VSelect},
		props: ['good'],
		data() {
			return {
				shipping_addresses: {},
				selected_shipping_address: 0,
				number: 1,
			}
		},
		created() {
			window.axios.get('shipping-addresses').then(response => {
				this.shipping_addresses = response.data.data;
			})
		},
		methods: {
			storeOrder: function () {
				window.axios.post('integral-orders',{
					integral_good_id:this.good.id,
					number:this.number,
					consignee:this.shipping_addresses[this.selected_shipping_address].name,
					phone:this.shipping_addresses[this.selected_shipping_address].phone,
					province:this.shipping_addresses[this.selected_shipping_address].province,
					city:this.shipping_addresses[this.selected_shipping_address].city,
					area:this.shipping_addresses[this.selected_shipping_address].area,
					address:this.shipping_addresses[this.selected_shipping_address].address
				}).then(response => {
					Toast('兑换成功');
					this.$router.push({name:'home'});
				}).catch(error => {
					switch (error.response.data.status_code){
						case 422:
							Toast(error.response.data.errors[0][0]);
						default :
							Toast(error.response.data.message);
					}
				});
			}
		},
	}
</script>

<style scoped>
	.card {
		border-left: 0;
		border-right: 0;
	}
</style>