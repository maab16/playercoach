<template>
  <div class="container-fluid">
      <!-- Button trigger modal -->
      <a
          href="#" 
          class="btn btn-success" 
          @click.prevent="showCreateForm()" 
          data-toggle="modal" 
          data-target="#addEditBookingModal"> <i class="fas fa-plus"></i>New Booking Sheet</a>

      <div 
            class="errors alert alert-danger mt-3" 
            role="alert" 
            v-for="(error,key) in errors" 
            :key="key"> {{ error }} </div>

        <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#profile" class="nav-link active" data-toggle="tab" aria-expanded="true">
            <i class="fa fa-user-o"></i> All Booking</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#orders" data-toggle="tab" aria-expanded="false">
            <i class="fa fa-shopping-cart"></i> Published</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#invoices" data-toggle="tab" aria-expanded="false">
            <i class="fa fa-trash-o"></i> Unpublished</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="profile">
          <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Settings</th>
                        <th>Deleted At</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(booking,index) in bookings" :key="index" :data-id="index+1">
                      <td>{{ booking.title }}</td>
                      <td>{{ booking.settings }}</td>
                      <td>{{ booking.deleted_at }}</td>
                      <td class="action">
                          <a 
                            href="#" 
                            class="btn btn-info" 
                            @click.prevent="viewBooking(index)" 
                            data-toggle="modal" 
                            data-target="#viewBookingModal">View</a>
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
        <div class="tab-pane" id="orders">
          <table class="table table-striped table-bordered database-tables" style="width: 100%;">
              <thead>
                  <tr>
                      <th>Title</th>
                      <th>Settings</th>
                      <th class="action">Action</th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="(published_booking,index) in published_bookings" :key="index" :data-id="index+1">
                    <td>{{ published_booking.title }}</td>
                    <td>{{ published_booking.settings }}</td>
                    <td class="action">
                        <a 
                          href="#" 
                          class="btn btn-info" 
                          @click.prevent="viewBooking(index)" 
                          data-toggle="modal" 
                          data-target="#viewBookingModal">View</a>
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
        <div class="tab-pane" id="invoices">
          <table class="table table-striped table-bordered database-tables" style="width: 100%;">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Settings</th>
                    <th>Deleted At</th>
                    <th class="action">Action</th>
                </tr>
            </thead>
            <tbody>
              <tr v-for="(unpublished_booking,index) in unpublished_bookings" :key="index" :data-id="index+1">
                  <td>{{ unpublished_booking.title }}</td>
                  <td>{{ unpublished_booking.settings }}</td>
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

      <booking-modals 
        :action="action"
        :category="category"
        :booking="booking"
        :addBooking="addBooking"
        :updateBooking="updateBooking"></booking-modals>

  </div>
</template>

<script>
  import BookingModals from '../../views/modals/BookingModals.vue';
  export default {
    components: {
      BookingModals
    },
    data(){
      return {
        bookings: [],
        unpublished_bookings: [],
        published_bookings: [],
        bookings: [],
        booking: {
          title: '',
          setting: '',
        },
        category: 'Create Booking Sheet',
        action: 'add',
        errors: [],
      }
    },
    mounted(){
      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
      this.fetchBookings()
    },
    methods: {
      fetchBookings: function(){
        axios.get('/api/facility/booking/all').then(res =>{
          console.log(res.data)
          this.bookings = res.data.bookings
          for(let booking of this.bookings) {
            booking.settings = JSON.stringify(booking.settings, null, 4);
          }
          this.unpublished_bookings = res.data.unpublished_bookings
          for(let unpublished_booking of this.unpublished_bookings) {
            unpublished_booking.settings = JSON.stringify(unpublished_booking.settings, null, 4);
          }
          this.published_bookings = res.data.published_bookings
          for(let published_booking of this.published_bookings) {
            published_booking.settings = JSON.stringify(published_booking.settings, null, 4);
          }
        })
      },
      showCreateForm: function(){
        this.action = "add"
        this.category = "Create Booking Sheet"
        this.booking = {
          title: '',
          settings: '',
        }
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
        // console.log(this.booking)
        // let booking = {...this.booking}
        // let settings = JSON.parse(booking.settings)
        // booking.settings = Object.entries(settings)
        axios.post('/api/facility/booking', this.booking).then(res =>{
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
        // this.booking.settings = JSON.parse(this.booking.settings)
        console.log(this.booking)
        axios.put(`/api/facility/booking/${this.booking.id}`, this.booking).then(res =>{
          console.log(res.data)
          if(res.data.success == true) {
            // Flash success message
            toastr.success('Updated Successfully into template.')
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
                axios.put(`/api/facility/booking/${booking}/restore`).then(res => {
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
            text: 'You will not be able to recover this database',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                // this.$Progress.start()
                axios.delete(`/api/facility/booking/${booking}`).then(res => {
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
                axios.delete(`/api/facility/booking/${booking}/permanent`).then(res => {
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
      closeModal: function(){
          $('.modal').modal('hide');
          $('.modal-backdrop').remove();
      },
    }
  }
</script>