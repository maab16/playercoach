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
	        	<li><router-link :to="{ name: 'admin' }" class="nav-link">Admin</router-link></li>
	        	<li>
	                <a data-toggle="collapse" href="#facility"><span class="fa fa-suitcase mr-3"></span> Facilities</a>
	                <div class="collapse" id="facility" :class="{show:isActiveMenu('facility|booking|resource')}">
	                    <ul class="list-unstyled components ml-3">
	                        <li><router-link :to="{ name: 'facility' }" class="nav-link">Facility</router-link></li>
	                        <li><router-link :to="{ name: 'booking' }" class="nav-link">Booking</router-link></li>
	                        <li><router-link :to="{ name: 'resource' }" class="nav-link">Resource</router-link></li>
	                    </ul>
	                </div>
	            </li>
	        	<li>
	                <a data-toggle="collapse" href="#setting"><span class="fa fa-suitcase mr-3"></span> Settings</a>
	                <div class="collapse" id="setting" :class="{show:isActiveMenu('profile|subscription|order|invoice')}">
	                    <ul class="list-unstyled components ml-3">
	                        <li><router-link :to="{ name: 'profile' }" class="nav-link">Profile</router-link></li>
	                        <li><router-link :to="{ name: 'subscription' }" class="nav-link">My Subscriptions</router-link></li>
	                        <li><router-link :to="{ name: 'order' }" class="nav-link">My Orders</router-link></li>
	                        <li><router-link :to="{ name: 'invoice' }" class="nav-link">My Invoices</router-link></li>
	                    </ul>
	                </div>
	            </li>
	            <li>
	                <a data-toggle="collapse" href="#user"><span class="fa fa-suitcase mr-3"></span> Users & Permissions</a>
	                <div class="collapse" id="user" :class="{show:isActiveMenu('user|role|permission')}">
	                    <ul class="list-unstyled components ml-3">
	                        <li><router-link :to="{ name: 'user' }" class="nav-link">Users</router-link></li>
	                        <li><router-link :to="{ name: 'role' }" class="nav-link">Roles</router-link></li>
	                        <li><router-link :to="{ name: 'permission' }" class="nav-link">Permissions</router-link></li>
	                    </ul>
	                </div>
	            </li>
	            <li>
	                <a data-toggle="collapse" href="#court_booking"><span class="fa fa-suitcase mr-3"></span> Court Booking</a>
	                <div class="collapse" id="court_booking" :class="{show:isActiveMenu('court')}">
	                    <ul class="list-unstyled components ml-3">
	                        <li><router-link :to="{ name: 'court' }" class="nav-link">Courts</router-link></li>
	                        <li><router-link :to="{ name: 'resource' }" class="nav-link">Resources</router-link></li>
	                    </ul>
	                </div>
	            </li>
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
        created(){
        },
		methods: {
			isActiveMenu: function(routes){
				routes = routes.split('|')

				let vm = this;

				return routes.filter(function(route){
				    return route == vm.$route.name
				}).length > 0
			}
		}
	}
</script>

<style>
	#sidebar .router-link-exact-active.active {
		color: #fff !important;
	}
</style>