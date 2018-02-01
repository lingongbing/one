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
			<mt-tab-item v-for="(menu,index) in menus" :id="menu.key" :key="index" v-if="!menu.parent_id">
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
				main_menu: 'home',
			}
		},
		watch: {
			'$route': function() {
				this.changeMainMenu();
			},
			main_menu: function () {
				this.changeRouter();
			}
		},
		created() {
			this.getMenus();
		},
		methods: {
			getMenus: function () {
				window.axios.get('menus').then(response => {
					this.menus = response.data.data;
					this.changeMainMenu();
				});
			},
			changeMainMenu: function () {
				switch (this.$route.name)
				{
					case 'home':
						this.main_menu = 'home';
						break;
					case 'orders':
						this.main_menu = 'buy_record';
						break;
					case 'orders-show':
						this.main_menu = 'buy_record';
						break;
				}
			},
			changeRouter: function () {
				switch (this.main_menu) {
					case 'home':
						this.$router.push({name: 'home'});
						break;
					case 'buy_record':
						if (this.$route.name == 'orders-show')
						{
							this.$router.push(this.$route.fullPath);
						}else {
							this.$router.push({name: 'orders'});
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