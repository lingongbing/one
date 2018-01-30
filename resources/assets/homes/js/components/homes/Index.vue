<template>
	<div>
		<mt-swipe class="mt-swipe" :show-indicators="false" :speed="500">
			<mt-swipe-item v-for="(item,index) in carousels" :key="index">
				<a :href="item.link">
					<img :src="item.image">
				</a>
			</mt-swipe-item>
		</mt-swipe>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				carousels: {}
			}
		},
		created() {
			window.axios.get('/carousels').then(response => {
				this.carousels = response.data.data;
			}).catch(error => {
				console.log(error.response.data);
			})
		},
		
	}
</script>

<style scoped>
	.mt-swipe {
		height: 200px;
	}
</style>