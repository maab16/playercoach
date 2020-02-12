<template>
	<div class="wrapper">
	   <transition name="fade" mode="out-in">
         <div class="vue-content">
             <div class="crud-btn-area mb-3">
               <p class="text-white"> Manage Booking Sheet</p>
             </div>
             <a
              href="#" 
              class="btn btn-success mb-3" 
              @click.prevent="showCreateForm()" 
              data-toggle="modal" 
              data-target="#addEditBookingModal"><i class="fa fa-plus"></i> New Booking Sheet</a>
             <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="active">
                   <a class="nav-link active" href="#orders" data-toggle="tab" aria-expanded="false">
                     <i class="fa fa-shopping-cart"></i> Published</a>
                 </li>
                 <li class="nav-item">
                   <a href="#profile" class="nav-link" data-toggle="tab" aria-expanded="true">
                     <i class="fa fa-user-o"></i> All</a>
                 </li>
                 
                 <li class="nav-item">
                   <a class="nav-link" href="#invoices" data-toggle="tab" aria-expanded="false">
                     <i class="fa fa-trash-o"></i> Unpublished</a>
                 </li>
               </ul>
               <div class="tab-content">
                  <div class="tab-pane active" id="orders">
                    <table 
                      class="table table-striped table-bordered database-tables" 
                      style="width: 100%;"
                      v-if="published_bookings.length > 0">
                         <thead>
                             <tr>
                                 <th>Title</th>
                                 <th>Created At</th>
                                 <th class="action">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                           <tr v-for="(published_booking,index) in published_bookings" :key="index" :data-id="index+1">
                               <td>{{ published_booking.title }}</td>
                               <td>{{ published_booking.created_at }}</td>
                               <td class="action">
                                   <a 
                                     href="#" 
                                     class="btn btn-info" 
                                     @click.prevent="showSheetSettings(index)">
                                     <i class="fa fa-cogs"></i> Settings</a>
                                   <a 
                                     href="#" 
                                     class="btn btn-success" 
                                     @click.prevent="showEditForm(index)" 
                                     data-toggle="modal" 
                                     data-target="#addEditBookingModal">Edit</a>
                                   <a 
                                     @click.prevent="remove(published_booking.id)" 
                                     class="btn btn-danger">Delete</a>
                               </td>
                           </tr>

                         </tbody>
                    </table>
                  </div>
                 <div class="tab-pane" id="profile">
                   <div class="table-responsive mt-3">
                     <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                         <thead>
                             <tr>
                                 <th>Title</th>
                                 <th>Created At</th>
                                 <th>Deleted At</th>
                                 <th class="action">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                           <tr v-for="(booking,index) in bookings" :key="index" :data-id="index+1">
                               <td>{{ booking.title }}</td>
                               <td>{{ booking.created_at }}</td>
                               <td>{{ booking.deleted_at }}</td>
                               <td class="action">
                                   <a 
                                     href="#" 
                                     class="btn btn-info" 
                                     @click.prevent="showSheetSettings(index)"><i class="fa fa-cogs"></i> Settings</a>
                                   <a 
                                     href="#" 
                                     class="btn btn-success" 
                                     @click.prevent="showEditForm(index)" 
                                     data-toggle="modal" 
                                     data-target="#addEditBookingModal">Edit</a>
                                   <a 
                                     @click.prevent="remove(booking.id)" 
                                     class="btn btn-danger">Delete</a>
                               </td>
                           </tr>

                         </tbody>
                     </table>
                   </div>
                 </div>
                 
                 <div class="tab-pane" id="invoices">
                   <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                     <thead>
                         <tr>
                             <th>Title</th>
                             <th>Created At</th>
                             <th>Deleted At</th>
                             <th class="action">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                       <tr v-for="(unpublished_booking,index) in unpublished_bookings" :key="index" :data-id="index+1">
                           <td>{{ unpublished_booking.title }}</td>
                           <td>{{ unpublished_booking.created_at }}</td>
                           <td>{{ unpublished_booking.deleted_at }}</td>
                           <td class="action">
                               <a 
                                 @click.prevent="restore(unpublished_booking.id)" 
                                 class="btn btn-success">Restore</a>
                               <a 
                                 @click.prevent="removePermanently(unpublished_booking.id)" 
                                 class="btn btn-danger">Delete Permanently</a>
                           </td>
                       </tr>

                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
             <booking-sheet-modals 
               :action="action"
               :category="category"
               :booking="booking"
               :resource_types="resource_types"
               :addBooking="addBooking"
               :updateBooking="updateBooking"
               @updateSettings="updateBooking"
               :closeModal="closeModal"></booking-sheet-modals>

             <div class="crud-btn-area mb-3 mt-3">
               <p class="text-white"> Manage Resource Types</p>
             </div>
             
             <a
                 href="#" 
                 class="btn btn-success" 
                 @click.prevent="showResourceTypeCreateForm()" 
                 data-toggle="modal" 
                 data-target="#addEditResourceTypeModal"> <i class="fa fa-plus"></i> Add Resource Type</a>
             <div class="table-responsive mt-3">
                   <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                       <thead>
                           <tr>
                               <th>Title</th>
                               <th>Created At</th>
                               <th>Updated At</th>
                               <th class="action">Action</th>
                           </tr>
                       </thead>
                       <tbody>
                         <tr v-for="(resource_type,index) in resource_types" :key="index" :data-id="index+1">
                             <td>{{ resource_type.title }}</td>
                             <td>{{ resource_type.craeted_at }}</td>
                             <td>{{ resource_type.updated_at }}</td>
                             <td class="action">
                                 <a 
                                   href="#" 
                                   class="btn btn-info" 
                                   @click.prevent="viewResourceType(index)" 
                                   data-toggle="modal" 
                                   data-target="#viewResourceModal">View</a>
                                 <a 
                                   href="#" 
                                   class="btn btn-success" 
                                   @click.prevent="showEditResourceTypeForm(index)" 
                                   data-toggle="modal" 
                                   data-target="#addEditResourceTypeModal">Edit</a>
                                 <a 
                                   @click.prevent="removeResourceType(resource_type.id)" 
                                   class="btn btn-danger">Delete</a>
                             </td>
                         </tr>

                       </tbody>
                   </table>
             </div>

             <resource-type-modals 
               :action="action"
               :category="category"
               :resource_type="resource_type"
               :addResourceType="addResourceType"
               :updateResourceType="updateResourceType"></resource-type-modals>
             
         </div>
       </transition> 
	</div>
