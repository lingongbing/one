<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">网站背景颜色设置</h3>
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
					<label>头部背景颜色</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" v-model="html_style['background-color']">
					</div>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-default btn-block" @click="updateHtmlStyle()">
						确认修改
					</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				html_style: {
					"background-color" : "#ffffff"
				},
				alert_class: '',
				alert_message: '',
			}
		},
		created() {
			this.getHtmlStyle();
		},
		methods: {
			getHtmlStyle: function () {
				axios.get('html-style').then(response => {
					this.html_style = response.data;
				});
			},
			updateHtmlStyle: function () {
				window.axios.patch('html-style',{
					"background_color":this.html_style["background-color"],
				}).then(response => {
					this.alert_class = 'alert-success';
					this.alert_message = '修改成功';
				}).catch(error => {
					this.alert_class = 'alert-danger';
					this.alert_message = error.response.data.error;
				});
			},
		}
	}
</script>