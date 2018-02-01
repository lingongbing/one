<template>
	<div>
		<mt-swipe class="mt-swipe" :show-indicators="false" :speed="500">
			<mt-swipe-item v-for="(item,index) in carousels" :key="index">
				<a :href="item.link">
					<img :src="item.image">
				</a>
			</mt-swipe-item>
		</mt-swipe>
		<ul class="list-group"
		    v-infinite-scroll="getHomes"
		    infinite-scroll-disabled="loading"
		    infinite-scroll-distance="10">
			<li v-for="home in homes">
				<a :href="home.link">
					<img :src="home.image" style="width: 100%;">
				</a>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				homes: {},
				carousels: {},
				loading: false,
				pagination: {
					total_pages: 1,
					current_page: 0
				}
			}
		},
		created() {
			this.getHomes();
			window.axios.get('carousels').then(response => {
				this.carousels = response.data.data;
			});
		},
		methods: {
			getHomes: function () {
				if (this.pagination.total_pages > this.pagination.current_page)
				{
					window.axios.get('homes',{
						params:{
							page:++this.pagination.current_page
						}
					}).then(response => {
						let data = {};
						for (let index in response.data.data) {
							data[response.data.data[index].id] = response.data.data[index];
						}
						let new_data ={};
						Object.assign(new_data,this.homes,data);
						this.homes = new_data;
						this.pagination = response.data.meta.pagination;
					});
				}
			}
		}
	}
</script>

<style scoped>
	.mt-swipe {
		height: 200px;
	}
	ul {
		background-color: #eaeaea;
	}
	li {
		margin: 10px 0 0 0;
	}
</style>