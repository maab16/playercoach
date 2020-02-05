<div class="modal fade" id="modal-plan-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" v-if="detailingPlan">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    @{{ detailingPlan.name }}
                </h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <ul class="plan-feature-list p-0 m-0">
                    <li v-for="(feature, index) in detailingPlan.features" :key="index">
                        <input type="checkbox" :name="'feature_'+index+1" :id="'feature_'+index+1">
                        <label :for="'feature_'+index+1">@{{ feature }}</label>
                    </li>
                </ul>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>