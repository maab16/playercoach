<template>
	<div class="container-fluid">
	    <!-- Button trigger modal -->
	    <a
	        href="#" 
	        class="btn btn-success" 
	        @click.prevent="showCreateForm()" 
	        data-toggle="modal" 
	        data-target="#addEditUserModal"> <i class="fas fa-plus"></i>Create new User</a>

	    <div 
            class="errors alert alert-danger mt-3" 
            role="alert" 
            v-for="(error,key) in errors" 
            :key="key"> {{ error }} </div>

	    <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered database-tables" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
	                <tr v-for="(user,index) in users" :key="index" :data-id="index+1">
	                    <td>{{ user.name }}</td>
	                    <td>{{ user.email }}</td>
	                    <td>
	                    	<ul v-if="user.roles.length > 0">
	                    		<li v-for="(role,index) in user.roles" :key="index">{{ role.name }}</li>
	                    	</ul>
	                    </td>
	                    <td class="action">
	                        <a 
	                        	href="#" 
						        class="btn btn-info" 
						        @click.prevent="viewUser(index)" 
						        data-toggle="modal" 
						        data-target="#viewUserModal">View</a>
	                        <a 
	                        	href="#" 
						        class="btn btn-success" 
						        @click.prevent="showEditForm(index)" 
						        data-toggle="modal" 
						        data-target="#addEditUserModal">Edit</a>
	                        <a 
	               				@click.prevent="remove(user.id)" 
	                        	class="btn btn-danger">Delete</a>
	                    </td>
	                </tr>

                </tbody>
            </table>
	    </div>

	    <user-modals 
			:action="action"
			:category="category"
	    	:user="user"
	    	:roles="roles"
	    	:addUser="addUser"
	    	:updateUser="updateUser"></user-modals>

	</div>
</template>

<script>
	import UserModals from '../views/modals/UserModals.vue';
	export default {
		'name': 'users-data',
		components: {
			UserModals
		},
		data(){
			return {
				users: [],
				roles: [],
				user: {
					name: '',
					email: '',
					password: '',
					password_confirmation: '',
					roles: []
				},
				category: 'Create User',
				action: 'add',
				errors: [],
			}
		},
		mounted(){
			this.fetchUsers()
		},
		methods: {
			fetchUsers: function(){
				axios.get('/users/all').then(res =>{
					console.log(res.data)
					this.users = res.data.users
					this.roles = []
					for(let role of res.data.roles) {
						this.roles.push({
							name: role.name,
							id: role.id
						});
					}
					
				});
			},
			showCreateForm: function(){
				this.action = "add"
				this.category = "Create User"
				this.user = {
					name:'', 
					email: '', 
					password: '', 
					password_confirmation: '', 
					roles: []
				}
			},
			showEditForm: function(index){
				console.log(index)
				this.action = "edit"
				this.category = "Update User"
				this.user = this.users[index]
			},
			viewUser: function(index){
				this.user = this.users[index]
			},
			addUser: function(){
				axios.post('user', this.user).then(res =>{
					console.log(res.data)
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Added Successfully into template.')
	                  this.fetchUsers()
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
			updateUser: function(){
				console.log(this.user)
				axios.put(`/user/${this.user.id}`, this.user).then(res =>{
					console.log(res.data)
	                if(res.data.success == true) {
	                  // Flash success message
	                  toastr.success('Updated Successfully into template.')
	                  this.fetchUsers()
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
			remove: function(user){
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
                        axios.delete(`/user/${user}`).then(res => {
                        	console.log(res.data)
                            if( res.data.success == true ){
                                toastr.success("User Deleted Successfully")
                                self.fetchUsers()
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