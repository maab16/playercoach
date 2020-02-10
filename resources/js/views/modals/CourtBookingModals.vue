<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditCourtBookingModal">
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
                                   v-model="court_booking.booking" 
                                   :options="resources"
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
                                <input type="text" v-model="court_booking.title" class="form-control" placeholder="Resource Title">
                              </div>
                              <div class="form-group">
                                <label for="title">Type</label>
                                <input type="text" v-model="court_booking.type" class="form-control" placeholder="Resource Type">
                              </div>
                              <div class="form-group">
                                <label for="title">Business Hours (JSON Formate Data)</label>
                                <textarea class="form-control" v-model="court_booking.business_hours" placeholder="Resource Business Hours" rows="5"></textarea>
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

        <div class="modal fade" id="viewCourtBookingModal">
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
			court_booking: Object,
      resources: Array,
			action: String,
			category: String,
			addResource: Function,
			updateResource: Function,
		}
    }
</script>