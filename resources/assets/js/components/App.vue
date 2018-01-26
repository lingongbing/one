<template>
	<div>
		<common-header></common-header>
		<div class="container">
		
		</div>
		<common-footer></common-footer>
	</div>

</template>

<script>
	import CommonHeader from './common/Header';
	import CommonFooter from "./common/Footer";
    export default {
	    components: {
		    CommonHeader,
		    CommonFooter
	    },
	    mounted() {
            console.log('Component mounted.')
        }
    }
</script>