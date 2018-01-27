<template>
	<div>
		<mt-swipe class="mt-swipe">
			<mt-swipe-item style="background-color: #8eb4cb;">
				<h1>1</h1>
			</mt-swipe-item>
			<mt-swipe-item style="background-color: #2ab27b;">
				<h1>2</h1>
			</mt-swipe-item>
			<mt-swipe-item style="background-color: #636b6f;">
				<h1>3</h1>
			</mt-swipe-item>
		</mt-swipe>
	</div>
</template>

<script>
	import {Swipe, SwipeItem} from 'mint-ui';
	export default {
		components: {
			Swipe,
			SwipeItem,
		},
		name: "index"
	}
</script>

<style scoped>
	.mt-swipe {
		height: 200px;
	}
</style>