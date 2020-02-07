<template>
	<div class="wrapper">
	   <h1>Court</h1>

       <div class="table-responsive" v-if="courts.length > 0">
           <table 
               id="database-table" 
               class="table table-striped table-bordered database-tables" 
               style="width:100%">
               <thead>
                   <tr>
                       <th></th>
                       <th>Court 1</th>
                       <th>Court 2</th>
                       <th>Court 3</th>
                       <th>Court 4</th>
                   </tr>
               </thead>
               <tbody>
                   <tr v-for="(court, index) in courts" :key="index" :data-id="index+1">
                       <td>{{ court.time }}</td>
                       <td
                            @click.prevent="showAddEditModal(court)" 
                            data-toggle="modal" 
                            data-target="#addEditModal"
                            aria-hidden="true"></td>
                       <td
                            @click.prevent="showAddEditModal(court)" 
                            data-toggle="modal" 
                            data-target="#addEditModal"
                            aria-hidden="true"></td>
                       <td
                            @click.prevent="showAddEditModal(court)" 
                            data-toggle="modal" 
                            data-target="#addEditModal"
                            aria-hidden="true"></td>
                       <td
                            @click.prevent="showAddEditModal(court)" 
                            data-toggle="modal" 
                            data-target="#addEditModal"
                            aria-hidden="true"></td>
                   </tr>
               </tbody>
               <tfoot>
                   <tr>
                       <th></th>
                       <th>Court 1</th>
                       <th>Court 2</th>
                       <th>Court 3</th>
                       <th>Court 4</th>
                   </tr>
               </tfoot>
           </table>
       </div>
       <court-modals
        :addCourt="addCourt"
        :updateCourt="updateCourt"></court-modals>
	</div>
</template>

<script>
    import CourtModals from '../../views/modals/CourtModals.vue';
    // Set Default functionality for all vue components
    export default {
        components: {
            CourtModals
        },
        data() {
            return {
                courts: [
                    {time: 'all-day'},
                    {time: '6am'},
                    {time: '7am'},
                    {time: '8am'},
                    {time: '9am'},
                    {time: '10am'},
                    {time: '11am'},
                    {time: '12pm'},
                    {time: '1pm'},
                    {time: '2pm'},
                    {time: '3pm'},
                    {time: '4pm'},
                    {time: '5pm'},
                    {time: '6pm'},
                    {time: '7pm'},
                    {time: '8pm'},
                    {time: '9pm'},
                    {time: '10pm'},
                ]
            }
        },
        created(){},
        methods: {
            showAddEditModal: function(court){
                console.log(court)
            },
            addCourt: function(){

            },
            updateCourt: function(){
                
            }
        },
        mounted() {},
    }
</script>

<style>
</style>