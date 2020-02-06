<?php

namespace Corals\Modules\CourtBooking\Http\Controllers;

use Carbon\Carbon;
use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CourtBooking\DataTables\BookingsDataTable;
use Corals\Modules\CourtBooking\Http\Requests\BookingRequest;
use Corals\Modules\CourtBooking\Models\Booking;
use Corals\Modules\CourtBooking\Models\Resource;
use Corals\User\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class SchedulingController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('courtbooking.models.booking.resource_url');

        $this->title = 'CourtBooking::module.booking.title';
        $this->title_singular = 'CourtBooking::module.booking.title_singular';

        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function viewSheet($date = null)
    {
        //dd($date);
        if (user()->can('CourtBooking::courtmonitor.access')) {
            return $this->viewMonitorSheet($date);
        }
        $todaybeginning = Carbon::now()->setTimezone('America/Toronto')->setTime(0,0,0)->setTimezone('UTC');
        $maxdate = $todaybeginning->addWeek();
        $dbbookings = Booking::whereDate('start', '<=', $todaybeginning)->whereDate('start','<=', $maxdate)->with('groupUsers')->get();
        $dbresources = Resource::where('type', 'court')->get();
        $bookings = [];
        $resources = [];

        foreach ($dbresources as $dbresource) {
            $resources [] = Calendar::resource(
                $dbresource->title,
                $dbresource->id
            );
        }

        foreach ($dbbookings as $dbbooking) {

            $bookings[] = Calendar::event(
                $dbbooking->getTitle(), //event title
                false, //full day event?
                $dbbooking->resourceId,
                $dbbooking->resourceIds,
                $dbbooking->start, //start time (you can also use Carbon instead of DateTime)
                $dbbooking->end, //end time (you can also use Carbon instead of DateTime)
                $dbbooking->id, //optionally, you can specify an event ID
                ['color' => $dbbooking->belongstocurrentuser()? '#0C6CA1': ($dbbooking->open && count($dbbooking->groupUsers) < $dbbooking->max_participants? '#28a745': '#f00'),
                 'url' => $dbbooking->belongstocurrentuser()?  '/courtbooking/bookings/'.$dbbooking->hashedid.'/edit': (count($dbbooking->groupUsers)+1 < $dbbooking->max_particpants? '#addtogroup':'')]
            );
        }
        $calHeight = 860;
        $playersname = user()->first_name;


        $calendar = Calendar::setOptions([ //set fullcalendar options
            //'longPressDelay' => env('LONG_PRESS_DELAY'),
            'height' => $calHeight,
            'contentHeight' => $calHeight,
            'firstDay' => 1,
            'defaultDate' => $date != null? $date : Carbon::today()->toDateString(),
            'fixedWeekCount' => false,
            'schedulerLicenseKey'=> 'GPL-My-Project-Is-Open-Source',
            'defaultView'=> 'agendaDay',
            'snapDuration' => '00:60:00',
            //'slotLabelInterval' => '00:30:00',
            'titleFormat' => 'dddd, MMMM Do YYYY',
            'groupByResource' => true,
            'resources' => $resources,
            'nowIndicator' => true,
            'editable' => false,
            'selectable' => true,
            'selectHelper' => true,
            'minTime' => "06:00:00",
            'maxTime' => "23:00:00",
            'timeFormat' => 'h:mm',
            'displayEventTime'=> false,
            'timezone' => 'local',
            'eventOverlap' => false,
            //'selectConstraint' => isset($events4)? 'businesshours':null
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'selectOverlap' => 'function(event) {
                    return event.rendering === \'background\';
                }',
            'validRange' => 'function() {console.log(moment().stripTime);return {start: moment().stripTime().subtract('.\Settings::get('courtbooking_past_number_of_days', 0).', \'days\'), end: moment().stripTime().add('.\Settings::get('courtbooking_future_number_of_days', 7).', \'days\')};}',
            'viewRender' => 'function(view,element){if (view.start > moment(\''.$maxdate.'\')){$(\'#calendar-courtbooking\').fullCalendar(\'gotoDate\', moment(\''.$maxdate.'\'));} else if (view.start < moment(\''.$maxdate.'\') < view.end){$(\'.fc-day\').each(function() {if (moment($(this).attr(\'data-date\')) > moment(\''.$maxdate.'\')) {$(this).addClass(\'disabled\');}}); }}',
            'select' => 'function(start, end, jsEvent, view, resource) {if(start.isBefore(moment().minutes(0).seconds(0))) {$(\'#calendar-courtbooking\').fullCalendar(\'unselect\');return false;} $("#newbooking").modal("show"); $("#start1").val(start.format());$("#end2").val(end.format());$("#resourceId").val(resource.id);$("#resourcename").text(resource.title);$("#bookingday").text(moment(start).format("dddd, MMMM DD"));$("#bookingstart").text(moment(start).format("h:mm a"));$("#bookingend").text(moment(end).format("h:mm a"));}',
            'selectAllow' => 'function(selectInfo) { 
            strt = moment(selectInfo.start);
            ennd = moment(selectInfo.end);
         var duration = ennd.diff(strt, \'hours\', true);
         return (duration <= 1 && strt.minutes() == 0 && ennd.minutes()==0);}',
            'eventClick' => 'function(event) {if (event.url) {$(event.url).modal("show");$("#day").text(event.day);$("#startgroup").text(event.startdisp);$("#endgroup").text(event.enddisp);$("#practiceid").val(event.id);}}',
            'eventRender' => 'function(event, element) {
        var title = element.find(\'.fc-title, .fc-list-item-title\');          
        title.html(title.text());
       element.find(".fc-bg").css("pointer-events","none");
       var calid = $(\'.fc-unthemed\').attr(\'id\');
       if(event.mine || event.partof){
            element.append("<div style=\'position:absolute;top:0px;right:0px;z-index: 10000;\' ><button type=\'button\' class=\'close text-danger btn btnDeleteEvent\' aria-label=\'Cancel Practice\'>&times;</button></div>" );
            if(event.confirmed == false){
                element.append("<div class=\'clearfix\'></div> <a class=\'btn btn-success btn-confirm confirmation\' href=\'/courtbooking/confirm/" + event.id + "\' id=\'204\' role=\'button\'>Confirm</a>");
            }
       }
       
       if(event.confirmed == false){
            element.find(".btn-confirm").click(function(e){
                e.preventDefault();
                clickedbutton = $(this);
                var href = $( this ).attr(\'href\');
                $.ajax({
                    url: href,
                    type: \'GET\',
                    success: function(response){
                        //code to delete confirm button
                        //code to change event color to green
                        clickedbutton.remove();
                        event.color = \'#28a745\';
                        event.confirmed = true;
                        $(\'#calendar-courtbooking\').fullCalendar(\'updateEvent\', event);
                         $(\'#ajaxeditsuccess\').html(response.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function () {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    error:function(data){
                    }
                });
            });
       }
       
       if(event.mine){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to cancel the \' + moment(event.start).format("h:mm a") + \' booking from your schedule?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( data ) {
                        //remove event from calendar
                        $(\'#calendar-courtbooking\').fullCalendar(\'removeEvents\',event._id);
                        //provide confirmation message.
                        $(\'#ajaxeditsuccess\').html(data.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
        if(event.partof){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to remove yourself from the \' + moment(event.start).format("h:mm a") + \' from this booking ?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( response ) {
                        console.log(response);
            var mEvent = {
                title: response.title,
                allDay: false,
                start: response.start.date,
                end: response.end.date,
                id: response.id,
                color: response.color,
                url: response.url,
                partof: response.partof,
                day: response.day,
                startdisp: response.startdisp,
                enddisp: response.enddisp
            };
            $(\'#addtogroup\').modal(\'hide\');
            $(\'#ajaxeditsuccess\').html(response.message);
            $(\'#ajaxeditsuccess\').show();
            setTimeout(function () {
                $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
            }, 4000);
            $(\'#\' + calid + \'\').fullCalendar(\'removeEvents\', response.id);
            $(\'#\' + calid + \'\').fullCalendar(\'renderEvent\', mEvent, false);
       

                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
       }'])->setId('courtbooking');

        if (!is_null($bookings)) {
            $calendar->addEvents($bookings);
        }

        return view('CourtBooking::scheduler.bookingsheet', compact('calendar'))->with('date', $date);
    }
    public function viewResourceSheet($date = null)
    {

        if (user()->can('CourtBooking::resourcemonitor.access')) {
            return $this->viewMonitorResourceSheet();
        }
        $todaybeginning = Carbon::now()->setTimezone('America/Toronto')->setTime(0,0,0)->setTimezone('UTC');
        $maxdate = $todaybeginning->addWeek();
        $dbbookings = Booking::whereDate('start', '<=', $todaybeginning)->whereDate('start','<=', $maxdate)->with('groupUsers')->get();
        $dbresources = Resource::where('type', '!=','court')->get();
        $bookings = [];
        $resources = [];

        foreach ($dbresources as $dbresource) {
            $resources [] = Calendar::resource(
                $dbresource->title,
                $dbresource->id
            );
        }

        foreach ($dbbookings as $dbbooking) {
            $title = $dbbooking->belongstocurrentuser()? 'My Booking - '.user()->getFullNameAttribute(): ($dbbooking->open? 'Open':'Unavailable');
            if (count($dbbooking->groupUsers)>0){
                $title.= ', ';
                foreach ($dbbooking->groupUsers as $user){
                    $title .= $user->name.' '.$user->last_name;
                    if ($user == $dbbooking->groupUsers->last()){
                        $title .= '. ';
                    }
                    else {
                        $title .= ', ';

                    }
                }
            }
            else {
                $title .= '. ';
            }

            $title .= '('.($dbbooking->max_participants - (count($dbbooking->groupUsers)+1)).' spots available)';

            $bookings[] = Calendar::event(
                $title, //event title
                false, //full day event?
                $dbbooking->resourceId,
                $dbbooking->start, //start time (you can also use Carbon instead of DateTime)
                $dbbooking->end, //end time (you can also use Carbon instead of DateTime)
                $dbbooking->id, //optionally, you can specify an event ID
                ['color' => $dbbooking->belongstocurrentuser()? '#0C6CA1': ($dbbooking->open && count($dbbooking->groupUsers) < $dbbooking->max_participants? '#28a745': '#f00'),
                 'url' => $dbbooking->belongstocurrentuser()?  '/courtbooking/bookings/'.$dbbooking->hashedid.'/edit': (count($dbbooking->groupUsers)+1 < $dbbooking->max_particpants? '#addtogroup':'')]
            );
        }
        $calHeight = 860;
        $playersname = user()->first_name;


        $calendar = Calendar::setOptions([ //set fullcalendar options
            //'longPressDelay' => env('LONG_PRESS_DELAY'),
            'height' => $calHeight,
            'contentHeight' => $calHeight,
            'firstDay' => 1,
            'defaultDate' => $date != null? $date:Carbon::today()->toIso8601String(),
            'fixedWeekCount' => false,
            'schedulerLicenseKey'=> 'GPL-My-Project-Is-Open-Source',
            'defaultView'=> 'agendaDay',
            'snapDuration' => '00:60:00',
            //'slotLabelInterval' => '00:30:00',
            'titleFormat' => 'dddd, MMMM Do YYYY',
            'groupByResource' => true,
            'resources' => $resources,
            'nowIndicator' => true,
            'editable' => false,
            'selectable' => true,
            'selectHelper' => true,
            'minTime' => "06:00:00",
            'maxTime' => "23:00:00",
            'timeFormat' => 'h:mm',
            'displayEventTime'=> false,
            'timezone' => 'local',
            'eventOverlap' => false,
            //'selectConstraint' => isset($events4)? 'businesshours':null
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'selectOverlap' => 'function(event) {
                    return event.rendering === \'background\';
                }',
            'validRange' => 'function() {console.log(moment().stripTime);return {start: moment().stripTime().subtract('.\Settings::get('courtbooking_past_number_of_days', 0).', \'days\'), end: moment().stripTime().add('.\Settings::get('courtbooking_future_number_of_days', 7).', \'days\')};}',
            'viewRender' => 'function(view,element){if (view.start > moment(\''.$maxdate.'\')){$(\'#calendar-courtbooking\').fullCalendar(\'gotoDate\', moment(\''.$maxdate.'\'));} else if (view.start < moment(\''.$maxdate.'\') < view.end){$(\'.fc-day\').each(function() {if (moment($(this).attr(\'data-date\')) > moment(\''.$maxdate.'\')) {$(this).addClass(\'disabled\');}}); }}',
            'select' => 'function(start, end, jsEvent, view, resource) {if(start.isBefore(moment().minutes(0).seconds(0))) {$(\'#calendar-courtbooking\').fullCalendar(\'unselect\');return false;} $("#newbooking").modal("show"); $("#start1").val(start.format());$("#end2").val(end.format());$("#resourceId").val(resource.id);$("#resourcename").text(resource.title);$("#bookingday").text(moment(start).format("dddd, MMMM DD"));$("#bookingstart").text(moment(start).format("h:mm a"));$("#bookingend").text(moment(end).format("h:mm a"));}',
            'selectAllow' => 'function(selectInfo) { 
            strt = moment(selectInfo.start);
            ennd = moment(selectInfo.end);
         var duration = ennd.diff(strt, \'hours\', true);
         return (duration <= 1 && strt.minutes() == 0 && ennd.minutes()==0);}',
            'eventClick' => 'function(event) {if (event.url) {$(event.url).modal("show");$("#day").text(event.day);$("#startgroup").text(event.startdisp);$("#endgroup").text(event.enddisp);$("#practiceid").val(event.id);}}',
            'eventRender' => 'function(event, element) {
        var title = element.find(\'.fc-title, .fc-list-item-title\');          
        title.html(title.text());
       element.find(".fc-bg").css("pointer-events","none");
       var calid = $(\'.fc-unthemed\').attr(\'id\');
       if(event.mine || event.partof){
            element.append("<div style=\'position:absolute;top:0px;right:0px;z-index: 10000;\' ><button type=\'button\' class=\'close text-danger btn btnDeleteEvent\' aria-label=\'Cancel Practice\'>&times;</button></div>" );
            if(event.confirmed == false){
                element.append("<div class=\'clearfix\'></div> <a class=\'btn btn-success btn-confirm confirmation\' href=\'/courtbooking/confirm/" + event.id + "\' id=\'204\' role=\'button\'>Confirm</a>");
            }
       }
       
       if(event.confirmed == false){
            element.find(".btn-confirm").click(function(e){
                e.preventDefault();
                clickedbutton = $(this);
                var href = $( this ).attr(\'href\');
                $.ajax({
                    url: href,
                    type: \'GET\',
                    success: function(response){
                        //code to delete confirm button
                        //code to change event color to green
                        clickedbutton.remove();
                        event.color = \'#28a745\';
                        event.confirmed = true;
                        $(\'#calendar-courtbooking\').fullCalendar(\'updateEvent\', event);
                         $(\'#ajaxeditsuccess\').html(response.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function () {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    error:function(data){
                    }
                });
            });
       }
       
       if(event.mine){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to cancel the \' + moment(event.start).format("h:mm a") + \' booking from your schedule?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( data ) {
                        //remove event from calendar
                        $(\'#calendar-courtbooking\').fullCalendar(\'removeEvents\',event._id);
                        //provide confirmation message.
                        $(\'#ajaxeditsuccess\').html(data.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
        if(event.partof){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to remove yourself from the \' + moment(event.start).format("h:mm a") + \' from this booking ?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( response ) {
                        console.log(response);
            var mEvent = {
                title: response.title,
                allDay: false,
                start: response.start.date,
                end: response.end.date,
                id: response.id,
                color: response.color,
                url: response.url,
                partof: response.partof,
                day: response.day,
                startdisp: response.startdisp,
                enddisp: response.enddisp
            };
            $(\'#addtogroup\').modal(\'hide\');
            $(\'#ajaxeditsuccess\').html(response.message);
            $(\'#ajaxeditsuccess\').show();
            setTimeout(function () {
                $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
            }, 4000);
            $(\'#\' + calid + \'\').fullCalendar(\'removeEvents\', response.id);
            $(\'#\' + calid + \'\').fullCalendar(\'renderEvent\', mEvent, false);
       

                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
       }'])->setId('courtbooking');

        if (!is_null($bookings)) {
            $calendar->addEvents($bookings);
        }

        return view('CourtBooking::scheduler.bookingsheet', compact('calendar'));
    }

    public function makebooking(Request $request) {
        $this->validate($request, [
           'start' => 'required',
           'end' => 'required',
           'resourceId' => 'required',
        ]);

        $booking = new Booking();
        $booking->start = Carbon::parse($request->start)->tz('UTC');
        $booking->end = Carbon::parse($request->end)->tz('UTC');
        $resourceIds =[];
        $resourceIds [] = $request->resourceId;
                if ($request->court1 == 'booked'){if(!in_array("1", $resourceIds)){$resourceIds[]="1";}}
                if ($request->court2 == 'booked'){if(!in_array("2", $resourceIds)){$resourceIds[]="2";}}
                if ($request->court3 == 'booked'){if(!in_array("3", $resourceIds)){$resourceIds[]="3";}}
                if ($request->court4 == 'booked'){if(!in_array("4", $resourceIds)){$resourceIds[]="4";}}
        $resourceIds = array_unique($resourceIds);
        $booking->resourceId = empty($resourceIds)?$request->resourceId:null;
        $booking->resourceIds = !empty($resourceIds)?$resourceIds:null;
        $booking->title = $request->title or null;
        $booking->open = $request->booking_type == 'closed'? 0:1;
        $booking->max_participants = $request->max_reg or 4;
        if($request->booking_owner != null){
            $user = User::find($request->booking_owner);
        }
        else {
            $user = user();
        }
        $user->booking()->save($booking);

        $booking->groupUsers()->sync($request->user_id);
        return redirect()->route('booking.sheet', ['date'=>$booking->start->tz("America/Toronto")->toDateString()]);//action('\Corals\Modules\CourtBooking\Http\Controllers\SchedulingController@viewSheet', ['date' => $booking->start->tz("America/Toronto")->toDateString()]);
    }

    public function viewMonitorSheet($date = null)
    {
        //dd($date);
        if (!user()->can('CourtBooking::courtmonitor.access')) {
            return $this->viewSheet();
        }
        $todaybeginning = Carbon::now()->setTimezone('America/Toronto')->setTime(0,0,0)->setTimezone('UTC');
        $maxdate = $todaybeginning->copy()->addWeek();
        $dbbookings = Booking::whereDate('start','>=', $todaybeginning)->whereDate('start','<=', $maxdate)->with('groupUsers')->with('user')->get();
        $dbresources = Resource::where('type', 'court')->get();
        $bookings = [];
        $resources = [];

        foreach ($dbresources as $dbresource) {
            $resources [] = Calendar::resource(
                $dbresource->title,
                $dbresource->id
            );
        }

        foreach ($dbbookings as $dbbooking) {
            $bookings[] = Calendar::event(
                $dbbooking->getTitle(), //event title
                false, //full day event?
                $dbbooking->resourceId,
                $dbbooking->resourceIds,
                $dbbooking->start, //start time (you can also use Carbon instead of DateTime)
                $dbbooking->end, //end time (you can also use Carbon instead of DateTime)
                $dbbooking->id, //optionally, you can specify an event ID
                ['color' => ($dbbooking->open && (count($dbbooking->groupUsers) + 1) < $dbbooking->max_participants? '#28a745': '#f00'),
                    'url' => '/courtbooking/bookings/'.$dbbooking->hashedid.'/edit']
            );
        }
        $calHeight = 860;
        $playersname = user()->first_name;


        $calendar = Calendar::setOptions([ //set fullcalendar options
            //'longPressDelay' => env('LONG_PRESS_DELAY'),
            'height' => $calHeight,
            'contentHeight' => $calHeight,
            'firstDay' => 1,
            'defaultDate' => $date != null? $date:Carbon::today()->toDateString(),
            'fixedWeekCount' => false,
            'schedulerLicenseKey'=> 'GPL-My-Project-Is-Open-Source',
            'defaultView'=> 'agendaDay',
            //'snapDuration' => '00:60:00',
            //'slotLabelInterval' => '00:30:00',
            'titleFormat' => 'dddd, MMMM Do YYYY',
            'groupByResource' => true,
            'resources' => $resources,
            'nowIndicator' => true,
            'editable' => false,
            'selectable' => true,
            'selectHelper' => true,
            'minTime' => "06:00:00",
            'maxTime' => "23:00:00",
            'timeFormat' => 'h:mm',
            'displayEventTime'=> false,
            'timezone' => 'local',
            'eventOverlap' => false,
            //'selectConstraint' => isset($events4)? 'businesshours':null
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'selectOverlap' => 'function(event) {
                    return event.rendering === \'background\';
                }',
            'validRange' => 'function() {console.log(moment().stripTime);return {start: moment().stripTime().subtract('.\Settings::get('courtbooking_past_number_of_days', 0).', \'days\'), end: moment().stripTime().add('.\Settings::get('courtbooking_future_number_of_days', 7).', \'days\')};}',
            'viewRender' => 'function(view,element){if (view.start > moment(\''.$maxdate.'\')){$(\'#calendar-courtbooking\').fullCalendar(\'gotoDate\', moment(\''.$maxdate.'\'));} else if (view.start < moment(\''.$maxdate.'\') < view.end){$(\'.fc-day\').each(function() {if (moment($(this).attr(\'data-date\')) > moment(\''.$maxdate.'\')) {$(this).addClass(\'disabled\');}}); }}',
            'select' => 'function(start, end, jsEvent, view, resource) {if(start.isBefore(moment().minutes(0).seconds(0))) {$(\'#calendar-courtbooking\').fullCalendar(\'unselect\');return false;} $("#newbooking").modal("show"); $("#start1").val(start.format());$("#end2").val(end.format());$("#resourceId").val(resource.id);$("#resourcename").text(resource.title);$("#bookingday").text(moment(start).format("dddd, MMMM DD"));$("#bookingstart").text(moment(start).format("h:mm a"));$("#bookingend").text(moment(end).format("h:mm a"));}',
            'eventClick' => 'function(event) {if (event.url) {$(event.url).modal("show");$("#day").text(event.day);$("#startgroup").text(event.startdisp);$("#endgroup").text(event.enddisp);$("#practiceid").val(event.id);}}',
            'eventRender' => 'function(event, element) {
        var title = element.find(\'.fc-title, .fc-list-item-title\');          
        title.html(title.text());
       element.find(".fc-bg").css("pointer-events","none");
       var calid = $(\'.fc-unthemed\').attr(\'id\');
       if(event.mine || event.partof){
            element.append("<div style=\'position:absolute;top:0px;right:0px;z-index: 10000;\' ><button type=\'button\' class=\'close text-danger btn btnDeleteEvent\' aria-label=\'Cancel Practice\'>&times;</button></div>" );
            if(event.confirmed == false){
                element.append("<div class=\'clearfix\'></div> <a class=\'btn btn-success btn-confirm confirmation\' href=\'/courtbooking/confirm/" + event.id + "\' id=\'204\' role=\'button\'>Confirm</a>");
            }
       }
       
       if(event.confirmed == false){
            element.find(".btn-confirm").click(function(e){
                e.preventDefault();
                clickedbutton = $(this);
                var href = $( this ).attr(\'href\');
                $.ajax({
                    url: href,
                    type: \'GET\',
                    success: function(response){
                        //code to delete confirm button
                        //code to change event color to green
                        clickedbutton.remove();
                        event.color = \'#28a745\';
                        event.confirmed = true;
                        $(\'#calendar-courtbooking\').fullCalendar(\'updateEvent\', event);
                         $(\'#ajaxeditsuccess\').html(response.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function () {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    error:function(data){
                    }
                });
            });
       }
       
       if(event.mine){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to cancel the \' + moment(event.start).format("h:mm a") + \' booking from your schedule?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( data ) {
                        //remove event from calendar
                        $(\'#calendar-courtbooking\').fullCalendar(\'removeEvents\',event._id);
                        //provide confirmation message.
                        $(\'#ajaxeditsuccess\').html(data.message);
                        $(\'#ajaxeditsuccess\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
                        }, 4000);
                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
        if(event.partof){
       element.find(".btnDeleteEvent").click(function(e){
       $.zConfirm({
        title		: \'Cancel Practice?\' ,
        message		: \''.$playersname.', are you sure you want to remove yourself from the \' + moment(event.start).format("h:mm a") + \' from this booking ?\',
        ok			: {
            click	  : function(){
                $.ajax({
                    type: "GET",
                    url: \'/practices/\'+event.id+\'/delete\',
                    error: function( data ) {
                        $(\'#ajaxeditfailure\').html(data.message);
                        $(\'#ajaxeditfailure\').show();
                        setTimeout(function() {
                            $(\'#ajaxeditfailure\').fadeOut(\'slow\');
                        }, 4000);
                    },
                    success: function ( response ) {
                        console.log(response);
            var mEvent = {
                title: response.title,
                allDay: false,
                start: response.start.date,
                end: response.end.date,
                id: response.id,
                color: response.color,
                url: response.url,
                partof: response.partof,
                day: response.day,
                startdisp: response.startdisp,
                enddisp: response.enddisp
            };
            $(\'#addtogroup\').modal(\'hide\');
            $(\'#ajaxeditsuccess\').html(response.message);
            $(\'#ajaxeditsuccess\').show();
            setTimeout(function () {
                $(\'#ajaxeditsuccess\').fadeOut(\'slow\');
            }, 4000);
            $(\'#\' + calid + \'\').fullCalendar(\'removeEvents\', response.id);
            $(\'#\' + calid + \'\').fullCalendar(\'renderEvent\', mEvent, false);
       

                    }
                });
            }
        },
        cancel		: {
            click	  : function(){//
            }
        }
       });      
      });   
            }
       }'])->setId('courtbooking');

        if (!is_null($bookings)) {
            $calendar->addEvents($bookings);
        }

        return view('CourtBooking::scheduler.monitorbookingsheet', compact('calendar'))->with('date', $date);
    }

}