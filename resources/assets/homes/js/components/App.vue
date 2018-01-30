<template>
	<div>
		<mt-header fixed>
			<span slot="left">Laravel</span>
			<span slot="right">Message</span>
		</mt-header>
		<router-view class="router-view"></router-view>
		<mt-tabbar v-model="main_menu" fixed>
			<mt-tab-item id="home">
				<img slot="icon" src="http://localhost/storage/public/lVidFXGxpGcYB2lBsA2HqLtupJu4JsgFWhMaFh3v.jpeg">
				首页
			</mt-tab-item>
			<mt-tab-item v-for="(menu,index) in menus" :id="menu.id" :key="index" v-if="!menu.parent_id">
				<img slot="icon" src="http://localhost/storage/public/lVidFXGxpGcYB2lBsA2HqLtupJu4JsgFWhMaFh3v.jpeg">
				{{ menu.name }}
			</mt-tab-item>
		</mt-tabbar>
	</div>
</template>

<script>
	import {TabContainer, TabContainerItem} from 'mint-ui';

	export default {
		components: {
			TabContainer,
			TabContainerItem
		},
		data() {
			return {
				menus: {},
				sub_menu: 'home',
				main_menu: 'home',
			}
		},
		watch: {
			'$router' (to) {
				console.log(to);
			},
			main_menu: function () {
				if (this.main_menu === 'home') {
					this.sub_menu = 'home';
					return;
				}
				for (let index in this.menus) {
					if (this.main_menu == this.menus[index].parent_id) {
						this.sub_menu = this.menus[index].key;
						break;
					}
				}
			},
			sub_menu: function () {
				if (this.sub_menu === 'home') {
					this.$router.push({name: 'home'});
				}
				if (this.sub_menu === 'trading') {
					this.$router.push({name: 'orders', params : {state : 1}});
				}
			}
		},
		created() {
			this.getMenus();
		},
		methods: {
			getMenus: function () {
				window.axios.get('/menus').then(response => {
					this.menus = response.data.data;
				}).catch(error => {
					console.log(error.response);
				})
			}
		}
	}
</script>

<style scoped>
	.router-view {
		margin-top: 50px;
	}
</style>