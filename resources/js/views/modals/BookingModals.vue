<template>
	<div class="row">
	 <div class="col-sm-12">
	 	<!-- View -->
		<div class="modal fade" id="addEditBookingModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">{{ category }}</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">

                    	<form v-on:submit.prevent="action == 'add' ? addBooking() : updateBooking()">
                    	    
                             <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="booking.title" class="form-control" placeholder="Booking Title">
                              </div>
                              <div class="form-group">
                                <label for="title">Settings (PUT valid JSON)</label>
                                <textarea class="form-control" v-model="booking.settings" placeholder="Booking Settings" rows="5"></textarea>
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

        <div class="modal fade" id="viewBookingModal">
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
			booking: Object,
			action: String,
			category: String,
			addBooking: Function,
			updateBooking: Function,
		}
    }
</script>