<template>
	<form class="form-horizontal" v-on:submit.prevent="onSubmit">
		<div class="form-group">
			<label for="image_1" class="col-sm-2 control-label">商品主图</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="image_1" style="display: none;"
				       v-validate data-vv-rules="required|mimes:image/*" data-vv-as="商品图片"
				       @change="uploadImg($event,0)">
				<img :src="images[0].image" v-show="images[0].image" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label for="image_2" class="col-sm-2 control-label">商品图片</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="image_2" style="display: none;"
				       v-validate data-vv-rules="required|mimes:image/*" data-vv-as="商品图片"
				       @change="uploadImg($event,1)">
				<img :src="images[1].image" v-show="images[1].image" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label for="image_3" class="col-sm-2 control-label">商品图片</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="image_3" style="display: none;"
				       v-validate data-vv-rules="required|mimes:image/*" data-vv-as="商品图片"
				       @change="uploadImg($event,2)">
				<img :src="images[2].image" v-show="images[2].image" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label for="image_4" class="col-sm-2 control-label">商品图片</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="image_4" style="display: none;"
				       v-validate data-vv-rules="required|mimes:image/*" data-vv-as="商品图片"
				       @change="uploadImg($event,3)">
				<img :src="images[3].image" v-show="images[3].image" class="img-thumbnail">
			</div>
		</div>
		<div class="form-group">
			<label for="image_5" class="col-sm-2 control-label">商品图片</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="image_5" style="display: none;"
				       v-validate data-vv-rules="required|mimes:image/*" data-vv-as="商品图片"
				       @change="uploadImg($event,4)">
				<img :src="images[4].image" v-show="images[4].image" class="img-thumbnail">
			</div>
		</div>
	</form>
</template>

<script>
	export default {
		props: [
			'good'
		],
		watch: {
			good: function () {
				this.getGoodImages(this.good);
			}
		},
		data() {
			return {
				images: {
					0: {
						id: false,
						image: false,
						is_main: true
					},
					1: {
						id: false,
						image: false,
						is_main: false
					},
					2: {
						id: false,
						image: false,
						is_main: false
					},
					3: {
						id: false,
						image: false,
						is_main: false
					},
					4: {
						id: false,
						image: false,
						is_main: false
					}
				},
				message: false,
			}
		},
		mounted() {
			console.log(this.images[0].image);
			this.getGoodImages(this.good);
		},
		methods: {
			getGoodImages: function (good) {
				window.axios.get('integral-goods/' + good + '/images').then(response => {
					for (let index in response.data.data){
						this.images[index].id = response.data.data[index].id;
						this.images[index].image = response.data.data[index].image;
					}
				})
			},
			storeImage:function (index) {
				let response;
				if (this.images[index].id) {
					response = window.axios.patch('integral-goods/'+this.good+'/images/'+this.images[index].id,this.images[index]);
				} else {
					response = window.axios.post('integral-goods/'+this.good+'/images',this.images[index]);
				}
				response.catch(error => {
					this.message = error.response.data.message;
				})
			},
			uploadImg: function (event, index) {
				let formData = new FormData();
				formData.append('key', 'img');
				formData.append('width', 420);
				formData.append('height', 200);
				formData.append('img', event.target.files[0]);
				axios.post('/upload', formData).then(response => {
					this.images[index].image = response.data.path;
					this.storeImage(index);
				}).catch(error => {
					console.log(error.response.data);
				});
			}
		},
	}
</script>

<style scoped>

</style>