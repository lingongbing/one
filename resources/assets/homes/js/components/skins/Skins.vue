<template>
	<div>
		<mt-navbar v-model="selected">
			<mt-tab-item id="personal_info">个人资料</mt-tab-item>
			<mt-tab-item id="skin_info">皮肤信息</mt-tab-item>
		</mt-navbar>
		<mt-tab-container class="mt-tab-container" v-model="active">
			<mt-tab-container-item id="skins-show">
				<show-skin></show-skin>
			</mt-tab-container-item>
			<mt-tab-container-item id="edit-skin">
			</mt-tab-container-item>
		</mt-tab-container>
		<div class="container">
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'skins-show'"
			           :disabled="active === 'skins-show'">查看信息
			</mt-button>
			<mt-button class="mt-button" type="primary" size="large" plain @click="active = 'edit-skin'"
			           :disabled="active === 'edit-skin'">修改信息
			</mt-button>
		</div>
	</div>
</template>

<script>
	import ShowSkin from './ShowSkin'
	export default {
		components: {
			ShowSkin,
		},
		data() {
			return {
				active: 'skins-show',
				selected: 'skin_info',
			}
		},
		watch: {
			selected: function () {
				switch (this.selected) {
					case 'personal_info':
						this.$router.push({name:'users-show'});
						break;
					case 'skin_info':
						this.$router.push({name:'skins-show'});
						break;
				}
			}
		}
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