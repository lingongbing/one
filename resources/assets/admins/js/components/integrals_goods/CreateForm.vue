<template>
	<form class="form-horizontal" v-on:submit.prevent="onSubmit">
		<div class="alert alert-info" v-show="message">
			<button type="button" class="close" @click="message = false">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ message }}
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="text" class="form-control" v-model="name" name="name" placeholder="商品名称"
				       v-validate data-vv-rules="required|max:255" data-vv-as="商品名称">
				<span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="text" class="form-control" v-model="integral" name="integral" placeholder="售卖积分"
				       v-validate data-vv-rules="required|numeric|max:10" data-vv-as="商品积分">
				<span class="help-block" v-show="errors.has('integral')">{{ errors.first('integral') }}</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<textarea id="editor" placeholder="商品简介"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-default">添加商品</button>
			</div>
		</div>
	</form>
</template>

<script>
	import $ from 'jquery'
	import Simditor from 'simditor'
	export default {
		data() {
			return {
				name:'',
				editor: {},
				message: false,
				integral: '',
				introduction: ''
			}
		},
		mounted() {
			this.editor = new Simditor({
				textarea: $('#editor'),
				upload: {
					url: '/api/simditors',
					fileKey: 'image',
					pasteImage: true,
				},
				toolbar: [
					'title',
					'bold',
					'italic',
					'underline',
					'strikethrough',
					'fontScale',
					'color',
					'ol',
					'ul',
					'blockquote',
					'code',
					'table',
					'link',
					'image',
					'hr',
					'indent',
					'outdent',
					'alignment'
				]
			});
		},
		methods: {
			onSubmit:function () {
				this.$validator.validateAll().then(result => {
					if (result) {
						window.axios.post('integral-goods',{
							name:this.name,
							integral:this.integral,
							introduction:this.editor.getValue()
						}).then(response => {
							this.message = this.name + '添加成功';
						}).catch(error => {
							if (error.response.data.status_code === 422)
							{
								this.message = error.response.data.errors[0][0];
							} else {
								this.message = error.response.data.message;
							}
						})
					}
				});
			}
		},
	}
</script>

<style scoped>

</style>