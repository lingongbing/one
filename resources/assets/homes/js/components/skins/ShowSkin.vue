<template>
	<div>
		<mt-cell title="=============" :value="skin.name"></mt-cell>
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
			window.axios.get('skin').then(response => {
				this.skin = response.data;
			})
		}
	}
</script>

<style scoped>

</style>