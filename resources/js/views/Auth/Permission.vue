<template>
	<div class="container-fluid">
	    <!-- Button trigger modal -->
	    <a
	        href="#" 
	        class="btn btn-success" 
	        @click.prevent="showCreateForm()" 
	        data-toggle="modal" 
	        data-target="#addEditPermissionModal"> <i class="fas fa-plus"></i>Create new Permission</a>

	    <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Guard name</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
	                <tr v-for="(permission,index) in permissions" :key="index" :data-id="index+1">
	                    <td>{{ permission.name }}</td>
	                    <td>{{ permission.guard_name }}</td>
	                    <td class="action">
	                        <a 
	                        	href="#" 
						        class="btn btn-info" 
						        @click.prevent="viewPermission(index)" 
						        data-toggle="modal" 
						        data-target="#viewPermissionModal">View</a>
	                        <a 
	                        	href="#" 
						        class="btn btn-success" 
						        @click.prevent="showEditForm(index)" 
						        data-toggle="modal" 
						        data-target="#addEditPermissionModal">Edit</a>
	                        <a 
	               				@click.prevent="remove(permission.id)" 
	                        	class="btn btn-danger">Delete</a>
	                    </td>
	                </tr>

                </tbody>
            </table>
	    </div>

	    <permission-modals 
			:action="action"
			:category="category"
	    	:permission="permissionData"
	    	:addPermission="addPermission"
	    	:updatePermission="updatePermission"></permission-modals>

	</div>
</template>

<script>
	import PermissionModals from '../../views/modals/PermissionModals.vue';
	export default {
		'name': 'permissions-data',
		components: {
			PermissionModals
		},
		data(){
			return {
				permissions: [],
				permissionData: {
					name: '',
					guard_name: ''
				},
				category: 'Create Permission',
				action: 'add',
			}
		},
		mounted(){
			axios.defaults.headers.common['Content-Type'] = 'application/json'
      		axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('playercoach.authToken');
			this.fetchPermissions()
		},
		methods: {
			fetchPermissions: function(){
				axios.get('/api/permissions/all').then(res =>{
					this.permissions = res.data.permissions
				});
			},
			showCreateForm: function(){
				this.action = "add"
				this.category = "Create"
				this.permissionData = {name:'', guard_name: ''}
			},
			showEditForm: function(index){
				console.log(index)
				this.action = "edit"
				this.category = "Update"
				this.permissionData = this.permissions[index]
			},
			viewPermission: function(index){
				this.permissionData = this.permissions[index]
			},
			addPermission: function(){
				axios.post('/api/permission', {
					name: this.permissionData.name,
					guard_name: this.permissionData.permission
				}).then(res =>{
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Added Successfully into template.')
	                  this.fetchPermissions()
	                  this.closeModal()
	                }
	              })
	              .catch(err => this.displayError(err.response));
			},
			updatePermission: function(){
				console.log(this.permissionData.id)
				axios.put(`/api/permission/${this.permissionData.id}`, this.permissionData).then(res =>{
					console.log(res.data)
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Updated Successfully into template.')
	                  this.fetchPermissions()
	                  this.closeModal()
	                }
	              })
	              .catch(err => this.displayError(err.response));
			},
			remove: function(permission){
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
                        axios.delete(`/api/permission/${permission}`).then(res => {
                            if( res.data.success == true ){
                                toastr.success("Permission Deleted Successfully")
                                self.fetchPermissions()
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