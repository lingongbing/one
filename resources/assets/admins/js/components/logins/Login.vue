<template>
	<div class="row style-3">
		<div class="col-md-3 col-md-push-7">
			<login-form></login-form>
		</div>
	</div>
</template>

<script>
	import LoginForm from './Form';
	export default {
		components: {
			LoginForm,
		},
		created:function () {

		}
	}
</script>

<style scoped>
	.left-menu {
		padding: 0;
	}
</style>