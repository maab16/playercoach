<template>
	<div class="wrapper">
       <div class="card">
           <div class="card-header">Facility</div>

           <div class="card-body">
               <form id="wizard" @submit.prevent="createFacility">
                   <h3>Tenant Info</h3>
                   <div class="form-group row">
                       <select class="form-control col-md-4" @change="!isDomain">
                           <option value="username">Choose Username</option>
                           <option value="domain">Choose Domain</option>
                       </select>
                       <div class="form-group col-md-8">
                            <div class="input-group mb-3" v-show="!isDomain">
                              <input type="text" v-model="facility.username" class="form-control" placeholder="Username">
                              <div class="input-group-append">
                                <span class="input-group-text">.playercoach.com</span>
                              </div>
                            </div>
                           <input type="text" v-show="isDomain" v-model="facility.domain" class="form-control" placeholder="Domain">
                       </div>
                   </div>
                   <h3>Choose CMS</h3>
                       
                   <div class="form-group row">
                       <label class="col-md-12 col-form-label">Choose CMS (max 2)</label>

                       <a href="#" @click.prevent="selectCMS" v-for="(option, index) in cms" :key="index">
                           <input class="cms_input" type="checkbox" :id="option" v-model="facility.cms" @change="chnageCMS" :value="option"> 
                           <label class="cms_level" :for="option"><img :src="'/images/'+option+'.png'" class="img-fluid"></label>
                       </a>
                   </div>
                   <div class="form-group">
                     <input type="submit" class="btn btn-success" value="Create Facility">
                   </div>
               </form>
           </div>
       </div> 
	</div>
</template>

<script>
    // Set Default functionality for all vue components
    export default {
        data() {
            return {
                facility: {
                  username: '',
                  domain: '',
                  tempDomain: 'playercoach.com',
                  cms: []
                },
                cms: [
                  "octobercms",
                  "wordpress",
                  "other"
                ],
                isDomain: false
            }
        },
        methods: {
            createFacility: function(){
                // console.log(this.facility.domainOption)
                console.log(this.facility.username)
                console.log(this.facility.domain)
            },
            selectCMS: function(){
              // let cms = [...this.facility.cms]
              // console.log(this.cms);
              // Vue.delete(this.facility, 'cms')
              // this.facility.cms = this.cms
            }
        }
    }
</script>

<style scoped="scoped">
  .cms_level {
    max-width: 60px;
  }
  .cms_input {
    opacity: 0;
    position: absolute;
  }
</style>