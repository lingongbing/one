<template>
	<div>
		<mt-cell title="皮肤种类" :value="skin.skin_category"></mt-cell>
		<mt-cell title="皮肤属于" :value="skin.skin_belong"></mt-cell>
		<mt-cell title="检查日期" :value="skin.check_time"></mt-cell>
		<mt-cell title="皮肤特征" :value="skin.characteristics"></mt-cell>
		<mt-cell title="化妆习惯" :value="skin.makeup_habits"></mt-cell>
		<mt-cell title="常用产品" :value="skin.commonly_products"></mt-cell>
		<mt-cell title="护理建议" :value="skin.nursing_advice"></mt-cell>
		<mt-cell title="皮肤状态" :value="skin.condition"></mt-cell>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				skin:{}
			}
		},
		created() {
			window.axios.get('user/skin').then(response => {
				this.skin = response.data;
			})
		}
	}
</script>

<style scoped>

</style>