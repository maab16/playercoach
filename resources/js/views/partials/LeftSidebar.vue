<template>
	<nav id="sidebar">
	    <div class="custom-menu">
	        <button type="button" id="sidebarCollapse" class="btn btn-primary">
	            <i class="fa fa-bars"></i>
	            <span class="sr-only">Toggle Menu</span>
	        </button>
	    </div>
	    <div class="p-4">
	        <h1><a href="/" class="logo">Laravel</a></h1>
	        <ul class="list-unstyled components mb-5">
	            <li>
	                <a data-toggle="collapse" href="#user"><span class="fa fa-suitcase mr-3"></span> Users & Permissions</a>
	                <div class="collapse" id="user">
	                    <ul class="list-unstyled components ml-3">
	                        <li><router-link :to="{ name: 'user' }" class="nav-link">Users</router-link></li>
	                        <li><router-link :to="{ name: 'role' }" class="nav-link">Roles</router-link></li>
	                        <li><router-link :to="{ name: 'permission' }" class="nav-link">Permissions</router-link></li>
	                    </ul>
	                </div>
	            </li>
	            <li><router-link :to="{ name: 'admin' }" class="nav-link">Admin</router-link></li>
	        </ul>

	    </div>
	</nav>
</template>

<script>
	import nestMenu from './NestMenu'
	export default {
		props: {
			isLoggedIn: Boolean,
			menus: Array
		},
		components: {
            'nestmenu':nestMenu,
        },
		computed: {
			isActiveMenu: function(){
				switch(this.$route.name) {
					case 'database':
					case 'crud':
					case 'permission':
					case 'backup':
						return true;
					break;
				}
				
				return false;
			}
		}
	}
</script>

<style>
	#database-menu .router-link-exact-active{
		color: #fff !important;
	}
</style>