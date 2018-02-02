<template>
	<form class="form-horizontal" v-on:submit.prevent="onSubmit">
		<div class="alert alert-info" v-for="(message,index) in messages" v-show="message">
			<button type="button" class="close" @click="messages[index] = false">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ message }}
		</div>
		<div class="form-group">
			<label for="skin_category_id" class="col-sm-2 control-label">皮肤种类</label>
			<div class="col-sm-10">
				<select class="form-control" v-model="skin_categories_index" id="skin_category_id">
					<option value="default" disabled>皮肤种类</option>
					<option v-bind:value="index" v-for="(item,index) in skin_categories">{{ item.name }}</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="skin_belong_id" class="col-sm-2 control-label">皮肤属于</label>
			<div class="col-sm-10">
				<select class="form-control" v-model="skin_belongs_index" id="skin_belong_id">
					<option value="default" disabled>皮肤属于</option>
					<option v-bind:value="index" v-for="(item,index) in skin_belongs">{{ item.name }}</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="check_time" class="col-sm-2 control-label">检查日期</label>
			<div class="col-sm-10">
				<input type="text" v-model="check_time" id="check_time" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="characteristics" class="col-sm-2 control-label">皮肤特征</label>
			<div class="col-sm-10">
				<input type="text" v-model="characteristics" id="characteristics" name="characteristics"
				       class="form-control" v-validate data-vv-rules="required" data-vv-as="皮肤特征">
				<span class="help-block"
				      v-show="errors.has('characteristics')">{{ errors.first('characteristics') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="makeup_habits" class="col-sm-2 control-label">化妆习惯</label>
			<div class="col-sm-10">
				<input type="text" v-model="makeup_habits" id="makeup_habits" name="makeup_habits" class="form-control"
				       v-validate data-vv-rules="required" data-vv-as="化妆习惯">
				<span class="help-block" v-show="errors.has('makeup_habits')">{{ errors.first('makeup_habits') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="commonly_products" class="col-sm-2 control-label">常用产品</label>
			<div class="col-sm-10">
				<input type="text" v-model="commonly_products" id="commonly_products" name="commonly_products"
				       class="form-control" v-validate data-vv-rules="required" data-vv-as="常用产品">
				<span class="help-block"
				      v-show="errors.has('commonly_products')">{{ errors.first('characteristics') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="nursing_advice" class="col-sm-2 control-label">护理建议</label>
			<div class="col-sm-10">
				<input type="text" v-model="nursing_advice" id="nursing_advice" name="nursing_advice"
				       class="form-control" v-validate data-vv-rules="required" data-vv-as="护理建议">
				<span class="help-block"
				      v-show="errors.has('nursing_advice')">{{ errors.first('nursing_advice') }}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="nursing_advice" class="col-sm-2 control-label">皮肤状态</label>
			<div class="col-sm-10">
				<input type="text" v-model="condition" id="condition" name="condition" class="form-control" v-validate
				       data-vv-rules="required" data-vv-as="皮肤状态">
				<span class="help-block" v-show="errors.has('condition')">{{ errors.first('condition') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">保存</button>
			</div>
		</div>
	</form>
</template>

<script>
	import DatePickers from './DatePickers'

	export default {
		props: [
			'user_id'
		],
		components: {
			DatePickers
		},
		data() {
			return {
				id: 0,
				condition: '',
				check_time: '2018-01-01',
				makeup_habits: '',
				nursing_advice: '',
				characteristics: '',
				skin_categories: {},
				skin_category_id: '',
				skin_categories_index: 0,
				skin_belongs: {},
				skin_belong_id: 0,
				skin_belongs_index: 0,
				commonly_products: '',
				messages: {
					message: '',
					condition: '',
					check_time: '',
					makeup_habits: '',
					nursing_advice: '',
					characteristics: '',
					skin_category_id: '',
					commonly_products: '',
				},
			}
		},
		watch: {
			user_id: function () {
				if (this.user_id) {
					this.getUserSkin(this.user_id);
				}
			},
			skin_belongs_index: function () {
				this.skin_belong_id = this.skin_belongs[this.skin_belongs_index].id;
			},
			skin_categories_index: function () {
				this.skin_category_id = this.skin_categories[this.skin_categories_index].id;
			},
			skin_belong_id: function () {
				for (const index in this.skin_belongs) {
					if (this.skin_belongs[index].id === this.skin_belong_id) {
						this.skin_belongs_index = index;
						break;
					}
				}
			},
			skin_category_id: function () {
				for (const index in this.skin_categories) {
					if (this.skin_categories[index].id === this.skin_category_id) {
						this.skin_categories_index = index;
						break;
					}
				}
			}
		},
		created() {
			window.axios.get('skins-belongs').then(response => {
				this.skin_belongs = response.data.data;
			});
			window.axios.get('skins-categories').then(response => {
				this.skin_categories = response.data.data;
			});
		},
		mounted() {
			$('#check_time').datetimepicker({
				minView: "month",
				format: "yyyy-mm-dd",
				autoclose: true,
				todayBtn: true,
			});
		},
		methods: {
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						let skin = {
							condition: this.condition,
							check_time: this.check_time,
							makeup_habits: this.makeup_habits,
							nursing_advice: this.nursing_advice,
							characteristics: this.characteristics,
							skin_category_id: this.skin_category_id,
							skin_belong_id: this.skin_belong_id,
							commonly_products: this.commonly_products
						};
						
						let request = {};
						if (this.id)
						{
							request = window.axios.patch('users/'+this.user_id+'/skins/'+this.id,skin);
						} else {
							request = window.axios.post('users/'+this.user_id+'/skins',skin);
						}
						
						request.then(response => {
							this.message.message = '创建成功';
						}).catch(error => {
							if (error.response.status === 422) {
								for (let index in error.response.data.errors) {
									this.messages[index] = error.response.data.errors[index][0];
								}
							}
						});
					}
				});
			},
			getUserSkin: function () {
				window.axios.get('users/' + this.user_id + '/skins').then(response => {
					this.id = response.data.data.id;
					this.condition = response.data.data.condition;
					this.check_time = response.data.data.check_time;
					this.makeup_habits = response.data.data.makeup_habits;
					this.nursing_advice = response.data.data.nursing_advice;
					this.characteristics = response.data.data.characteristics;
					this.skin_category_id = response.data.data.skin_category_id;
					this.skin_belong_id = response.data.data.skin_belong_id;
					this.commonly_products = response.data.data.commonly_products;
				}).catch(error => {
					this.id = 0;
					this.condition = '';
					this.check_time = '';
					this.makeup_habits = '';
					this.nursing_advice = '';
					this.characteristics = '';
					this.skin_category_id = '';
					this.skin_belong_id = '';
					this.commonly_products = '';
					this.skin_belongs_index = 0;
					this.skin_categories_index = 0;
					this.messages.message = error.response.data.message;
				});
			}
		}
	}
</script>

<style scoped>

</style>