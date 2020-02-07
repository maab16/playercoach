<template>
	<div class="row">
	 <div class="col-sm-12">
        <div class="modal fade" id="addEditModal">
            <div class="modal-dialog view-modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      	<h4 class="modal-title font-weight-bold">Book Court</h4>
                      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       	 <span aria-hidden="true">&times;</span>
                      	</button>
                    </div>
                    <div class="modal-body">
                        <p>You are requesting Court 2 on Friday, February 07 from 8:00 pm to 9:00 pm ?</p>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_type">Practice type:</label>
                                        <select name="project_type" id="project_type" class="form-control">
                                            <option value="open" selected="selected">Open (others can join)</option>
                                            <option value="closed">Closed (only you can add people)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_reg">Max Registrants:</label>
                                        <select name="max_reg" id="max_reg" class="form-control">
                                            <option value="0">Please select</option>
                                            <option value="1">1 (Solo Practice)</option>
                                            <option value="2">2 (Singles)</option>
                                            <option value="3">3 (2on1)</option>
                                            <option value="4">4 (doubles)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="players">Add Players</label>
                                        <input type="text" name="players" id="players" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Book it</button>
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
			addCourt: Function,
			updateCourt: Function,
		}
    }
</script>