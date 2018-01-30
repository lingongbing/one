<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">新增客户</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<user-form v-on:show_skin="show_skin" v-on:set_user_id="set_user_id"></user-form>
			</div>
			<div class="col-md-6" v-show="is_show_skin && user_id">
				<skin-form :user_id="user_id"></skin-form>
			</div>
		</div>
	</div>
</template>

<script>
	import UserForm from './UserForm'
	import SkinForm from './SkinForm'
	export default {
		components: {
			UserForm,SkinForm
		},
		data() {
			return {
				user_id: 0,
				is_show_skin: false,
			}
		},
		methods: {
			show_skin:function (status) {
				this.is_show_skin = status;
			},
			set_user_id:function (user_id) {
				this.user_id = user_id;
			}
		}
	}
</script>

<style scoped>

</style>