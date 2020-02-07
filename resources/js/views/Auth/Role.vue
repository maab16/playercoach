<template>
	<div class="container-fluid">
	    <!-- Button trigger modal -->
	    <a
	        href="#" 
	        class="btn btn-success" 
	        @click.prevent="showCreateForm()" 
	        data-toggle="modal" 
	        data-target="#addEditRoleModal"> <i class="fas fa-plus"></i>Create new role</a>

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
	                <tr v-for="(role,index) in roles" :key="index" :data-id="index+1">
	                    <td>{{ role.name }}</td>
	                    <td>{{ role.guard_name }}</td>
	                    <td class="action">
	                        <a 
	                        	href="#" 
						        class="btn btn-info" 
						        @click.prevent="viewRole(index)" 
						        data-toggle="modal" 
						        data-target="#viewRoleModal">View</a>
	                        <a 
	                        	href="#" 
						        class="btn btn-success" 
						        @click.prevent="showEditForm(index)" 
						        data-toggle="modal" 
						        data-target="#addEditRoleModal">Edit</a>
	                        <a 
	               				@click.prevent="remove(role.id)" 
	                        	class="btn btn-danger">Delete</a>
	                    </td>
	                </tr>

                </tbody>
            </table>
	    </div>

	    <role-modals 
	    	v-if="isRender"
			:action="action"
			:category="category"
	    	:role="roleData"
	    	:permissions="permissions"
	    	:rolePermissions="rolePermissions"
	    	:addRole="addRole"
	    	:updateRole="updateRole"></role-modals>

	</div>
</template>

<script>
	import RoleModals from '../../views/modals/RoleModals.vue';
	export default {
		'name': 'roles-data',
		components: {
			RoleModals
		},
		data(){
			return {
				isRender: false,
				roles: [],
				permissions: [],
				rolePermissions: [],
				roleData: {
					name: '',
					guard_name: '',
					permissions: []
				},
				category: 'Create role',
				action: 'add',
			}
		},
		mounted(){
			this.fetchRoles()
		},
		methods: {
			fetchRoles: function(){
				axios.get('/roles/all').then(res =>{
					this.roles = res.data.roles
					let rolePermissions = [];
					for(let permission of res.data.permissions) {
						rolePermissions.push({
                            name: permission.name, 
                            id: permission.id
                        });
					}
					this.permissions = rolePermissions
				});
			},
			showCreateForm: function(){
				this.action = "add"
				this.category = "Create"
				this.roleData = {name:'', guard_name: '', permissions: []}
				this.forceRerender()
			},
			showEditForm: function(index){
				console.log(index)
				this.isRender = false

				this.action = "edit"
				this.category = "Update"
				let role = this.roles[index]

				axios.get(`/roles/${role.id}/rolePermissions`).then(res =>{
					// console.log(res.data)
					let rolePermissions = [];
					for(let permission of res.data.permissions) {
						rolePermissions.push({
                            name: permission.name, 
                            id: permission.id
                        });
					}
					this.roleData = {
						id: role.id,
						name: role.name,
						guard_name: role.guard_name,
						permissions: rolePermissions
					} 
				});
				// this.isRender = true
				this.forceRerender()
			},
			viewRole: function(index){

				let role = this.roles[index]

				axios.get(`/roles/${role.id}/rolePermissions`).then(res =>{
					// console.log(res.data)
					let rolePermissions = [];
					for(let permission of res.data.permissions) {
						rolePermissions.push({
                            name: permission.name, 
                            id: permission.id
                        });
					}
					this.roleData = {
						id: role.id,
						name: role.name,
						guard_name: role.guard_name,
						permissions: rolePermissions
					} 
				});
				// this.isRender = true
				this.forceRerender()

			},
			addRole: function(){
				axios.post('/role', this.roleData).then(res =>{
					console.log(res.data)
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Added Successfully into template.')
	                  this.fetchRoles()
	                  this.closeModal()
	                }
	              })
	              .catch(err => this.displayError(err.response));
			},
			updateRole: function(){
				console.log(this.roleData)
				axios.put(`/role/${this.roleData.id}`, this.roleData).then(res =>{
					console.log(res.data)
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Updated Successfully into template.')
	                  this.fetchRoles()
	                  this.closeModal()
	                }
	              })
	              .catch(err => this.displayError(err.response));
			},
			remove: function(role){
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
                        axios.delete(`/role/${role}`).then(res => {
                            if( res.data.success == true ){
                                toastr.success("role Deleted Successfully")
                                self.fetchRoles()
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
			forceRerender() {
		        // Remove my-component from the DOM
		        this.isRender = false;
		        
		        this.$nextTick(() => {
		          // Add the component back in
		          this.isRender = true;
		        });
		      },
			closeModal: function(){
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
            },
		}
	}
</script>