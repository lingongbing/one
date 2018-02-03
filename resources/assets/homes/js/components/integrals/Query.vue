<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="integral_exchange">积分兑换</mt-tab-item>
			<mt-tab-item id="integral_query">积分查询</mt-tab-item>
		</mt-navbar>
		<div>
			<mt-cell title="剩余积分:" :value="user.integral"></mt-cell>
			<mt-cell :key="index" title="积分记录:" :value="`${item.event}${item.action == 'increase' ? '增加' : '减少'}${item.integral}积分`" v-for="(item,index) in integral_records"></mt-cell>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {},
				integral_records: {},
				selected: 'integral_query'
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
			}
		},
		created() {
			window.axios.get('user/integral').then(response => {
				this.integral_records = response.data.data;
			});
			
			window.axios.get('user').then(response => {
				this.user = response.data;
			});
		}
	}
</script>

<style scoped>

</style>