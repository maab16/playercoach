<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditResourceModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addResource() : updateResource()">
                    	     <div class="form-group">
                               <label for="permissions" class="col-form-lebel text-md-right">Booking Sheet</label>
                               <multiselect
                                   v-model="resource.booking" 
                                   :options="bookings"
                                   :multiple="false" 
                                   :close-on-select="true" 
                                   :clear-on-select="false" 
                                   :preserve-search="true" 
                                   placeholder="'Pick Booking Sheet'" 
                                   label="title" 
                                   track-by="title" 
                                   :preselect-first="false"
                                   id="booking_sheet"></multiselect>
                           </div>
                             <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="resource.title" class="form-control" placeholder="Resource Title">
                              </div>
                              <div class="form-group">
                                <label for="title">Type</label>
                                <input type="text" v-model="resource.type" class="form-control" placeholder="Resource Type">
                              </div>
                              <div class="form-group">
                                <label for="title">Business Hours (JSON Formate Data)</label>
                                <textarea class="form-control" v-model="resource.business_hours" placeholder="Resource Business Hours" rows="5"></textarea>
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

        <div class="modal fade" id="viewResourceModal">
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
			resource: Object,
      bookings: Array,
			action: String,
			category: String,
			addResource: Function,
			updateResource: Function,
		}
    }
</script>