<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="personal_info">个人资料</mt-tab-item>
			<mt-tab-item id="skin_info">皮肤信息</mt-tab-item>
		</mt-navbar>
		<mt-tab-container class="mt-tab-container" v-model="active">
			<mt-tab-container-item id="users-show">
				<show-user></show-user>
			</mt-tab-container-item>
			<mt-tab-container-item id="edit-user">
				<edit-user></edit-user>
			</mt-tab-container-item>
			<mt-tab-container-item id="edit-mobile">
				<edit-mobile></edit-mobile>
			</mt-tab-container-item>
			<mt-tab-container-item id="edit-password">
				<edit-password></edit-password>
			</mt-tab-container-item>
		</mt-tab-container>
		<hr>
		<div class="container">
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'users-show'"
			           :disabled="active === 'users-show'">查看信息
			</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'edit-user'"
			           :disabled="active === 'edit-user'">修改资料
			</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'edit-mobile'"
			           :disabled="active === 'edit-mobile'">修改手机
			</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'edit-password'"
			           :disabled="active === 'edit-password'">修改密码
			</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="$store.dispatch('unauthenticate'),$router.push({name:'home'})">退出登陆</mt-button>
		</div>
	</div>
</template>

<script>
	import ShowUser from './Show';
	import EditUser from './EditUser';
	import EditMobile from './EditMobile';
	import EditPassword from './EditPassword';
	export default {
		components: {
			ShowUser,EditUser,EditMobile,EditPassword
		},
		data() {
			return {
				active: 'users-show',
				selected: 'personal_info',
			}
		},
		watch: {
			selected: function () {
				switch (this.selected) {
					case 'personal_info':
						this.$router.push({name: 'users-show'});
						break;
					case 'skin_info':
						this.$router.push({name: 'skins-show'});
						break;
				}
			}
		},
	}
</script>

<style scoped>
	.mt-button {
		margin-top: 10px;
		padding-top: 5px;
	}
	.mt-tab-container {
		margin-top: 10px;
	}
</style>