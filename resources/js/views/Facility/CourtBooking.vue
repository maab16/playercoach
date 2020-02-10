<template>
  <div class="container-fluid">
      <!-- Button trigger modal -->

      <div 
            class="errors alert alert-danger mt-3" 
            role="alert" 
            v-for="(error,key) in errors" 
            :key="key"> {{ error }} </div>
      
      <a
          href="#" 
          class="btn btn-success" 
          @click.prevent="showCreateForm()" 
          data-toggle="modal" 
          data-target="#addEditCourtBookingModal"> <i class="fas fa-plus"></i>Book Court</a>
      <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>start</th>
                        <th>end</th>
                        <th>Resources</th>
                        <th>max_participants</th>
                        <th>open</th>
                        <th>created_by</th>
                        <th>updated_by</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(court_booking,index) in court_bookings" :key="index" :data-id="index+1">
                      <td>{{ court_booking.title }}</td>
                      <td>{{ court_booking.start }}</td>
                      <td>{{ court_booking.end }}</td>
                      <td>{{ court_booking.resource.title }}</td>
                      <td>{{ court_booking.max_participants }}</td>
                      <td>{{ court_booking.open }}</td>
                      <td>{{ court_booking.created_by }}</td>
                      <td>{{ court_booking.updated_by }}</td>
                      <td class="action">
                          <a 
                            href="#" 
                            class="btn btn-info" 
                            @click.prevent="viewcourt_booking(index)" 
                            data-toggle="modal" 
                            data-target="#viewCourtBookingModal">View</a>
                          <a 
                            href="#" 
                            class="btn btn-success" 
                            @click.prevent="showEditForm(index)" 
                            data-toggle="modal" 
                            data-target="#addEditCourtBookingModal">Edit</a>
                          <a 
                            @click.prevent="remove(court_booking.id)" 
                            class="btn btn-danger">Delete</a>
                      </td>
                  </tr>

                </tbody>
            </table>
      </div>

      <court-booking-modals 
        :action="action"
        :category="category"
        :resources="resources"
        :court_booking="court_booking"
        :addResource="addResource"
        :updateResource="updateResource"></court-booking-modals>

  </div>
</template>

<script>
  import CourtBookingModals from '../../views/modals/CourtBookingModals.vue';
  export default {
    components: {
      CourtBookingModals
    },
    data(){
      return {
        resources: [],
        court_booking: {
          title: '',
          start: '',
          end : '',
          resource: {
            title: ''
          }
        },
        court_bookings: [],
        category: 'Book Court',
        action: 'add',
        errors: [],
      }
    },
    mounted(){
      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
      this.fetchResources()
    },
    methods: {
      fetchResources: function(){
        axios.get('/api/facility/courtbookings/all').then(res =>{
          console.log(res.data)
          this.court_bookings = res.data.court_bookings
          this.resources = res.data.resources
        })
      },
      showCreateForm: function(){
        this.action = "add"
        this.category = "Create resource"
        this.resource = {
          title: '',
          settings: '',
        }
      },
      showEditForm: function(index){
        console.log(index)
        this.action = "edit"
        this.category = "Update Resource"
        this.resource = this.resources[index]
      },
      viewResource: function(index){
        this.resource = this.resources[index]
      },
      addResource: function(){
        axios.post('/api/facility/resource', this.resource).then(res =>{
          console.log(res.data)
            if(res.data.success == true) {
              // Flash success message
              toastr.success('Added Successfully.')
              this.fetchResources()
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
      updateResource: function(){
        // this.resource.settings = JSON.parse(this.resource.settings)
        console.log(this.resource)
        axios.put(`/api/facility/resource/${this.resource.id}`, this.resource).then(res =>{
          console.log(res.data)
          if(res.data.success == true) {
            // Flash success message
            toastr.success('Updated Successfully into template.')
            this.fetchResources()
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
      remove: function(resource){
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
                axios.delete(`/api/facility/resource/${resource}`).then(res => {
                  console.log(res.data)
                    if( res.data.success == true ){
                        toastr.success("Resource Deleted Successfully")
                        self.fetchResources()
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