<template>
	<form v-on:submit.prevent="onSubmit">
		<div class="form-group">
			<select class="form-control" v-model="skin.skin_category_id">
				<option value="default" disabled>皮肤种类</option>
				<option :value="item.id" v-for="item in skin_categories">{{ item.name }}</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" v-model="skin.skin_belong_id">
				<option disabled>皮肤属于</option>
				<option :value="item.id" v-for="item in skin_belongs">{{ item.name }}</option>
			</select>
		</div>
		<div class="form-group">
			<input type="date" class="form-control" v-model="skin.check_time"
			       name="check_time" placeholder="检查时间" aria-describedby="check_timeHelp"
			       v-validate data-vv-rules="required" data-vv-as="检查时间">
			<small id="check_timeHelp" class="form-text text-muted">{{ errors.first('check_time') }}</small>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="skin.characteristics"
			       name="characteristics" placeholder="皮肤特征" aria-describedby="characteristicsHelp"
			       v-validate data-vv-rules="required" data-vv-as="皮肤特征">
			<small id="characteristicsHelp" class="form-text text-muted">{{ errors.first('characteristics') }}</small>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="skin.makeup_habits"
			       name="makeup_habits" placeholder="化妆习惯" aria-describedby="makeup_habitsHelp"
			       v-validate data-vv-rules="required" data-vv-as="化妆习惯">
			<small id="makeup_habitsHelp" class="form-text text-muted">{{ errors.first('makeup_habits') }}</small>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="skin.commonly_products"
			       name="commonly_products" placeholder="常用产品" aria-describedby="commonly_productsHelp"
			       v-validate data-vv-rules="required" data-vv-as="常用产品">
			<small id="commonly_productsHelp" class="form-text text-muted">{{ errors.first('commonly_products') }}
			</small>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="skin.nursing_advice"
			       name="nursing_advice" placeholder="护理建议" aria-describedby="nursing_adviceHelp"
			       v-validate data-vv-rules="required" data-vv-as="护理建议">
			<small id="nursing_adviceHelp" class="form-text text-muted">{{ errors.first('nursing_advice') }}</small>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="skin.condition"
			       name="condition" placeholder="皮肤状态" aria-describedby="conditionHelp"
			       v-validate data-vv-rules="required" data-vv-as="皮肤状态">
			<small id="conditionHelp" class="form-text text-muted">{{ errors.first('condition') }}</small>
		</div>
		<div class="container">
			<mt-button class="mt-button" type="primary" size="large" plain>确认修改</mt-button>
		</div>
	</form>
</template>

<script>
	export default {
		data() {
			return {
				user: {},
				skin: {
					condition: '皮肤特征',
					check_time: '',
					makeup_habits: '化妆习惯',
					skin_belong_id: 0,
					nursing_advice: '常用产品',
					skin_category_id: 0,
					characteristics: '护理建议',
					commonly_products: '皮肤状态',
				},
				skin_belongs: {},
				skin_categories: {},
				message: '',
			}
		},
		created() {
			window.axios.get('skins-belongs').then(response => {
				this.skin_belongs = response.data.data;
			});

			window.axios.get('skins-categories').then(response => {
				this.skin_categories = response.data.data;
			});

			window.axios.get('user').then(response => {
				this.user = response.data;
			});

			window.axios.get('user/skin').then(response => {
				this.skin = response.data;
			});
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						let request = {};
						if (this.skin.id) {
							request = window.axios.patch('user/skin',this.skin);
						} else {
							request = window.axios.post('user/skin',this.skin);
						}

						request.then(response => {
							this.message = '修改成功';
						}).catch(error => {
							if (error.response.status === 422) {
								this.messages = error.response.data.errors[index][0];
							}
						});
					}
				});
			}
		}
	}
</script>

<style scoped>
	form {
		margin: 10px;
	}
</style>