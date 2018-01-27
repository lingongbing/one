<template>
	<div>
		<mt-header fixed>
			<span slot="left">Laravel</span>
			<span slot="right">Message</span>
		</mt-header>
		<mt-navbar :class="{ 'mt-navbar' : sub_menu!='home'}" v-model="sub_menu">
			<mt-tab-item v-for="(menu,index) in menus" :key="index" :id="menu.key"
			             v-show="menu.parent_id && main_menu == menu.parent_id">{{ menu.name }}
			</mt-tab-item>
		</mt-navbar>
		<tab-container class="tab-container" v-model="sub_menu" swipeable>
			<mt-tab-container-item id="home">
				<home-index></home-index>
			</mt-tab-container-item>
			<mt-tab-container-item id="trading">
				<order-index :state=1></order-index>
			</mt-tab-container-item>
			<mt-tab-container-item id="has_been_completed">
				<order-index :state=2></order-index>
			</mt-tab-container-item>
			<mt-tab-container-item id="integral_exchange">
				<integral-exchange></integral-exchange>
			</mt-tab-container-item>
			<mt-tab-container-item id="integral_query">
				<integral-query></integral-query>
			</mt-tab-container-item>
			<mt-tab-container-item id="personal_info">
				<personal-info></personal-info>
			</mt-tab-container-item>
			<mt-tab-container-item id="skin_info">
				<skin-info></skin-info>
			</mt-tab-container-item>
		</tab-container>
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
	import HomeIndex from './homes/Index';
	import OrderIndex from './orders/Index';
	import IntegralQuery from './integrals/Query';
	import IntegralExchange from './integrals/Exchange';
	import PersonalInfo from './personals/Info';
	import SkinInfo from './skins/Info';
	
	export default {
		components: {
			PersonalInfo,
			SkinInfo,
			IntegralQuery,
			IntegralExchange,
			HomeIndex,
			OrderIndex,
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
			}
		},
		created() {
			this.getMenus();
		},
		mounted() {
			console.log('Component mounted.')
		},
		methods: {
			getMenus: function () {
				window.axios.get('http://api.one.com/menus').then(response => {
					this.menus = response.data.data;
				}).catch(error => {
					console.log(error.response);
				})
			}
		}
	}
</script>

<style scoped>
	.mt-navbar {
		margin-top: 40px;
	}
	
	.tab-container {
		margin-top: 40px;
	}
</style>