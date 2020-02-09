<template>
	<div class="wrapper d-flex align-items-stretch">
	   <h1>Resource</h1> 
	</div>
</template>

<script>
    // Set Default functionality for all vue components
    export default {
        data() {
            return {}
        },
        created(){},
        mounted() {
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
        },
    }
</script>

<style>
</style>