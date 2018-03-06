<template>
	<div>
		<mt-navbar v-model="selected" class="mt-navbar">
			<mt-tab-item id="integral_exchange">积分兑换</mt-tab-item>
			<mt-tab-item id="integral_query">积分查询</mt-tab-item>
		</mt-navbar>
		<div class="row" v-if="items">
			<div class="card col-6" v-for="(item,index) in goods" v-if="item.images.length"
			     @click="items = false,show = true,good = item" style="padding: 0;">
				<img class="card-img-top" :src="item.images[0].image" style="margin-top: 10px;">
				<div class="card-body" style="padding: 0;">
					<span>{{ item.name }}</span>
				</div>
				<div class="text-muted">
					兑换积分：<span style="color: red;">{{ item.integral }}</span>
				</div>
				<div class="text-muted">
					市场参考价：<span style="color: red;">{{ item.reference_price }}</span>
				</div>
			</div>
		</div>
		<div class="row" v-if="show">
			<mt-swipe :show-indicators="false" class="mt-swipe">
				<mt-swipe-item v-for="(image,index) in good.images" :key="index">
					<img :src="image.image">
				</mt-swipe-item>
			</mt-swipe>
			<div class="card" style="width: 100%;">
				<div class="card-body" style="padding-top: 5px;">
					<span>商品名称：{{ good.name }}</span>
					<hr style="margin: 0;">
					兑换积分：<span style="color: red;">{{ good.integral }}</span> 市场参考价：<span style="color: red;">{{ good.reference_price }}</span>
					<hr style="margin: 0;">
					商品描述：<span style="color: #666666;">{{ good.description }}</span>
					<hr style="margin: 0;">
					商品详情：
					<div v-html="good.introduction"></div>
				</div>
			</div>
			<div class="fixed">
				<button class="btn btn-default" @click="items = true,show = false,good = {}" style="width: 50%;">返回
				</button>
				<button class="btn btn-warning" style="float: right;width: 50%;" @click="show = false,CreateOrder = true">我要兑换
				</button>
			</div>
		</div>
		<div class="row" v-if="CreateOrder">
			<create-order :good="good"></create-order>
		</div>
	</div>
</template>

<script>
	import CreateOrder from './CreateOrder'

	export default {
		components: {
			CreateOrder
		},
		data() {
			return {
				good: {},
				show: false,
				items: true,
				goods: {},
				selected: 'integral_exchange',
				CreateOrder: false,
				number: 1,
			}
		},
		watch: {
			selected: function () {
				switch (this.selected) {
					case 'integral_exchange':
						this.$router.push({name: 'integrals-exchange'});
						break;
					case 'integral_query':
						this.$router.push({name: 'integrals-query'});
						break;
				}
			}
		},
		mounted() {
			window.axios.get('integral-goods').then(response => {
				this.goods = response.data.data;
			})
		}
	}
</script>

<style scoped>
	.mt-navbar {
		margin-bottom: 10px;
	}
	
	.row {
		margin-right: 0;
		margin-left: 0;
	}
	
	.card-body {
		padding: 1.25rem 0 0 0;
	}
	
	.card {
		margin-bottom: 10px;
	}
	
	.mt-swipe {
		width: 100%;
		height: 200px;
	}
	
	.fixed {
		width: 100%;
		position: fixed;
		bottom: 55px;
		background-color: white;
	}
</style>