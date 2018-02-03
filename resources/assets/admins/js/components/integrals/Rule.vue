<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">积分规则</h3>
		</div>
		<div class="panel-body">
			<div class="alert" :class="alert_class" role="alert" v-show="alert_message">
				<button type="button" class="close" @click="alert_message = ''">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ alert_message }}
			</div>
			<form class="form-horizontal" v-on:submit.prevent="onSubmit">
				<div class="form-group">
					<label class="col-sm-2 control-label">完成订单获得积分数</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" v-model="complete_order" name="complete_order"
						       v-validate data-vv-rules="numeric" data-vv-as="完成订单获得积分数" placeholder="完成订单获得积分数">
						<span class="help-block" v-show="errors.has('complete_order')">{{ errors.first('complete_order') }}</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">创建账号获得积分数</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" v-model="created_user" name="created_user"
						       v-validate data-vv-rules="numeric" data-vv-as="创建账号获得积分数" placeholder="创建账号获得积分数">
						<span class="help-block" v-show="errors.has('created_user')">{{ errors.first('created_user') }}</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">保存</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				created_user: 0,
				complete_order: 0,
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getConfig();
		},
		methods: {
			getConfig: function () {
				axios.get('integral-rules').then(response => {
					this.created_user = response.data.created_user;
					this.complete_order = response.data.complete_order;
				});
			},
			onSubmit: function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						axios.patch('integral-rules', {
							created_user: this.created_user,
							complete_order: this.complete_order,
						}).then(response => {
							this.created_user = response.data.created_user;
							this.complete_order = response.data.complete_order;
							this.alert_class = 'alert-success';
							this.alert_message = '更新成功';
						}).catch(error => {
							this.alert_class = 'alert-danger';
							this.alert_message = error.response.data.message;
						});
					}
				});
			},
		}
	}
</script>

<style scoped>

</style>