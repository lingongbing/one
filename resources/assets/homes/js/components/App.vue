<template>
	<div>
		<mt-header fixed>
			<img slot="left" :src="site.logo_url">
			<span slot="right" class="badge badge-pill badge-danger">0</span>
		</mt-header>
		<router-view class="router-view"></router-view>
		<mt-tabbar v-model="main_menu" fixed>
			<mt-tab-item v-for="(menu,index) in menus" :id="menu.key" :key="index" v-if="!menu.parent_id">
				<img slot="icon" :src="menu.icon">
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
				site: {},
				menus: {},
				main_menu: 'home',
			}
		},
		watch: {
			'$route': function () {
				this.changeMainMenu();
			},
			main_menu: function () {
				this.changeRouter();
			}
		},
		created() {
			this.getSite();
			this.getMenus();
		},
		methods: {
			getSite: function () {
				window.axios.get('sites').then(response => {
					this.site = response.data;
				})
			},
			getMenus: function () {
				window.axios.get('menus').then(response => {
					this.menus = response.data.data;
					this.changeMainMenu();
				});
			},
			changeMainMenu: function () {
				switch (this.$route.name) {
					case 'home':
						this.main_menu = 'home';
						break;
					case 'orders':
						this.main_menu = 'buy_record';
						break;
					case 'orders-show':
						this.main_menu = 'buy_record';
						break;
					case 'users-show':
						this.main_menu = 'personal';
						break;
					case 'skins-show':
						this.main_menu = 'personal';
						break;
					case 'integrals-exchange':
						this.main_menu = 'integral';
						break;
					case 'integrals-query':
						this.main_menu = 'integral';
				}
			},
			changeRouter: function () {
				switch (this.main_menu) {
					case 'home':
						this.$router.push({name: 'home'});
						break;
					case 'buy_record':
						switch (this.$route.name) {
							case 'orders':
								this.$router.push({name: 'orders'});
								break;
							case 'orders-show':
								this.$router.push({name: 'orders-show'});
								break;
							default:
								this.$router.push({name: 'orders'});
								break;
						}
						break;
					case 'personal':
						switch (this.$route.name) {
							case 'users-show':
								this.$router.push({name: 'users-show'});
								break;
							case 'skins-show':
								this.$router.push({name: 'skins-show'});
								break;
							default:
								this.$router.push({name: 'users-show'});
								break;
						}
						break;
					case 'integral':
						switch (this.$route.name) {
							case 'integrals-exchange':
								this.$router.push({name: 'integrals-exchange'});
								break;
							case 'integrals-query':
								this.$router.push({name: 'integrals-query'});
								break;
							default:
								this.$router.push({name: 'integrals-exchange'});
								break;
						}
						break;
				}
			}
		}
	}
</script>

<style scoped>
	.router-view {
		margin-top: 40px;
		margin-bottom: 60px;
	}
</style>