</template>

<script>
    // Set Default functionality for all vue components
     import BookingSheetModals from '../../views/modals/BookingSheetModals.vue';
     import ResourceTypeModals from '../../views/modals/ResourceTypeModals.vue';
    export default {
        components: {
            BookingSheetModals,
            ResourceTypeModals
        },
        data(){
          return {
            bookings: [],
            unpublished_bookings: [],
            published_bookings: [],
            bookings: [],
            booking: {
              title: '',
              settings: {
                business_hours: {
                  start:'2020-02-12T03:00:00.000Z',
                  end: '2020-02-12T11:00:00.000Z',
                  payment: {
                    charge_per_court: false,
                    price: null
                  }
                },
              },
              isActiveSettingModel: false,
              resources: [],
            },
            resource_types: [],
            resource_type: {
              title: ''
            },
            category: 'Create Booking Sheet',
            action: 'add',
            errors: [],
          }
        },
        created(){},
        mounted() {
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
            this.fetchBookings()
            this.fetchResourceTypes()
        },
        methods: {
          fetchBookings: function(){
            axios.get('/api/courtbooking/booking/all').then(res =>{
              console.log(res.data)
              this.bookings = res.data.bookings
              // for(let booking of this.bookings) {
              //   booking.settings = JSON.stringify(booking.settings, null, 4);
              // }
              this.unpublished_bookings = res.data.unpublished_bookings
              // for(let unpublished_booking of this.unpublished_bookings) {
              //   unpublished_booking.settings = JSON.stringify(unpublished_booking.settings, null, 4);
              // }
              this.published_bookings = res.data.published_bookings
              // for(let published_booking of this.published_bookings) {
              //   published_booking.settings = JSON.stringify(published_booking.settings, null, 4);
              // }
            })
          },
          showCreateForm: function(){
            this.action = "add"
            this.category = "Create Booking Sheet"
            this.booking.title = ''
          },
          showEditForm: function(index){
            console.log(index)
            this.action = "edit"
            this.category = "Update Booking Sheet"
            this.booking = this.bookings[index]
          },
          viewBooking: function(index){
            this.booking = this.bookings[index]
          },
          addBooking: function(){
            axios.post('/api/courtbooking/booking', this.booking).then(res =>{
              console.log(res.data)
                if(res.data.success == true) {
                  // Flash success message
                  toastr.success('Added Successfully.')
                  this.fetchBookings()
                  this.closeModal()
                }

                if(res.data.success == false) {
                  this.errors = []
                  for(let error of res.data.errors) {
                    toastr.error(error)
                    this.errors.push(error)
                  }
                }
            })
            .catch(err => {
              console.log(err)
            });
          },
          updateBooking: function(){
            console.log(this.booking)
            // this.booking.settings = JSON.parse(this.booking.settings)
            console.log(this.booking)
            axios.put(`/api/courtbooking/booking/${this.booking.id}`, this.booking).then(res =>{
              console.log(res.data)
              if(res.data.success == true) {
                // Flash success message
                toastr.success('Updated Successfully')
                this.fetchBookings()
                this.closeModal()
              }

              if(res.data.success == false) {
                this.errors = []
                for(let error of res.data.errors) {
                  toastr.error(error)
                  this.errors.push(error)
                }
              }

            })
            .catch(err => console.log(err));
          },
          restore: function(booking){
            let self = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to restore Booking',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, restore it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    // this.$Progress.start()
                    axios.put(`/api/courtbooking/booking/${booking}/restore`).then(res => {
                      console.log(res.data)
                        if( res.data.success == true ){
                            toastr.success("Booking Restored Successfully")
                            self.fetchBookings()
                            // this.$Progress.finish()
                        }
                    }).catch(err => {
                        // this.$Progress.start()
                        this.displayError(err.response)
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
          },
          remove: function(booking){
            let self = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this booking sheet',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    // this.$Progress.start()
                    axios.delete(`/api/courtbooking/booking/${booking}`).then(res => {
                      console.log(res.data)
                        if( res.data.success == true ){
                            toastr.success("Booking Deleted Successfully")
                            self.fetchBookings()
                            // this.$Progress.finish()
                        }
                    }).catch(err => {
                        // this.$Progress.start()
                        this.displayError(err.response)
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
          },
          removePermanently: function(booking){
            let self = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this database',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    // this.$Progress.start()
                    axios.delete(`/api/courtbooking/booking/${booking}/permanent`).then(res => {
                      console.log(res.data)
                        if( res.data.success == true ){
                            toastr.success("Booking Permanently Deleted Successfully")
                            self.fetchBookings()
                            // this.$Progress.finish()
                        }
                    }).catch(err => {
                        // this.$Progress.start()
                        this.displayError(err.response)
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
          },
          fetchResourceTypes: function(){
            axios.get('/api/courtbooking/resource-type/all').then(res =>{
              console.log(res.data)
              this.resource_types = res.data.resource_types
            })
          },
          showResourceTypeCreateForm: function(){
            this.action = "add"
            this.category = "Create Resource Type"
            this.resource_type = {
              title: '',
            }
          },
          viewResourceType: function(index){
            this.resource_type = this.resource_types[index]
          },
          showEditResourceTypeForm: function(index){
            console.log(index)
            this.action = "edit"
            this.category = "Edit Resource Type"
            this.resource_type = this.resource_types[index]
          },
          addResourceType: function(){
            axios.post('/api/courtbooking/resource-type', this.resource_type).then(res =>{
              console.log(res.data)
                if(res.data.success == true) {
                  // Flash success message
                  toastr.success('Resource Type Added Successfully.')
                  this.fetchResourceTypes()
                  this.closeModal()
                }

                if(res.data.success == false) {
                  this.errors = []
                  for(let error of res.data.errors) {
                    toastr.error(error)
                    this.errors.push(error)
                  }
                }
            })
            .catch(err => {
              console.log(err)
            });
          },
          updateResourceType: function(){
            axios.put(`/api/courtbooking/resource-type/${this.resource_type.id}`, this.resource_type)
            .then(res =>{
              console.log(res.data)
              if(res.data.success == true) {
                // Flash success message
                toastr.success('Resource Type Updated Successfully')
                this.fetchResourceTypes()
                this.closeModal()
              }

              if(res.data.success == false) {
                this.errors = []
                for(let error of res.data.errors) {
                  toastr.error(error)
                  this.errors.push(error)
                }
              }

            })
            .catch(err => console.log(err));
          },
          removeResourceType: function(resource_type){
            let self = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this resource type',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    // this.$Progress.start()
                    axios.delete(`/api/courtbooking/resource-type/${resource_type}`)
                    .then(res => {
                      console.log(res.data)
                        if( res.data.success == true ){
                            toastr.success("Resource Type Deleted Successfully")
                            self.fetchResourceTypes()
                            // this.$Progress.finish()
                        }
                    }).catch(err => {
                        // this.$Progress.start()
                        this.displayError(err.response)
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
          },
          showSheetSettings: function(index){
            this.published_booking = this.published_bookings[index]
            this.booking = this.published_bookings[index]
            Vue.delete(this.booking, 'isActiveSettingModel')
            Vue.delete(this.booking, 'business_hours')
            this.booking.isActiveSettingModel = true;
          },
          closeModal: function(){
              $('.modal').modal('hide');
              $('.modal-backdrop').remove();
          },
        }
    }
</script>

<style>
.vue-content {
    padding-right: 0px;
    padding-left: 0px;
    box-shadow: 0px 0px 14px 2px 
    rgba(0,0,0,.1);
    border-radius: 5px;
    padding: 30px;
    background:
        #fff;
}
.crud-btn-area {
    display: flex;
    justify-content: space-between;
    background: 
    #1599ca;
    border-radius: 2px;
}
.crud-btn-area p {
    color: #fff;
    font-weight: 500;
    padding: 10px;
    margin: 0px;
    font-size: 18px;
}
.settingModal{
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  display: none;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  outline: 0;
  background-color: rgba(0,0,0,0.5);
}
.settingModal.activeSetting {
  display: block;
}
</style>