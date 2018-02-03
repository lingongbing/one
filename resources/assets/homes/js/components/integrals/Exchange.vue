<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="integral_exchange">积分兑换</mt-tab-item>
			<mt-tab-item id="integral_query">积分查询</mt-tab-item>
		</mt-navbar>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				selected: 'integral_exchange',
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
	}
</script>

<style scoped>

</style>