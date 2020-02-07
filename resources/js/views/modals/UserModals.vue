<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditUserModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addUser() : updateUser()">
                    	    
                            <div class="form-group">
                                <label for="name" class="col-form-label text-md-right">Name</label>
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    v-model="user.name"
                                    autocomplete="name"
                                    autofocus>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right">E-Mail Address</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    v-model="user.email"
                                    autocomplete="email">
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-right">Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    v-model="user.password"
                                    autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label
                                    for="password-confirm"
                                    class="col-form-label text-md-right">Confirm Password</label>
                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    v-model="user.password_confirmation"
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="roles" class="col-form-lebel text-md-right">Role</label>
                                <multiselect
                                    v-model="user.roles" 
                                    :options="roles"
                                    multiple="multiple" 
                                    :close-on-select="true" 
                                    :clear-on-select="false" 
                                    :preserve-search="true" 
                                    placeholder="'Pick Permission'" 
                                    label="name" 
                                    track-by="name" 
                                    :preselect-first="false"
                                    id="role"></multiselect>
                            </div>

                    	    <div class="form-group">
                    	      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    	      <button type="submit" class="btn btn-success">{{ action }}</button>
                    	    </div>
                    	</form>
                    </div>
               </div>
            </div>
        </div>

        <div class="modal fade" id="viewUserModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
               </div>
            </div>
        </div>

	  </div>
	</div>
</template>
<script>

	export default {
		props: {
			user: Object,
            roles: Array,
			action: String,
			category: String,
			addUser: Function,
			updateUser: Function,
		}
    }
</script>