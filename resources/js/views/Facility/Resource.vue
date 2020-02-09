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
          data-target="#addEditResourceModal"> <i class="fas fa-plus"></i>Add Resource</a>
      <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Booking Sheet</th>
                        <th>Title</th>
                        <th>type</th>
                        <th>Business Hours</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(resource,index) in resources" :key="index" :data-id="index+1">
                      <td>{{ resource.booking.title }}</td>
                      <td>{{ resource.title }}</td>
                      <td>{{ resource.type }}</td>
                      <td>{{ resource.business_hours }}</td>
                      <td class="action">
                          <a 
                            href="#" 
                            class="btn btn-info" 
                            @click.prevent="viewResource(index)" 
                            data-toggle="modal" 
                            data-target="#viewResourceModal">View</a>
                          <a 
                            href="#" 
                            class="btn btn-success" 
                            @click.prevent="showEditForm(index)" 
                            data-toggle="modal" 
                            data-target="#addEditResourceModal">Edit</a>
                          <a 
                            @click.prevent="remove(resource.id)" 
                            class="btn btn-danger">Delete</a>
                      </td>
                  </tr>

                </tbody>
            </table>
      </div>

      <resource-modals 
        :action="action"
        :category="category"
        :resource="resource"
        :bookings="bookings"
        :addResource="addResource"
        :updateResource="updateResource"></resource-modals>

  </div>
</template>

<script>
  import ResourceModals from '../../views/modals/ResourceModals.vue';
  export default {
    components: {
      ResourceModals
    },
    data(){
      return {
        resources: [],
        resource: {
          title: '',
          type: '',
          business_hours : '',
          booking: {
            title: ''
          }
        },
        bookings: [],
        category: 'Create Resource',
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
        axios.get('/api/facility/resource/all').then(res =>{
          console.log(res.data)
          this.resources = res.data.resources
          this.bookings = res.data.bookings
          for(let resource of this.resources) {
            resource.business_hours = JSON.stringify(resource.business_hours, null, 4);
          }
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