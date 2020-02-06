<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditPermissionModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addPermission() : updatePermission()">
                    	    <div class="form-group">
                    	        <label for="name" class="col-form-label text-md-right">Name</label>
                    	        <input
                    	            id="name"
                    	            type="text"
                    	            class="form-control"
                    	            name="name"
                    	            v-model="permission.name"
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
                    	            v-model="permission.guard_name"
                    	            autocomplete="guard_name"
                    	            autofocus>
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

        <div class="modal fade" id="viewPermissionModal">
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
                                v-model="permission.name"
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
                                v-model="permission.guard_name"
                                autocomplete="guard_name"
                                disabled="disabled"
                                autofocus>
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
			permission: Object,
			action: String,
			category: String,
			addPermission: Function,
			updatePermission: Function,
		}
    }
</script>