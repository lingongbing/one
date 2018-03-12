<template>
	<div class="container-fluid">
		<div class="row">
			<header-menu v-if="this.$store.getters.authenticate"></header-menu>
			<div class="col-md-2 left-menu" v-if="this.$store.getters.authenticate">
				<left-menu></left-menu>
			</div>
			<div class="col-md-8" :class="{'col-md-12': !this.$store.getters.authenticate}">
				<router-view></router-view>
			</div>
		</div>
		<div class="text-center">
			{{ copyright }}
		</div>
	</div>
</template>

<script>
	import LeftMenu from './commons/menu'
	import HeaderMenu from './commons/header'
	export default {
		data() {
			return {
				copyright: '',
			}
		},
		components : {
			LeftMenu,HeaderMenu
		},
		mounted() {
			window.axios.get('sites').then(response => {
				this.copyright = response.data.copyright;
			})
		}
	}
</script>

<style scoped>
	.left-menu {
		padding: 0;
	}
</style>