<template>
	<div>
		<div class="text-center">
			<img :src="user.avatar" class="img-thumbnail" v-show="user.avatar">
		</div>
		<mt-cell title="姓名" :value="user.name"></mt-cell>
		<mt-cell title="账号" :value="user.username"></mt-cell>
		<mt-cell title="手机" :value="user.mobile"></mt-cell>
		<mt-cell title="微信" :value="user.wechat"></mt-cell>
		<mt-cell title="地址" :value="user.address"></mt-cell>
		<mt-cell title="注册时间" :value="user.created_at"></mt-cell>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user:{}
			}
		},
		created() {
			window.axios.get('user').then(response => {
				this.user = response.data;
			})
		}
	}
</script>

<style scoped>

</style>