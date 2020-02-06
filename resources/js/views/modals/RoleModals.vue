<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditRoleModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addRole() : updateRole()">
                    	    <div class="form-group">
                    	        <label for="name" class="col-form-label text-md-right">Name</label>
                    	        <input
                    	            id="name"
                    	            type="text"
                    	            class="form-control"
                    	            name="name"
                    	            v-model="role.name"
                    	            autocomplete="name"
                    	            autofocus>
                    	    </div>

                    	    <div class="form-group">
                    	        <label for="guard_name" class="col-form-label text-md-right">Guard name</label>
                    	        <input
                    	            id="guard_name"
                    	            type="text"
                    	            class="form-control"
                    	            name="guard_name"
                    	            v-model="role.guard_name"
                    	            autocomplete="guard_name"
                    	            autofocus>
                    	    </div>

                            <div class="form-group">
                                <label for="permissions" class="col-form-lebel text-md-right">Permission</label>
                                <multiselect
                                    v-model="role.permissions" 
                                    :options="permissions"
                                    multiple="multiple" 
                                    :close-on-select="true" 
                                    :clear-on-select="false" 
                                    :preserve-search="true" 
                                    placeholder="'Pick Permission'" 
                                    label="name" 
                                    track-by="name" 
                                    :preselect-first="false"
                                    id="permission"></multiselect>
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

        <div class="modal fade" id="viewRoleModal">
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
                            <label for="name" class="col-form-label text-md-right">Name</label>
                            <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="name"
                                v-model="role.name"
                                autocomplete="name"
                                disabled="disabled"
                                autofocus>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="col-form-label text-md-right">Guard name</label>
                            <input
                                id="guard_name"
                                type="text"
                                class="form-control"
                                name="guard_name"
                                v-model="role.guard_name"
                                autocomplete="guard_name"
                                disabled="disabled"
                                autofocus>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="col-form-label text-md-right">Permissions</label>
                            <ul v-if="role.permissions.length > 0">
                                <li v-for="(permission,index) in role.permissions" :key="index">{{ permission.name }}</li>
                            </ul>
                        </div>

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
			role: Object,
            permissions: Array,
			action: String,
			category: String,
			addRole: Function,
			updateRole: Function,
		},
        data(){
            return {
                // userPermissions: this.role.permissions
            }
        }
    }
</script>

<style scoped="scoped">
    .select2 {
        width: 100% !important;
    }
</style>