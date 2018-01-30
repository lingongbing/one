<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">新增订单</h3>
		</div>
		<div class="panel-body">
			<div class="alert alert-info" v-for="(message,index) in messages" v-show="message" v-if="messages">
				<button type="button" class="close" @click="messages[index] = false">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ message }}
			</div>
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<v-select label="name" :filterable="false" v-model="current_goods" :options="goods" @search="onSearchGoods">
							<template slot="option" slot-scope="option">
								<div class="d-center">
									<img :src='option.image'/>
									{{ option.name }}
								</div>
							</template>
						</v-select>
						<input type="hidden" v-model="goods_id" name="goods_id" v-validate data-vv-rules="required">
						<span class="help-block" v-show="errors.has('goods_id')">必须选择商品</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="goods_number" name="goods_number"
						       v-validate data-vv-rules="required|numeric" data-vv-as="商品数量" placeholder="商品数量">
						<span class="help-block" v-show="errors.has('goods_number')">{{ errors.first('goods_number') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="goods_total_price" name="goods_total_price"
						       v-validate data-vv-rules="required|numeric" data-vv-as="商品总价" placeholder="商品总价(以分为单位)">
						<span class="help-block" v-show="errors.has('goods_total_price')">{{ errors.first('goods_total_price') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<v-select v-model="current_user" label="username" :options="users" @search="onSearchUsers"></v-select>
						<input type="hidden" v-model="user_id" name="user_id" v-validate data-vv-rules="required">
						<span class="help-block" v-show="errors.has('user_id')">必须选择客户</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="courier_company" name="courier_company"
						       v-validate data-vv-rules="required" data-vv-as="快递公司" placeholder="快递公司">
						<span class="help-block" v-show="errors.has('courier_company')">{{ errors.first('courier_company') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<input type="text" class="form-control" v-model="courier_order_no" name="courier_order_no"
						       v-validate data-vv-rules="required|numeric" data-vv-as="快递单号" placeholder="快递单号">
						<span class="help-block" v-show="errors.has('courier_order_no')">{{ errors.first('courier_order_no') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="submit" class="btn btn-default">增加</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	import vSelect from 'vue-select';
	export default {
		components: {
			vSelect
		},
		watch: {
			current_user:function () {
				if (this.current_user && this.current_user.id)
				{
					this.user_id = this.current_user.id;
				} else {
					this.user_id = '';
				}
			},
			current_goods:function () {
				if (this.current_goods && this.current_goods.id)
				{
					this.goods_id = this.current_goods.id;
				} else {
					this.goods_id = '';
				}
			}
		},
		data() {
			return {
				user_id: '',
				users: [],
				current_user: '选择客户',
				goods_id: '',
				goods: [],
				current_goods: '选择商品',
				goods_number: '',
				goods_total_price: '',
				courier_company: '',
				courier_order_no: '',
				messages: {
					user_id: '',
					message: '',
					goods_id: '',
					goods_number: '',
					courier_company: '',
					courier_order_no: '',
					goods_total_price: '',
				},
				params: {
					name: '',
				}
			}
		},
		methods: {
			onSubmit:function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						let params = {
							user_id: this.user_id,
							goods_id: this.goods_id,
							goods_number: this.goods_number,
							goods_total_price: this.goods_total_price,
							courier_company: this.courier_company,
							courier_order_no: this.courier_order_no,
						};
						axios.post('/orders', params).then(response => {
							this.messages.message = '创建成功';
						}).catch(error => {
							if (error.response.status == 422) {
								for (let index in error.response.data.errors) {
									this.messages[index] = error.response.data.errors[index][0];
								}
							}
							this.messages.message = '创建失败';
						});
					}
				});
			},
			onSearchGoods:function (search) {
				axios.get('goods',{
					params:{
						name:search
					}
				}).then(response => {
					this.goods = response.data.data;
				});
			},

			onSearchUsers:function (search) {
				axios.get('users',{
					params:{
						username:search
					}
				}).then(response => {
					this.users = response.data.data;
				});
			},
		}
	}
</script>

<style scoped>
	img {
		height: auto;
		max-width: 2.5rem;
		margin-right: 1rem;
	}
	
	.d-center {
		display: flex;
		align-items: center;
	}
	
	.selected img {
		width: auto;
		max-height: 23px;
		margin-right: 0.5rem;
	}
	
	.v-select .dropdown li {
		border-bottom: 1px solid rgba(112, 128, 144, 0.1);
	}
	
	.v-select .dropdown li:last-child {
		border-bottom: none;
	}
	
	.v-select .dropdown li a {
		padding: 10px 20px;
		width: 100%;
		font-size: 1.25em;
		color: #3c3c3c;
	}
	
	.v-select .dropdown-menu .active > a {
		color: #fff;
	}
</style>