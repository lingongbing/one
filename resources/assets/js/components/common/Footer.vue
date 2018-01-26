<template>
	<footer>
		<!-- Single button -->
		<div class="btn-group">
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Action
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="#">Action</a>
				<a class="dropdown-item" href="#">Another action</a>
				<a class="dropdown-item" href="#">Something else here</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Separated link</a>
			</div>
		</div>
	</footer>
</template>

<script>
	export default {
		name: "common-foot"
	}
</script>

<style scoped>
	footer {
		bottom: 0;
		position: absolute;
	}
</style>