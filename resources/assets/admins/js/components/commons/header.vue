<template>
	<nav class="navbar navbar-inverse">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<router-link :to="{name:'index'}" class="navbar-brand" tag="a"><img :src="logo_url"></router-link>
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">{{ this.$store.getters.username }}<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#" @click="logout">退出</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</template>

<script>
	export default {
		data() {
			return {
				logo_url: '',
			}
		},
		created(){
			axios.get('/sites').then(response => {
				this.logo_url = response.data.logo_url;
			});
		},
		methods: {
			logout:function () {
				this.$store.dispatch('unauthenticate').then(response => {
					this.$router.push({name: 'login'});
				}).catch(error => {
					this.error = error.response.data.message;
				});
			}
		}
	}
</script>

<style scoped>
	.navbar {
		background-color: #263238;
		margin-bottom: 0px;
		border-radius: 0px;
	}
	.navbar-inverse {
		background-color: #263238;
		border-color: #263238;
		border-bottom:1px solid rgba(255,255,255,.1)
	}
	.navbar-brand {
		padding: 0;
	}
</style>