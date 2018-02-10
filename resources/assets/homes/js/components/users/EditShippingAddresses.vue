<template>
	<div>
		<mt-field label="收货人" placeholder="收货人" v-model="name"></mt-field>
		<mt-field label="手机号" placeholder="手机号" v-model="phone"></mt-field>
		<v-distpicker :province="province" :city="city" :area="area"></v-distpicker>
		<mt-field label="详细地址" placeholder="详细地址" type="textarea" rows="4" v-model="address"></mt-field>
		<mt-button type="primary" size="large" plain @click="createShippingAddress()">保存</mt-button>
		<hr>
		<ul class="list-group">
			<li class="list-group-item" v-for="shipping_address in shipping_addresses">
				收货人：<span><span>{{ shipping_address.name }}</span></span>，手机号：<span>{{ shipping_address.phone }}</span>，省：<span>{{ shipping_address.province }}</span>，
				市：<span>{{ shipping_address.city }}</span>，区：<span>{{ shipping_address.area }}</span>，详细地址：<span>{{ shipping_address.address }}</span>
				<mt-button class="mt-button" type="primary" size="small" plain @click="deleteShippingAddress(shipping_address.id)">删除</mt-button>
			</li>
		</ul>
	</div>
</template>

<script>
	import VDistpicker from 'v-distpicker'

	export default {
		components: {
			VDistpicker
		},
		data() {
			return {
				name: '',
				phone: '',
				province: '广东省',
				city: '广州市',
				area: '天河区',
				address: '',
				shipping_addresses: {}
			}
		},
		created() {
			this.getShippingAddresses();
		},
		methods: {
			getShippingAddresses: function () {
				window.axios.get('shipping-addresses').then(response => {
					this.shipping_addresses = response.data.data;
				})
			},
			createShippingAddress: function () {
				window.axios.post('shipping-addresses', {
					name: this.name,
					phone: this.phone,
					province: this.province,
					city: this.city,
					area: this.area,
					address: this.address,
				}).then(response => {
					this.getShippingAddresses();
				});
			},
			deleteShippingAddress: function (shipping_address) {
				window.axios.delete('shipping-addresses/'+shipping_address).then(response => {
					this.getShippingAddresses();
				})
			}
		},
	}
</script>

<style scoped>
	span {
		color: red;
	}
	.mt-button {
		margin-top: 10px;
		padding-top: 5px;
	}
</style>