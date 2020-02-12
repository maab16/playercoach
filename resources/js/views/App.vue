<template>
	<div class="wrapper d-flex align-items-stretch">
	    <left-sidebar :menus="menus" :isLoggedIn="isLoggedIn"></left-sidebar>
	    <!-- Main Content -->
        <main id="content" class="pl-4 pr-4">
            <!-- MAIN CONTENT -->
            <!-- NAVBAR -->
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-btn">
	                <button type="button" class="btn-toggle-fullwidth">
	                    <i class="fas fa-arrow-left"></i>
	                </button>
	            </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Codexshapper</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
                                <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
                                <li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
                                <li><a href="#" v-if="isLoggedIn" @click.prevent="logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- END NAVBAR -->
            <div class="main-content">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" v-for="(breadcrumb,index) in $route.meta.breadcrumbs">
                        <router-link 
                            :to="{ name: breadcrumb.name }"
                            :class="'crumb-link'" 
                            v-if="isLoggedIn">{{ breadcrumb.display }}</router-link>
                    </li>
                  </ol>
                </nav>
                <router-view 
                    :key="$route.fullPath" 
                    :prefix="prefix" 
                    @check="check"></router-view>
                <!-- set progressbar -->
                <vue-progress-bar></vue-progress-bar>
            </div>
            <!-- END MAIN CONTENT -->
        </main>
	</div>
</template>

<script>

    // Import vue components
    import LeftSidebar from './partials/LeftSidebar.vue';
    
    // Set Default functionality for all vue components
    export default {
        components:{
            LeftSidebar
        },
        data() {
            return {
                menus: [],
                name: null,
                user_type: 0,
                basePath: localStorage.getItem('playercoach.basePath'),
                prefix: localStorage.getItem('playercoach.prefix'),
                isLoggedIn: localStorage.getItem('playercoach.authToken') != null
            }
        },
        created(){
            // localStorage.setItem('playercoach.prefix', '');
            // if(localStorage.getItem('playercoach.prefix') != null && localStorage.getItem('playercoach.prefix') != this.prefix) {
            //     localStorage.removeItem('playercoach.prefix');
            //     localStorage.setItem('playercoach.prefix', this.prefix);
            // }
            // Set Base URL for axios request
            // axios.defaults.baseURL = this.basePath;

            //  [App.vue specific] When App.vue is first loaded start the progress bar
            this.$Progress.start()
            //  hook the progress bar to start before we move router-view
            this.$router.beforeEach((to, from, next) => {
              //  does the page we want to go to have a meta.progress object
              if (to.meta.progress !== undefined) {
                let meta = to.meta.progress
                // parse meta tags
                this.$Progress.parseMeta(meta)
              }
              //  start the progress bar
              this.$Progress.start()
              //  continue to next page
              next()
            })
            //  hook the progress bar to finish after we've finished moving router-view
            this.$router.afterEach((to, from) => {
              //  finish the progress bar
              this.$Progress.finish()
            })
        },
        mounted() {
            // this.getMenus();
            // this.setDefaults();
            this.$Progress.finish()
        },
        methods : {
            getMenus: function() {
                axios.get('/api'+this.prefix+'/menus')
                .then(res => {
                    if( res.data.success == true ){
                        this.menus = res.data.menus;
                    } 
                })
                .catch(err => this.displayError(err.response));
            },
            setDefaults() {
                if (this.isLoggedIn) {
                    let user = JSON.parse(localStorage.getItem('playercoach.user'))
                    this.name = user.name
                    axios.defaults.headers.common['Content-Type'] = 'application/json'
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
                }
            },
            check(type = 'authenticate') {
                switch(type) {
                    case 'authenticate':
                        this.isLoggedIn = localStorage.getItem('playercoach.authToken') != null
                        this.setDefaults()
                        break
                    case 'load':
                        this.isLoaded = false;
                        this.loadComponent();
                        break
                    case 'reloadMenu':
                        this.getMenus();
                        break;
                }
            },
            logout(){
                localStorage.removeItem('playercoach.authToken')
                localStorage.removeItem('playercoach.user')
                this.check()
                this.$router.push({name: 'login'})
            }
        }
    }
</script>

<style>
    .loading {
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 99999;
        width: 100%;
        height: 100vh;
        background-color: rgba(255,255,255);
        color: red;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #ffffff;
        transition: 0.5s;
    }

    .fade-enter {
        transform: translateY(10px);
        opacity: 0;
    }
    .fade-enter-to {
        transform: translateX(0px);
    }
    .fade-enter-active {
        transition: all 0.3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .fade-leave-active, .fade-leave-to {
        opacity: 0;
    }

    .onoffswitch {
      position: relative;
      width: 90px;
      -webkit-user-select:none; 
      -moz-user-select:none;
      -ms-user-select: none;
    }
    .onoffswitch-checkbox {
      display: none;
    }
    .onoffswitch-label {
      display: block;
      overflow: hidden;
      cursor: pointer;
      border-radius: 8px;
      margin-top: 9px;
    }
    .onoffswitch-inner {
      display: block; 
      width: 200%; 
      margin-left: -100%;
      transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before,
    .onoffswitch-inner:after {
      display: block; 
      float: left; 
      width: 50%;
      height: 35px;
      padding: 0;
      line-height: 35px;
      font-size: 14px;
      color: white;
      font-family: Trebuchet, Arial, sans-serif; 
      font-weight: bold;
      box-sizing: border-box;
    }
    .onoffswitch-inner:before {
      content: "YES";
      padding-left: 10px;
      background-color: #34A7C1; 
      color: #FFFFFF;
    }
    .onoffswitch-inner:after {
      content: "NO";
      padding-right: 10px;
      background-color: #EEEEEE; 
      color: #999999;
      text-align: right;
    }
    .onoffswitch-switch {
      display: block;
      width: 20px;
      margin: 7px;
      background: #FFFFFF;
      position: absolute;
      top: 0;
      bottom: 0;
      right: 56px;
      border: 1px solid #999999;
      border-radius: 20px;
      transition: all 0.3s ease-in 0s;
      height: 20px;
    }
    .onoffswitch-checkbox:checked + 
    .onoffswitch-label .onoffswitch-inner {
      margin-left: 0;
    }
    .onoffswitch-checkbox:checked + 
    .onoffswitch-label .onoffswitch-switch {
      right: 0px; 
    }
</style>